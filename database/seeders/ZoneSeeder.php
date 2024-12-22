<?php

namespace Database\Seeders;

use App\Models\Zone;
use App\Models\ZoneShippingRate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $zones = [
            ['name' => 'San Stefano Mall', 'rate' => 10.00],
            ['name' => 'Miami', 'rate' => 15.00],
            ['name' => 'Gleem', 'rate' => 25.00],
            ['name' => 'Sidi Gaber', 'rate' => 35.00],
        ];

        foreach ($zones as $zoneData) {
            $zone = Zone::create(['name' => $zoneData['name']]);
            ZoneShippingRate::create(['zone_id' => $zone->id, 'rate' => $zoneData['rate']]);
        }
    }
}
