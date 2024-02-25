<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $subjectIds = DB::table('subjects')->pluck('id');

        foreach ($subjectIds as $subjectId) {
            foreach (range(1, 5) as $index) {
                DB::table('topics')->insert([
                    'subject_id' => $subjectId,
                    'topic_name' => $faker->word,
                ]);
            }
        }
    }
}
