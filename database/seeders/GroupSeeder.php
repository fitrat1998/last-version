<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
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
            DB::table('groups')->insert([
                'name'              => $faker->bloodGroup().'-'.$faker->name,
            ]);
        }
    }
}
