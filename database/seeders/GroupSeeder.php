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
                'name' => 'Grupo A - Enero 2026',
                'start_date' => '2026-01-20',
                'end_date' => '2026-05-31',
                'enrollment_start_at' => '2026-01-01',
                'enrollment_end_at' => '2026-01-19',
            ],
            [
                'name' => 'Grupo B - Febrero 2026',
                'start_date' => '2026-02-10',
                'end_date' => '2026-06-30',
                'enrollment_start_at' => '2026-01-20',
                'enrollment_end_at' => '2026-02-09',
            ],
            [
                'name' => 'Grupo C - Marzo 2026',
                'start_date' => '2026-03-05',
                'end_date' => '2026-07-31',
                'enrollment_start_at' => '2026-02-10',
                'enrollment_end_at' => '2026-03-04',
            ],
            [
                'name' => 'Grupo D - Abril 2026',
                'start_date' => '2026-04-01',
                'end_date' => '2026-08-31',
                'enrollment_start_at' => '2026-03-05',
                'enrollment_end_at' => '2026-03-31',
            ],
            [
                'name' => 'Grupo E - Mayo 2026',
                'start_date' => '2026-05-15',
                'end_date' => '2026-09-30',
                'enrollment_start_at' => '2026-04-01',
                'enrollment_end_at' => '2026-05-14',
            ],
            [
                'name' => 'Grupo F - Junio 2026',
                'start_date' => '2026-06-10',
                'end_date' => '2026-10-31',
                'enrollment_start_at' => '2026-05-15',
                'enrollment_end_at' => '2026-06-09',
            ],
            [
                'name' => 'Grupo G - Julio 2026',
                'start_date' => '2026-07-01',
                'end_date' => '2026-11-30',
                'enrollment_start_at' => '2026-06-10',
                'enrollment_end_at' => '2026-06-30',
            ],
            [
                'name' => 'Grupo H - Agosto 2026',
                'start_date' => '2026-08-05',
                'end_date' => '2026-12-31',
                'enrollment_start_at' => '2026-07-01',
                'enrollment_end_at' => '2026-08-04',
            ],
            [
                'name' => 'Grupo I - Septiembre 2026',
                'start_date' => '2026-09-10',
                'end_date' => '2027-01-31',
                'enrollment_start_at' => '2026-08-05',
                'enrollment_end_at' => '2026-09-09',
            ],
            [
                'name' => 'Grupo J - Octubre 2026',
                'start_date' => '2026-10-15',
                'end_date' => '2027-02-28',
                'enrollment_start_at' => '2026-09-10',
                'enrollment_end_at' => '2026-10-14',
            ],
            [
                'name' => 'Grupo K - Noviembre 2026',
                'start_date' => '2026-11-01',
                'end_date' => '2027-03-31',
                'enrollment_start_at' => '2026-10-15',
                'enrollment_end_at' => '2026-10-31',
            ],
            [
                'name' => 'Grupo L - Diciembre 2026',
                'start_date' => '2026-12-10',
                'end_date' => '2027-04-30',
                'enrollment_start_at' => '2026-11-01',
                'enrollment_end_at' => '2026-12-09',
            ],
            [
                'name' => 'Grupo M - Enero 2027',
                'start_date' => '2027-01-20',
                'end_date' => '2027-05-31',
                'enrollment_start_at' => '2027-01-01',
                'enrollment_end_at' => '2027-01-19',
            ],
            [
                'name' => 'Grupo N - Febrero 2027',
                'start_date' => '2027-02-15',
                'end_date' => '2027-06-30',
                'enrollment_start_at' => '2027-01-20',
                'enrollment_end_at' => '2027-02-14',
            ],
            [
                'name' => 'Grupo O - Marzo 2027',
                'start_date' => '2027-03-10',
                'end_date' => '2027-07-31',
                'enrollment_start_at' => '2027-02-15',
                'enrollment_end_at' => '2027-03-09',
            ],
            [
                'name' => 'Grupo P - Abril 2027',
                'start_date' => '2027-04-05',
                'end_date' => '2027-08-31',
                'enrollment_start_at' => '2027-03-10',
                'enrollment_end_at' => '2027-04-04',
            ],
            [
                'name' => 'Grupo Q - Mayo 2027',
                'start_date' => '2027-05-10',
                'end_date' => '2027-09-30',
                'enrollment_start_at' => '2027-04-05',
                'enrollment_end_at' => '2027-05-09',
            ],
            [
                'name' => 'Grupo R - Junio 2027',
                'start_date' => '2027-06-15',
                'end_date' => '2027-10-31',
                'enrollment_start_at' => '2027-05-10',
                'enrollment_end_at' => '2027-06-14',
            ],
            [
                'name' => 'Grupo S - Julio 2027',
                'start_date' => '2027-07-05',
                'end_date' => '2027-11-30',
                'enrollment_start_at' => '2027-06-15',
                'enrollment_end_at' => '2027-07-04',
            ],
            [
                'name' => 'Grupo T - Agosto 2027',
                'start_date' => '2027-08-10',
                'end_date' => '2027-12-31',
                'enrollment_start_at' => '2027-07-05',
                'enrollment_end_at' => '2027-08-09',
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