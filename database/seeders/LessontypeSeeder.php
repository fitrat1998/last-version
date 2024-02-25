<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LessontypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lessontypes')->insert([
            'name' => 'Lekisya',
         ]);
         DB::table('lessontypes')->insert([
            'name' => 'Seminar',
         ]);
    }
}
