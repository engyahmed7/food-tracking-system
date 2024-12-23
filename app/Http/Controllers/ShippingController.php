<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Nnjeim\World\Models\City;

class ShippingController extends Controller
{
    public function getCountries()
    {
        try {
            $countries = collect(countries())->map(function ($country) {
                return [
                    'code' => $country->getIsoAlpha2(),
                    'name' => $country->getName()
                ];
            })->values()->toArray();

            return response()->json([
                'success' => true,
                'message' => 'countries',
                'data' => $countries,
                'response_time' => now()->diffInMilliseconds(LARAVEL_START) . ' ms'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load countries',
                'data' => [],
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getCities(Request $request)
    {
        $countryCode = $request->input('country');
        $country = country($countryCode);

        if (!$country) {
            return response()->json([]);
        }

        $cities = collect($country->getCities() ?? [])->sort()->values();
        return response()->json($cities);
    }



    public function calculateShipping(Request $request)
    {
        $address = $request->validate([
            'country' => 'required|string',
            'city' => 'required|string',
            'total' => 'required|numeric'
        ]);

        $country = country($address['country']);
        $countryName = $country->getName();

        $zone = Zone::where(function ($query) use ($countryName, $address) {
            $query->whereJsonContains('countries', $countryName)
                ->orWhereJsonContains('cities', $address['city']);
        })->first();

        if (!$zone) {
            return response()->json([
                'error' => 'Shipping not available for this location'
            ], 404);
        }

        $shippingRate = $zone->rates()->first()->rate ?? 0;
        $totalWithShipping = $address['total'] + $shippingRate;

        return response()->json([
            'cart_total' => $address['total'],
            'shipping_rate' => $shippingRate,
            'total_with_shipping' => $totalWithShipping,
            'zone' => $zone->name
        ]);
    }
}
