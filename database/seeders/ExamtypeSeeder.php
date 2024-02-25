<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamtypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $examTypes = [];

        for ($i = 1; $i <= 10; $i++) {
            $examTypes[] = [
                'name' => $faker->word,
            ];
        }

        DB::table('examtypes')->insert($examTypes);
    }
}
