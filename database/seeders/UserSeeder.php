<?php

namespace Database\Seeders;

use App\Http\Controllers\Auth\RegisterController;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $register = new RegisterController();
        $register->create([
            'name' => $faker->name,
            'login' => 'user',
            'password' => Hash::make('password'),
            'theme' => 'default',
        ]);
    }
}
