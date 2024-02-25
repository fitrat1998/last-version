<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SelfStudyExamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 50) as $index) {
            DB::table('selfstudyexams')->insert([
                'number'        => $index,
                'examtypes_id'  => rand(1, 5),
                'subjects_id'   => rand(1, 20),
                'groups_id'     => rand(1, 10),
                'semesters_id'  => rand(1, 2),
                'start'         => now(),
                'end'           => now()->addDays(rand(1, 30)),
            ]);
        }
    }
}
