<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Factory::create();
        for ($i=0;$i<=10;$i++){
            DB::table('semesters')->insert([
                'semester_number' => $faker->numberBetween(1,100),
            ]);
        }
    }
}
