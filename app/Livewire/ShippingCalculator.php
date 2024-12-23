<?php

namespace App\Livewire;

use App\Models\Zone;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Nnjeim\World\World;

class ShippingCalculator extends Component
{
    public $country = '';
    public $city = '';
    public $countries = [];
    public $cities = [];
    public $shippingFee = 0;
    public $cartTotal;
    public $totalWithShipping;
    public $selectedZone = null;
    public $error = '';

    protected $rules = [
        'country' => 'required',
        'city' => 'required|string|min:2'
    ];

    public function mount($cartTotal)
    {
        $this->cartTotal = $cartTotal;
        $this->totalWithShipping = $cartTotal;
        $this->loadCountries();
    }

    public function loadCountries()
    {
        $response = World::countries();

        if ($response->success) {
            $this->countries = collect($response->data)->map(function ($country) {
                return [
                    'code' => $country['id'],
                    'name' => $country['name']
                ];
            })->toArray();
        }
    }


    public function updatedCity()
    {
        if (empty($this->city)) {
            return;
        }


        $cityData = collect($this->cities)
            ->first(function ($city) {
                return strtolower($city['name']) === strtolower(trim($this->city));
            });

        $zoneCityIds = Zone::pluck('cities')
            ->flatten()
            ->map(fn($id) => (string)$id)
            ->toArray();

        if ($cityData !== null) {
            Log::info("Checking city ID:", [
                'cityId' => (string)$cityData['id'],
                'inZone' => in_array((string)$cityData['id'], $zoneCityIds)
            ]);

            if (in_array((string)$cityData['id'], $zoneCityIds)) {
                $this->calculateShipping();
            } else {
                $this->error = 'This city is not available in our shipping zones';
                $this->shippingFee = 0;
                $this->totalWithShipping = $this->cartTotal;
            }
        } else {
            $this->error = 'This city is not available in our shipping zones';
            $this->shippingFee = 0;
            $this->totalWithShipping = $this->cartTotal;
        }
    }




    public function updatedCountry($value)
    {
        $this->cities = [];
        $this->city = '';

        if (!$value) {
            return;
        }

        $response = World::cities([
            'filters' => ['country_id' => $value]
        ]);


        if ($response->success) {
            $zoneCities = Zone::pluck('cities')
                ->flatten()
                ->map(fn($city) => strtolower(trim($city)))
                ->filter()
                ->unique()
                ->toArray();


            $this->cities = collect($response->data)->map(function ($city) {
                return [
                    'id' => $city['id'],
                    'name' => $city['name']
                ];
            })->toArray();


            if (!empty($this->city)) {
                $this->calculateShipping();
            }
        }
    }

    public function loadCities()
    {

        if (!empty($this->country) && strlen($this->city) >= 2) {
            $response = World::cities([
                'country_id' => $this->country,
                'search' => $this->city,
                'per_page' => 10
            ]);

            if (isset($response->success) && $response->success && isset($response->data)) {
                $zoneCities = Zone::pluck('cities')
                    ->flatten()
                    ->unique()
                    ->toArray();

                $this->cities = collect($response->data)
                    ->filter(fn($city) => in_array($city['name'], $zoneCities))
                    ->pluck('name')
                    ->take(10)
                    ->values()
                    ->toArray();
            } else {
                $this->error = 'Could not load cities, please try again later.';
            }
        } else {
            $this->cities = [];
        }
    }

    public function selectCity($city)
    {
        $this->city = $city;
        $this->cities = [];
        $this->validateOnly('city');
        $this->calculateShipping();
    }

    public function calculateShipping()
    {
        $this->validate();

        $countryData = collect($this->countries)
            ->firstWhere('code', (int)$this->country);

        if (!$countryData) {
            $this->error = 'Invalid country selected';
            return;
        }

        $countryId = (int)$this->country;

        $cityData = collect($this->cities)
            ->firstWhere('name', $this->city);

        if (!$cityData) {
            $this->error = 'Invalid city selected';
            return;
        }

        $cityId = (string)$cityData['id'];


        $allZones = Zone::all();


        $zonesByCountry = Zone::where(function ($query) use ($countryId) {
            $query->whereJsonContains('countries', $countryId)
                ->orWhereJsonContains('countries', (string)$countryId)
                ->orWhereRaw('JSON_CONTAINS(countries, ?)', [$countryId])
                ->orWhereRaw('JSON_CONTAINS(countries, ?)', [(string)$countryId]);
        })->get();


        $zone = $zonesByCountry->first(function ($zone) use ($cityId) {
            $zoneCities = collect($zone->cities);
            return $zoneCities->contains($cityId) || $zoneCities->contains((string)$cityId);
        });

        if ($zone) {
            $shippingRate = $zone->rates()->first();
            if ($shippingRate) {
                $this->selectedZone = $zone->name;
                $this->shippingFee = $shippingRate->rate;
                $this->totalWithShipping = $this->cartTotal + $this->shippingFee;

                $this->dispatch('shipping-calculated', [
                    'shippingFee' => $this->shippingFee,
                    'total' => $this->totalWithShipping
                ]);

                $this->error = '';
            } else {
                $this->error = 'No shipping rates available for this zone';
                $this->resetShippingCalculations();
            }
        } else {
            $this->error = 'No zone found for the selected city and country';
            $this->resetShippingCalculations();
        }
    }

    public function render()
    {
        return view('livewire.shipping-calculator');
    }
}
