<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\Country;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        City::factory()->count(300)->create(); //ini buat generate 300 data city pake factory CityFactory
        Country::factory()->count(120)->create(); //ini buat generate 120 data country pake factory CountryFactory
    }
}
