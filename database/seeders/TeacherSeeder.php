<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $teacher = Teacher::create([
            'first_name'    => $faker->firstName,
            'last_name'     => $faker->lastName,
            'status'        => $faker->streetAddress(),
            'photo'         => $faker->image,
            'email'         => $faker->email(),
            'phone'         => $faker->phoneNumber(),
            'login'         => 'teacher',
            'password'      => Hash::make('teacher123')
        ]);

        $teacher->assignRole('Teacher');
    }
}
