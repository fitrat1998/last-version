<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Attendancecheck;
use App\Models\Currentexam;
use App\Models\Examtype;
use App\Models\Exercise;
use App\Models\Faculty;
use App\Models\Finalexam;
use App\Models\Group;
use App\Models\User;
use App\Models\Middleexam;
use App\Models\Programm;
use App\Models\Result;
use App\Models\Lessontype;
use App\Models\Retriesexam;
use App\Models\Selfstudyexams;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Support\Facades\DB;
use function view;

class MainController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user()->id;
        // $subjects = Subject::all();
        $announcements = Announcement::all();

        $student = User::find($user);

        $attached = DB::table('student_has_attach')
            ->where('students_id', $student->student_id)
            ->first();


        if ($attached) {
            $attached_subject = DB::table('subject_has_group')
                ->where('groups_id', $attached->groups_id)
                ->get();

            $attached_subject = $attached_subject->pluck('subjects_id')->toArray();

            if ($attached_subject) {
                $subjects = Subject::whereIn('id', $attached_subject)
                    ->get();

            }

        } else {
            $subjects = [];
        }


        $examTypes = Examtype::pluck('id');

        $result = Result::where('users_id', $student->id)
//            ->whereIn('subjects_id',$subject_ids)
            ->get();
         $subject_ids = $result->pluck('subjects_id');

        $results = [];
        $topics = [];

//        dd($result);
        foreach ($examTypes as $examTypeId) {

            $latestResult = $result->where('examtypes_id', $examTypeId)->max('ball');
            $latestResultData = $result->where('examtypes_id', $examTypeId)->where('ball', $latestResult)->first();


            if ($latestResultData) {
                $results[] = $latestResultData;
            }

            if ($examTypeId == 2) {
                $sumOfScoresForExamType2 = $result->sum('ball');
            }
        }

        foreach ($examTypes as $examTypeId) {
              $sumselfstudy = Result::where('users_id', $student->id)
                  ->where('examtypes_id',2)
                  ->sum('ball');
        }
//        dd($results);
        return view('students.index', compact('subjects', 'announcements', 'results','sumselfstudy'));

    }

    public function subjects()
    {
        $user = auth()->user()->id;
        // $subjects = Subject::all();
        $announcements = Announcement::all();

        $student = User::find($user);

        $attached = DB::table('student_has_attach')
            ->where('students_id', $student->student_id)
            ->first();


        if ($attached) {
            $attached_subject = DB::table('subject_has_group')
                ->where('groups_id', $attached->groups_id)
                ->get();

            $attached_subject = $attached_subject->pluck('subjects_id')->toArray();

            if ($attached_subject) {
                $subjects = Subject::whereIn('id', $attached_subject)
                    ->get();

            }

        } else {
            $subjects = [];
        }

        return view('students.subject', compact('subjects'));
    }

    public function selfstudy()
    {
        $user = auth()->user()->id;

        $student = User::find($user);

        $attached = DB::table('student_has_attach')
            ->where('students_id', $student->student_id)
            ->first();

        $selfstudies = Selfstudyexams::where('groups_id', $attached->groups_id)->get();

        return view('students.selfstudy', compact('selfstudies'));
    }

    public function middleexam()
    {
        $user = auth()->user()->id;

        $student = User::find($user);

        $attached = DB::table('student_has_attach')
            ->where('students_id', $student->student_id)
            ->first();

//        dd($attached);

        $middleexams = Middleexam::where('groups_id', $attached->groups_id)->get();
        return view('students.middleexam', compact('middleexams'));
    }

    public function finalexam()
    {
        $user = auth()->user()->id;

        $student = User::find($user);

        $attached = DB::table('student_has_attach')
            ->where('students_id', $student->student_id)
            ->first();

        $finalexams = Finalexam::where('groups_id', $attached->groups_id)->get();
        return view('students.finalexam', compact('finalexams'));
    }

    public function currentexam()
    {
        $user = auth()->user()->id;

        $student = User::find($user);

        $attached = DB::table('student_has_attach')
            ->where('students_id', $student->student_id)
            ->first();

        $currentexams = Currentexam::where('groups_id', $attached->groups_id)->get();

        return view('students.currentexam', compact('currentexams'));
    }

    public function retry()
    {

        $user_id = User::find(auth()->user()->id);


        $attached = DB::table('student_has_attach')
            ->where('students_id', $user_id->student_id)
            ->first();


        $retries = Retriesexam::where('groups_id', $attached->groups_id)->get();


        if ($user_id) {
            $absents = Attendancecheck::where('students_id', $user_id->student_id)->get();

            $subjects = [];
            $exercises = [];
            $lessons = [];
            $topics = [];

            foreach ($absents as $absent) {
                $subject = Subject::where('id', $absent->subjects_id)->first();

                $exercise = Exercise::where('id', $absent->exercises_id)->first();
                if ($subject) {
                    $subjects[] = $subject;
                }

                if ($exercise) {
                    $exercises [] = $exercise;
                }
            }

            foreach ($exercises as $e) {
                $lesson = Lessontype::find($e->lessontypes_id)->first();
                $topic = Topic::find($e->topics_id)->first();

                if ($lesson) {
                    $lessons [] = $lesson;
                }

                if ($topic) {
                    $topics [] = $topic;
                }
            }


        }


        return view('students.retry', compact('retries', 'absents', 'subjects', 'exercises', 'topics', 'lessons'));
    }

    public function result()
    {
        $user_id = auth()->user()->id;

        $results = Result::where('users_id', $user_id)->get();


        return view('students.result', compact('results'));
    }

    public function profile()
    {
        $user = auth()->user()->student_id;
        $student = Student::find($user);

        $users = DB::table('student_has_attach')
            ->where('students_id', $user)
            ->get();
        $faculty = Faculty::find($users[0]->faculties_id);
        $group = Group::find($users[0]->groups_id);
        $programm = Programm::find($student->programm_id);

        return view('students.profile', compact('student', 'faculty', 'programm', 'group'));
    }
}
