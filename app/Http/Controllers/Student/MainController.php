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

        }
        else {
            $subjects = [];
        }


        $examTypes = Examtype::pluck('id');
        $results = [];

        foreach ($examTypes as $examTypeId) {
            $latestResult = Result::where('examtypes_id', $examTypeId)
                ->latest('id')
                ->first();

            if (!is_null($latestResult)) {
                $results[] = $latestResult;
            }
        }

        return view('students.index', compact('subjects', 'announcements', 'results'));

    }

    public function subjects()
    {
        $subjects = Subject::all();

        return view('students.subject', compact('subjects'));
    }

    public function selfstudy()
    {
        $selfstudies = Selfstudyexams::all();
        return view('students.selfstudy', compact('selfstudies'));
    }

    public function middleexam()
    {
        $middleexams = Middleexam::all();
        return view('students.middleexam', compact('middleexams'));
    }

    public function finalexam()
    {
        $finalexams = Finalexam::all();
        return view('students.finalexam', compact('finalexams'));
    }

    public function currentexam()
    {
        $currentexams = Currentexam::all();

        return view('students.currentexam', compact('currentexams'));
    }

    public function retry()
    {
        $retries = Retriesexam::all();
        $user_id = User::find(auth()->user()->id);


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

//        dd($results[0]->correct);

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
