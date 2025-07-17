<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = json_decode(file_get_contents(database_path('data/countries.json')), true);

        foreach ($countries as $c) {
            Country::create([
                'id'           => $c['id'],
                'short_name'   => $c['iso2'],
                'country_name' => $c['name'],
                'flag'         => $c['emoji'] ?? null,
                'slug'         => \Str::slug($c['name']),
                'phonecode'    => $c['phonecode'] ?? null,
                'continent'    => $c['region'] ?? null,
            ]);
        }
    }
}
