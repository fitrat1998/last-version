<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgrammSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        for ($i=0;$i<=100;$i++){
            DB::table('programms')->insert([
                'programm_name' => $faker->name,
                'faculty_id'    => $faker->numberBetween(1, 100)
            ]);
        }
    }
}
