<?php

namespace Database\Seeders;
use Database\Seeders\TeacherSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\GroupSeeder;
use Database\Seeders\TopicSeeder;
use Database\Seeders\FacultySeeder;
use Database\Seeders\SubjectSeeder;
use Database\Seeders\ProgrammSeeder;
use Database\Seeders\SemesterSeeder;
use Database\Seeders\AttendanceLogSeeder;
use Database\Seeders\EducationtypeSeeder;
use Database\Seeders\FormofeducationSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            FacultySeeder::class,
        ]);

        $this->call([
            ProgrammSeeder::class,
        ]);

        $this->call([
            EducationtypeSeeder::class,
        ]);

        $this->call([
            FormofeducationSeeder::class
        ]);

        $this->call([
            EducationyearSeeder::class
        ]);

        $this->call([
            SemesterSeeder::class
        ]);

        $this->call([
            LessonSeeder::class
        ]);

        $this->call([
            GroupSeeder::class
        ]);

        $this->call([
            SubjectSeeder::class
        ]);

        $this->call([
            TopicSeeder::class
        ]);

        $this->call([
            QuetionsSeeder::class
        ]);

        $this->call([
            OptionsTableSeeder::class
        ]);

//        $this->call([
//            StudentSeeder::class
//        ]);

        $this->call([
            SubjectHasGroupTableSeeder::class
        ]);

        $this->call([
            ExamtypeSeeder::class
        ]);

        $this->call([
            SelfStudyExamsTableSeeder::class
        ]);
    }

}
