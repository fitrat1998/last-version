<?php

namespace App\Http\Controllers;

use App\Models\Currentexam;
use App\Models\Examtype;
use App\Models\Finalexam;
use App\Models\Group;
use App\Models\Middleexam;
use App\Models\Options;
use App\Models\Programm;
use App\Models\Question;
use App\Models\Faculty;
use App\Models\Result;
use App\Http\Requests\StoreResultRequest;
use App\Http\Requests\UpdateResultRequest;
use App\Models\Retriesexam;
use App\Models\Selfstudyexams;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        abort_if_forbidden('result.show');

        $role = auth()->user()->roles->pluck('name');
        $user = auth()->user()->id;

        $t_id = User::find($user);


        if ($role[0] == 'teacher') {

            $group = DB::table('teacher_has_group')->where('teachers_id', $t_id->teacher_id)->pluck('groups_id');

            $groups = Group::whereIn('id', $group)->get();

            $idArray = $groups->pluck('id')->toArray();


        } else if (auth()->user()->roles->pluck('name')[0] == 'Super Admin') {
            $groups = Group::all();
        }

        $results = Result::all();


        if ($role[0] == 'teacher') {
            $student = Student::where('user_id', $t_id->id)->pluck('programm_id');
            $programms = Programm::find($student);


        } else if (auth()->user()->roles->pluck('name')[0] == 'Super Admin') {
            $programms = Programm::all();

        }

        return view('pages.results.index', compact('programms', 'results'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if_forbidden('result.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreResultRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreResultRequest $request)
    {
        abort_if_forbidden('result.create');

        $results = Result::create([
            'users_id',
            'quizzes_id',
            'subjects_id',
            'semesters_id',
            'is_corrects',
            'examtypes_id'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Result $result
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $subjects_id = intval($request->input('subjects_id'));
        $group_id = intval($request->input('group_id'));
        $programm_id = intval($request->input('programm_id'));
        $educationyear_id = intval($request->input('educationyear_id'));


        $students = Student::where('programm_id', $programm_id)->pluck('id');

        $users = User::whereIn('student_id', $students)->pluck('id');

        $groups = DB::table('subject_has_group')->where('subjects_id', $subjects_id)
            ->where('groups_id', $group_id)
            ->get()
            ->pluck('groups_id');

        $users_id = User::all()->pluck('id');

        $results = DB::table('results')
            ->select('subjects_id', 'users_id', 'quizzes_id', DB::raw('MAX(ball) as max_ball'))
            ->groupBy('subjects_id', 'users_id', 'quizzes_id')
            ->get();

        $mi = 2;
        $on = 1;
        $jn = 5;
        $yn = 4;

        $sum = 0;

        $data_mi = [];
        $data_on = [];
        $data_jn = [];
        $datayn_yn = [];

        $g = [];

        $group = DB::table('student_has_attach')
            ->where('groups_id', $group_id)
            ->where('educationyears_id', $educationyear_id)
            ->pluck('students_id');

        $examtypes = Examtype::all();


        foreach ($group as $uid) {
            $user = User::where('student_id', $uid)->first();

            $resultsMI = Result::where('subjects_id', $subjects_id)
                ->where('users_id', $user->id)
                ->where('examtypes_id', $mi)
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

        foreach ($group as $uid2) {
            $user2 = User::where('student_id', $uid2)->first();

            $results2 = Result::
            where('users_id', $user2->id)
                ->where('examtypes_id', 1)
                ->get();

            $sum2 = 0;

            if ($results2->isNotEmpty()) {
                $quizs = $results2->pluck('quizzes_id')->unique();

                foreach ($quizs as $q) {
                    $rx = Result::where('subjects_id', $subjects_id)
                            ->where('users_id', $user2->id)
                            ->where('examtypes_id', 1)
                            ->where('quizzes_id', $q)
                            ->max('ball') * 10;

                }

                $data_on[] = [
                    'user' => $user2->name ?? null,
                    'ball' => $rx,
                    'type' => 4
                ];
            } else {
                $data_on[] = [
                    'user' => $user2->name ?? null,
                    'ball' => 0,
                    'type' => 4
                ];
            }
        }

        foreach ($group as $uid2) {
            $user2 = User::where('student_id', $uid2)->first();

            $results2 = Result::
            where('users_id', $user2->id)
                ->where('examtypes_id', 5)
                ->get();

            $sum2 = 0;

            if ($results2->isNotEmpty()) {
                $quizs = $results2->pluck('quizzes_id')->unique();

                foreach ($quizs as $q) {
                    $rx = Result::where('subjects_id', $subjects_id)
                            ->where('users_id', $user2->id)
                            ->where('examtypes_id', 5)
                            ->where('quizzes_id', $q)
                            ->max('ball') * 10;
                }

                $data_jn[] = [
                    'user' => $user2->name ?? null,
                    'ball' => $rx,
                    'type' => 4
                ];
            } else {
                $data_jn[] = [
                    'user' => $user2->name ?? null,
                    'ball' => 0,
                    'type' => 4
                ];
            }
        }

        foreach ($group as $uid2) {
            $user2 = User::where('student_id', $uid2)->first();

            $results2 = Result::
            where('users_id', $user2->id)
                ->where('examtypes_id', 4)
                ->get();

            $sum2 = 0;

            if ($results2->isNotEmpty()) {
                $quizs = $results2->pluck('quizzes_id')->unique();

                foreach ($quizs as $q) {
                    $rx = Result::where('subjects_id', $subjects_id)
                            ->where('users_id', $user2->id)
                            ->where('examtypes_id', 4)
                            ->where('quizzes_id', $q)
                            ->max('ball') * 10;
                }

                $data_yn[] = [
                    'user' => $user2->name ?? null,
                    'ball' => $rx,
                    'type' => 4
                ];
            } else {
                $data_yn[] = [
                    'user' => $user2->name ?? null,
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
                'ball_yn' => $data_yn[$i]['ball'] ?? null,
            ];
        }


        return response()->json($data);


//        $users = User::all();
//        $examtypes = Examtype::all();
//
//        $data = [];
//        foreach ($users as $user) {
//            foreach ($examtypes as $examtype) {
//                if ($examtype->id != 2) {
//                    $result = Result::where('users_id', $user->id)
//                        ->where('subjects_id', $subjects_id)
//                        ->where('examtypes_id', $examtype->id)
//                        ->orderBy('ball', 'desc')
//                        ->first();
//                    $data [] = $result;
//                }
//            }
//        }

//        $max_balls = Result::whereIn('users_id', $u_id)
//            ->whereIn('examtypes_id', $examTypes)
//            ->select('users_id', DB::raw('MAX(ball) as max_ball'))
//            ->groupBy('users_id','subjects_id','examtypes_id')
//            ->pluck('max_ball')
//            ->toArray();
//
//
//        $results = Result::whereIn('examtypes_id', $examTypes)
//            ->join('examtypes', 'results.examtypes_id', '=', 'examtypes.id')
//            ->join('users', 'results.users_id', '=', 'users.id')
//            ->join('student_has_attach', 'users.student_id', '=', 'student_has_attach.students_id')
//            ->join('groups', 'student_has_attach.groups_id', '=', 'groups.id')
//            ->join('semesters', 'results.semesters_id', '=', 'semesters.id')
//            ->join('subjects', 'results.subjects_id', '=', 'subjects.id')
//            ->join('students', 'users.student_id', '=', 'students.id')
//            ->whereIn('results.ball', array_values($max_balls))
//            ->where('groups.id', $group_id)
//            ->where('subjects.id', $subject_id)
//            ->select(
//                'results.id as id',
//                'results.correct as correct',
//                'results.ball as ball',
//                'semesters.semester_number as semester',
//                'subjects.subject_name as subject',
//                'groups.name as group',
//                'students.fullname as student',
//                'examtypes.name as examtype'
//            )
//            ->distinct()
//            ->get();

//        return response()->json(($highestScoresBySubject));

    }


    public
    function getDataExam(Request $request)
    {
        $id = intval($request->input('id'));

        // $id = intval($request->input('id'));

        // $result = Result::where('examtypes_id', $id)->get();

        // $u_id = $result->pluck('users_id');

        // $max_balls = Result::whereIn('users_id', $u_id)
        // ->where('examtypes_id', $id)
        // ->select('users_id', 'examtypes_id', 'subjects_id', DB::raw('MAX(ball) as max_ball'))
        // ->groupBy('users_id', 'examtypes_id', 'subjects_id')
        // ->pluck('max_ball');

        // // $results = Result::where('examtypes_id', $id)
        // // ->join('examtypes', 'results.examtypes_id', '=', 'examtypes.id')
        // // ->join('users', 'results.users_id', '=', 'users.id')
        // // ->join('student_has_attach', 'users.student_id', '=', 'student_has_attach.students_id')
        // // // ->join('groups', 'student_has_attach.groups_id', '=', 'groups.id')
        // // // ->join('students', 'users.student_id', '=', 'students.id')
        // // ->get();

        // $st = User::whereIn('id',$u_id)->get();

        // $att = DB::table('student_has_attach')->whereIn('students_id',);

        // // ->join('semesters', 'results.semesters_id', '=', 'semesters.id')
        // // ->join('subjects', 'results.subjects_id', '=', 'subjects.id')
        // // ->join('students', 'users.student_id', '=', 'students.id') // Bu qatordan foydalanuvchilarni izlashni oldini olamiz
        // // ->whereIn('results.ball', $max_balls)
        // // ->select([
        // //     'results.id as id',
        // //     'results.correct as correct',
        // //     'results.ball as ball',
        // //     'semesters.semester_number as semester',
        // //     'subjects.subject_name as subject',
        // //     'groups.name as group',
        // //     'students.fullname as student',
        // //     'examtypes.name as examtype',
        // // ])
        // // ->distinct()

        // Log::info($results);


        // return response()->json(($u_id));
    }


    public
    function data($id)
    {
        $id = $request->input('id');

        return response()->json($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Result $result
     * @return \Illuminate\Http\Response
     */
    public
    function edit(Result $result)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateResultRequest $request
     * @param \App\Models\Result $result
     * @return \Illuminate\Http\Response
     */
    public
    function update(UpdateResultRequest $request, Result $result)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Result $result
     * @return \Illuminate\Http\Response
     */
    public
    function destroy(Result $result)
    {
        //
    }

    public
    function examsSolutionSelfTestResult(Request $request, $type_id, $id): \Illuminate\Http\JsonResponse
    {

        $data = $request->get('data');

        $k = 0;
        $array = [];
        $correctCount = 0;
        $difficulty = 0;

        $arr = [];

        if ($type_id == 1) {
            $examp = Middleexam::find($id);
        } else if ($type_id == 2) {
            $examp = Selfstudyexams::find($id);
            $topics = DB::table('exam_has_topic')->where('exams_id', $examp->id)->select('topics_id')->first();
        } else if ($type_id == 3) {
            $examp = Retriesexam::find($id);
        } else if ($type_id == 4) {
            $examp = Finalexam::find($id);
        } else if ($type_id == 5) {
            $examp = Currentexam::find($id);
        }

        if (!$data) {
            Result::create([
                'users_id' => auth()->user()->id,
                'ball' => 0,
                'examtypes_id' => $type_id,
                'quizzes_id' => $id,
                'subjects_id' => $examp->subjects_id ?? 0,
                'topics_id' => $topics->topics_id ?? 0,
                'exams_id' => $examp->id ?? 0,
                'semesters_id' => $examp->semesters_id ?? 0,
                'correct' => 0,
                'incorrect' => $examp->number
            ]);

            return response()->json(1);
        }

        foreach ($data as $d) {
            $questionId = $d['questionId'];
            $variantList = $d['variantList'];

            $question = Question::find($questionId);

            $option = Options::where('question_id', $question->id)
                ->get();

            $option_correct = Options::where('question_id', $question->id)
                ->where('is_correct', 1)
                ->get();

            $s = $option->pluck('difficulty');
            $i_c = false;
            $vk = key($variantList);
            $value = value($variantList);
            if ($option[ord($vk) - 97]['is_correct'] == 1 && $value) {
                $i_c = true;
                $difficulty += $option[ord($vk) - 97]['difficulty'];
                $arr[] = floatval($option[ord($vk) - 97]['difficulty']);
            }

            if ($i_c) {
                $correctCount++;
            }
        }
        $difficulty = number_format($difficulty, 1, '.', '');

//        return response()->json([$arr]);


        $result = Result::create([
            'users_id' => auth()->user()->id,
            'ball' => $difficulty,
            'examtypes_id' => $type_id,
            'quizzes_id' => $id,
            'subjects_id' => $examp->subjects_id ?? 0,
            'topics_id' => $topics->topics_id ?? 0,
            'exams_id' => $examp->id ?? 0,
            'semesters_id' => $examp->semesters_id ?? 0,
            'correct' => $correctCount,
            'incorrect' => ($examp->number - $correctCount)
        ]);
        return response()->json(1);
    }
}
