<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    public function run()
    {
        $groups = [
            [
                'name' => 'ciclo escolar A - Enero 2026',
                'start_date' => '2026-01-20',
                'end_date' => '2026-05-31',
                'enrollment_start_at' => '2026-01-01',
                'enrollment_end_at' => '2026-01-19',
            ],
            [
                'name' => 'ciclo escolar B - Febrero 2026',
                'start_date' => '2026-02-10',
                'end_date' => '2026-06-30',
                'enrollment_start_at' => '2026-01-20',
                'enrollment_end_at' => '2026-02-09',
            ],
            [
                'name' => 'ciclo escolar C - Marzo 2026',
                'start_date' => '2026-03-05',
                'end_date' => '2026-07-31',
                'enrollment_start_at' => '2026-02-10',
                'enrollment_end_at' => '2026-03-04',
            ],
            [
                'name' => 'ciclo escolar D - Abril 2026',
                'start_date' => '2026-04-01',
                'end_date' => '2026-08-31',
                'enrollment_start_at' => '2026-03-05',
                'enrollment_end_at' => '2026-03-31',
            ],
            [
                'name' => 'ciclo escolar E - Mayo 2026',
                'start_date' => '2026-05-15',
                'end_date' => '2026-09-30',
                'enrollment_start_at' => '2026-04-01',
                'enrollment_end_at' => '2026-05-14',
            ],
        ];

        foreach ($groups as $group) {
            Group::create([
                'name' => $group['name'],
                'start_date' => $group['start_date'],
                'end_date' => $group['end_date'],
                'enrollment_start_at' => $group['enrollment_start_at'],
                'enrollment_end_at' => $group['enrollment_end_at'],
                'status' => 1,
            ]);
        }
    }
}