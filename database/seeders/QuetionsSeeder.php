<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuetionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $topicIds = DB::table('topics')->pluck('id');

        foreach ($topicIds as $topicId) {
            foreach (range(1, 3) as $index) {
                DB::table('questions')->insert([
                    'topic_id' => $topicId,
                    'question' => $faker->sentence,
                ]);
            }
        }
    }
}
