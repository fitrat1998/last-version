<?php

namespace Database\Seeders;

use App\Models\Student;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        foreach (range(1, 50) as $index) {
            DB::table('students')->insert([
                'programm_id' => $faker->numberBetween(1, 10),
<<<<<<< HEAD
                'fullname' => $faker->name(),
=======
                'fullname' => $faker->firstName,
>>>>>>> 2e531c5b19ab1837b34c9c69873f42b6068963fe
                'photo' => $faker->imageUrl(),
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
                'login' => $faker->userName,
                'password' => bcrypt('password'),
            ]);
        }
    }
}
