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
use Illuminate\Http\Request;
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

    public function index(Request $request)
    {
        $subject_id = $request->get('subject');

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

        $result = Result::where('users_id', $student->id)->get();
        if ($result) {
            $student_id = auth()->user()->student_id ?? 0;

            $student = DB::table('student_has_attach')->where('students_id', $student_id)->first();

            $subject = DB::table('subject_has_group')->where('groups_id', $student->groups_id)->pluck('subjects_id');

            $exam_id = DB::table('selfstudyexams')->whereIn('subjects_id', $subject)->pluck('id');

            $subjects_name = Subject::whereIn('id', $subject)->get();

            $sumselfstudy = [];
            $sum = 0;

            foreach ($exam_id as $e) {
                $result = Result::where('exams_id', $e)->where('users_id', $user)->max('ball');
                $sum += $result;
                $sumselfstudy["data"][] = [
                    "examp_id" => $e,
                    "max_result" => $result ?? 0
                ];
            }
        }
        $sumselfstudy["sum"] = $sum;

        $examTypes = Examtype::pluck('id');
        $result = Result::where('users_id', auth()->user()->id)->get();
        $results = [];

        $userId = auth()->user()->id;

        $results = Result::select('users_id', 'examtypes_id', 'subjects_id', DB::raw('MAX(ball) as max_ball'), DB::raw('MAX(created_at) as latest_created_at'))
            ->groupBy('users_id', 'examtypes_id', 'subjects_id')
            ->where('users_id', $userId)
            ->orderByDesc('max_ball')
            ->get();


//        dd($results);
//        exit;
//        dd($subjects);
        return view('students.index', compact('subjects', 'announcements', 'sumselfstudy', 'results'));

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

        $data_mi = [];
        $data_on = [];
        $data_jn = [];
        $data_yn = [];

        foreach ($subjects as $subjects_id) {

            $resultsMI = Result::where('subjects_id', $subjects_id->id)
                ->where('users_id', $user)
                ->where('examtypes_id', 2)
                ->get();

            $sum = 0;

            if ($resultsMI->isNotEmpty()) {
                $ry = $resultsMI->pluck('quizzes_id')->unique();

                foreach ($ry as $q) {
                    $rx = $resultsMI->where('quizzes_id', $q)->max('ball') * 10;
                    $sum += $rx;
                }

                $data_mi[] = [
                    'user' => $user->name ?? null,
                    'ball' => $sum,
                    'type' => 4
                ];
            } else {
                $data_mi[] = [
                    'user' => $user->name ?? null,
                    'ball' => 0,
                    'type' => 4
                ];
            }
        }

        foreach ($subjects as $subjects_id) {

            $results2 = Result::where('subjects_id', $subjects_id->id)
                ->where('users_id', $user)
                ->where('examtypes_id', 1)
                ->get();

            $sum2 = 0;

            if ($results2->isNotEmpty()) {
                $quizs = $results2->pluck('quizzes_id')->unique();

                foreach ($quizs as $q) {
                    $rx = Result::where('subjects_id', $subjects_id->id)
                            ->where('users_id', $user)
                            ->where('examtypes_id', 1)
                            ->where('quizzes_id', $q)
                            ->max('ball') * 10;

                }

                $data_on[] = [
                    'user' => $user->name ?? null,
                    'ball' => $rx,
                    'type' => 4
                ];
            } else {
                $data_on[] = [
                    'user' => $user->name ?? null,
                    'ball' => 0,
                    'type' => 4
                ];
            }
        }

        foreach ($subjects as $subjects_id) {

            $results2 = Result::
            where('users_id', $user)
                ->where('examtypes_id', 5)
                ->get();

            $sum2 = 0;

            if ($results2->isNotEmpty()) {
                $quizs = $results2->pluck('quizzes_id')->unique();

                foreach ($quizs as $q) {
                    $rx = Result::where('subjects_id', $subjects_id->id)
                            ->where('users_id', $user)
                            ->where('examtypes_id', 5)
                            ->where('quizzes_id', $q)
                            ->max('ball') * 10;
                }

                $data_jn[] = [
                    'user' => $user->name ?? null,
                    'ball' => $rx,
                    'type' => 4
                ];
            } else {
                $data_jn[] = [
                    'user' => $user->name ?? null,
                    'ball' => 0,
                    'type' => 4
                ];
            }
        }

        foreach ($subjects as $subjects_id) {

            $results2 = Result::
            where('users_id', $user)
                ->where('examtypes_id', 4)
                ->get();

            $sum2 = 0;

            if ($results2->isNotEmpty()) {
                $quizs = $results2->pluck('quizzes_id')->unique();

                foreach ($quizs as $q) {
                    $rx = Result::where('subjects_id', $subjects_id->id)
                            ->where('users_id', $user)
                            ->where('examtypes_id', 4)
                            ->where('quizzes_id', $q)
                            ->max('ball') * 10;
                }

                $data_yn[] = [
                    'user' => $user->name ?? null,
                    'ball' => $rx,
                    'type' => 4
                ];
            } else {
                $data_yn[] = [
                    'user' => $user->name ?? null,
                    'ball' => 0,
                    'type' => 4
                ];
            }
        }
        $data = [];

        for ($i = 0; $i < count($data_mi); $i++) {
            $data[] = [
                'name' => $data_mi[$i]['user'] ?? null,
                'ball_mi' => $data_mi[$i]['ball'] ?? null,
                'ball_on' => $data_on[$i]['ball'] ?? null,
                'ball_jn' => $data_jn[$i]['ball'] ?? null,
            ];
        }

        $subjects_sums = [];
        $test = [];
        foreach ($subjects as $subjects_id) {
            $sum_mi = 0;
            $sum_on = 0;
            $sum_jn = 0;
            $sum_yn = 0;

            // Summa hisoblanishi
            foreach ($data_mi as $data) {
                if ($data['ball'] > 0) {
                    $sum_mi += $data['ball'];
                }
            }

            foreach ($data_on as $data) {
                if ($data['ball'] > 0) {
                    $sum_on += $data['ball'];
                }
            }

            foreach ($data_jn as $data) {
                if ($data['ball'] > 0) {
                    $sum_jn += $data['ball'];
                }
            }

            foreach ($data_yn as $data) {
                if ($data['ball'] > 0) {
                    $sum_yn += $data['ball'];
                }
            }

            $total_sum = $sum_mi + $sum_on + $sum_jn + $sum_yn;
            if (($total_sum / 10) > 30) {
                $finalexams [] = Finalexam::where('subjects_id', $subjects_id->id)
                    ->where('groups_id', $attached->groups_id)
                    ->get();
            } else {
                $finalexams = [];
            }

        }




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
