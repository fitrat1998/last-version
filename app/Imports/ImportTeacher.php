<?php

namespace App\Imports;

use App\Models\Faculty;
use App\Models\Programm;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Spatie\Permission\Models\Role;
use App\Imports\ImportTeacher;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportTeacher implements WithHeadingRow, ToCollection
{
    /**
     * @param Collection $rows
     *
     * @return void
     */
    public function collection(Collection $rows)
    {

        $faculties = Faculty::all();

        $teacherRole = Role::where('name', 'Teacher')->first();

        if (!$teacherRole) {
            $teacherRole = Role::create([
                'name' => 'Teacher',
                'title' => 'Role for teacher',
            ]);
        }

        $createdTeacher = [];


        foreach ($rows as $row) {
            foreach ($faculties as $faculty) {
                if ($faculty['faculty_name'] == trim($row['fakultet'])) {
                    $f [] = $faculty->id;
                    $existingTeacher = Teacher::where('login', $row['login'])->first();

                    if (!$existingTeacher) {
                        $teacher = Teacher::create([
                            'faculties_id' => $faculty->id,
                            'fullname' => trim($row['fish']),
                            'status' => trim($row['status']),
                            'photo' => trim($row['rasm']),
                            'email' => trim($row['email']),
                            'phone' => trim($row['telefon']),
                            'login' => trim($row['login']),
                            'password' =>trim( $row['parol']),
                        ]);

                        $createdTeacher[] = $teacher;

                        $existingUser = User::where('login', trim($row['login']))->first();

                        if (!$existingUser) {
                            User::create([
                                'login' => trim($row['login']),
                                'password' => Hash::make(trim($row['parol'])),
                                'name' => trim($row['fish']),
                                'teacher_id' => $teacher->id,
                                'theme' => 'default'
                            ]);

                            $teacher->roles()->attach($teacherRole->id);
                        }

                    }


                }

            }
        }

    }
}
