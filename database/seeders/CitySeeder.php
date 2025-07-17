<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = json_decode(File::get(database_path('data/cities.json')), true);

        $batchSize = 100;
        $batch = [];

        foreach ($cities as $index => $c) {
            $batch[] = [
                'id'         => $c['id'],
                'name'       => $c['name'],
                'state_id'   => $c['state_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($batch) === $batchSize) {
                DB::table('cities')->insert($batch);
                unset($batch);
                $batch = [];
                gc_collect_cycles();
            }
        }

        if (!empty($batch)) {
            DB::table('cities')->insert($batch);
        }

    }
}
