<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id',
        'quizzes_id',
        'subjects_id',
        'topics_id',
        'exams_id',
        'semesters_id',
        'correct',
        'incorrect',
        'examtypes_id',
        'ball'
    ];

    public function examps()
    {
        $quiz = $this->quizzes_id;
        $type_id = $this->examtypes_id;

        if($type_id == 1){
            $examp = Middleexam::find($quiz);
        }
        else if($type_id == 2){
            $examp = Selfstudyexams::find($quiz);
        }
        else if($type_id == 3){
            $examp = Retriesexam::find($quiz);
        }
        else if($type_id == 4){
            $examp = Finalexam::find($quiz);
        }
        else if($type_id == 5){
            $examp = Currentexam::find($quiz);
        }
        // dd($examp);     
        if($examp){
            $topics_id = DB::table('exam_has_topic')->where('exams_id',$examp->id)->pluck('topics_id');
        }
        else {
            $topics_id = [];
        }
        if($topics_id){
            $topics = Topic::whereIn('id',$topics_id)->pluck('topic_name');
        }
        else {
            $topics = ['mavjud emas'];
        }

        return $topics;
    }

    public function examtype($id)
    {
        if ($id == 1) {
            $exam = Examtype::find($id);
        } else if ($id == 2) {
            $exam = Examtype::find($id);
        } else if ($id == 3) {
            $exam = Examtype::find($id);
        } else if($id == 4) {
            $exam = Examtype::find($id);
        } else {
            $exam = Examtype::find($id);
        }

        return $exam;
    }

    public function examtypes($id, $subjects_id)
    {
        $exam = null;
        if (!empty($subjects_id) && !empty($id)) {
            if ($id == 1) {
                $exam = Middleexam::where('id', $id)
                    ->where('subjects_id', $subjects_id)
                    ->first();
            } elseif ($id == 2) {
                $exam = Selfstudyexams::where('id', $id)
                    ->where('subjects_id', $subjects_id)
                    ->first();
            } elseif ($id == 3) {
                $exam = Retriesexam::where('id', $id)
                    ->where('subjects_id', $subjects_id)
                    ->first();
            } elseif($id == 4) {
                $exam = Finalexam::where('id', $id)
                    ->where('subjects_id', $subjects_id)
                    ->first();
            } else{
                $exam = Currentexam::where('id', $id)
                    ->where('subjects_id', $subjects_id)
                    ->first();
            }
        }
        return $exam;
    }


    public function results($id)
    {
        if ($id == 1) {
            $result = Result::where('examtypes_id', $id)
                ->orderBy('created_at', 'desc')
                ->get()
                ->first();

        } else if ($id == 2) {
            $result = Result::where('examtypes_id', $id)
                ->orderBy('created_at', 'desc')
                ->get()
                ->first();
        } else if ($id == 3) {
            $result = Result::where('examtypes_id', $id)
                ->orderBy('created_at', 'desc')
                ->get()
                ->first();
        } else {
            $result = Result::where('examtypes_id', $id)
                ->orderBy('created_at', 'desc')
                ->get()
                ->first();
        }

        return $result;
    }



    public function subject($id)
    {
        $subject = Subject::find($id);

        return $subject->subject_name;
    }


    public function semester($id)
    {
        $semester = Semester::find($id);

        return $semester->semester_number;
    }


    public function student($id)
    {
        $user = User::find($id);

        if ($user) {
            $students = DB::table('student_has_attach')
                ->where('students_id', $user->student_id)
                ->first();

            if ($students) {
                $student = Student::select('id', 'fullname')->find($students->students_id);
                return $student;
            } else {
                return "Bunda ma'lumot topilmadi";
            }
        } else {
            return "Foydalanuvchi topilmadi yoki noto'g'ri ID kiritildi!";
        }
    }


   public function group($id)
   {
        $user = User::find($id);

       $students = DB::table('student_has_attach')
                ->where('students_id', $user->student_id)
                ->first();

        if ($students) {
            $group = Group::select('id', 'name')->find($students->groups_id);
            return $group;
        } else {
            return "Bunda ma'lumot topilmadi";
        }
    }
}
