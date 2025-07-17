<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $states = json_decode(file_get_contents(database_path('data/states.json')), true);

        foreach ($states as $s) {
            State::create([
                'id'         => $s['id'],
                'name'       => $s['name'],
                'country_id' => $s['country_id'],
            ]);
        }
    }
}
