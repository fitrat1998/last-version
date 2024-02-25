<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EducationyearSeeder extends Seeder
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
            DB::table('educationyears')->insert([
                'education_year' => $faker->dateTimeThisCentury->format('Y') . '-'.$faker->dateTimeThisCentury->format('Y'),
            ]);
        }
    }
}
