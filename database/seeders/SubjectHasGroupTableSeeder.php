<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectHasGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 50) as $index) {
            DB::table('subject_has_group')->insert([
                'groups_id' => rand(1, 10),
                'subjects_id' => rand(1, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
