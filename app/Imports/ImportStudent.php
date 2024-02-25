<?php

namespace App\Imports;

use App\Models\Programm;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Spatie\Permission\Models\Role;

class ImportStudent implements WithHeadingRow, ToCollection
{
    /**
     * @param Collection $rows
     *
     * @return void
     */
    public function collection(Collection $rows)
    {
        $programs = Programm::all();

        // Student rolini olish yoki yaratish
        $studentRole = Role::where('name', 'Student')->first();
        if (!$studentRole) {
            $studentRole = Role::create([
                'name' => 'Student',
                'title' => 'Role for student',
            ]);
        }

        foreach ($rows as $row) {
            $programName = trim($row['yonalish']);
            $program = Programm::where('programm_name', $programName)->first();

            if ($program) {
                // Student mavjudligini tekshirish
                $existingStudent = Student::where('login', $row['login'])->first();
                if (!$existingStudent) {
                    $student = Student::create([
                        'programm_id' => $program->id,
                        'fullname' => trim($row['fish']),
                        'photo' => trim($row['rasm']),
                        'email' => trim($row['email']),
                        'phone' => trim($row['telefon']),
                        'login' => trim($row['login']),
                        'password' => trim($row['parol']),
                    ]);

                    // Foydalanuvchi mavjudligini tekshirish
                    $existingUser = User::where('login', $row['login'])->first();
                    if (!$existingUser) {
                        $user = User::create([
                            'login' => trim($row['login']),
                            'password' => Hash::make(trim($row['parol'])),
                            'name' => trim($row['fish']),
                            'student_id' => $student->id,
                            'theme' => 'default'
                        ]);

                        // Foydalanuvchi rolini yuklash
                        $user->assignRole($studentRole);
                    }
                }
            }
        }
    }

}
