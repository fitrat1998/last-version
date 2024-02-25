<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()['cache']->forget('spatie.permission.cache');

        Role::create(['name' => 'Teacher','title' => "Teacher",'guard_name' => 'teacher']);
        Role::create(['name' => 'Student','title' => "Student",'guard_name' => 'student']);
        Role::create(['name' => 'Super Admin','title'   => 'Super Admin','guard_name' => 'web']);
    }
}
