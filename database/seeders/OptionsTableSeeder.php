<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $questionIds = DB::table('questions')->pluck('id');

        foreach ($questionIds as $questionId) {
            foreach (range(1, 4) as $index) {
                DB::table('options')->insert([
                    'question_id' => $questionId,
                    'option' => $faker->sentence,
                    'is_correct' => $index == 1,
                    'difficulty' => $faker->randomElement([10,20,30,40,50,60,70,80,90,100]),
                ]);
            }
        }
    }
}
