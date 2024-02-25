<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendanceLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('attendance_logs')->insert([
            'group_id' => 1,
            'subject_id' => 1,
            'educationyear_id' => 1,
            'semester_id' => 1,
            'lessontype_id' => 1,
            'teacher_id' => 1,
         ]);
    }
}
