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
        $data_yn = [];

        $g = [];

        $group = DB::table('student_has_attach')
            ->where('groups_id', $group_id)
            ->where('educationyears_id', $educationyear_id)
            ->pluck('students_id');

        $examtypes = Examtype::all();


        $data_mi = [];
        $data_on = [];
        $data_jn = [];
        $data_yn = [];


        $data_mi = [];
        $data_on = [];
        $data_jn = [];
        $data_yn = [];

        $data_mi = [];
        $data_on = [];
        $data_jn = [];
        $data_yn = [];

// Processing for 'mi'
        foreach ($group as $uid) {
            $user = User::where('student_id', $uid)->first();
            $resultsMI = Result::where('subjects_id', $subjects_id)
                ->where('users_id', $user->id)
                ->where('examtypes_id', $mi)
                ->get();

            $sum = 0;
            $maxResultIdMi = null;
            if ($resultsMI->isNotEmpty()) {
                $ry = $resultsMI->pluck('quizzes_id')->unique();
                foreach ($ry as $q) {
                    $rx = $resultsMI->where('quizzes_id', $q);
                    $maxBall = $rx->max('ball');
                    $sum += $maxBall * 10;
                    $maxResult = $rx->where('ball', $maxBall)->first();
                    if ($maxResult) {
                        $maxResultIdMi = $maxResult->id;
                    }
                }
            }
            $data_mi[$user->id] = [
                'user' => $user->name ?? null,
                'ball' => $sum,
                'ex_ids' => 0,
                'type' => 2,
                'result_id' => $maxResultIdMi
            ];
        }

// Processing for 'on'
        foreach ($group as $uid) {
            $user = User::where('student_id', $uid)->first();
            $results2 = Result::where('users_id', $user->id)
                ->where('examtypes_id', 1)
                ->get();

            $maxGrade = 0;
            $ex_ids_on = 0;
            $maxResultIdOn = null;
            if ($results2->isNotEmpty()) {
                $quizs = $results2->pluck('quizzes_id')->unique();
                foreach ($quizs as $q) {
                    $rx = Result::where('subjects_id', $subjects_id)
                        ->where('users_id', $user->id)
                        ->where('examtypes_id', 1)
                        ->where('quizzes_id', $q)
                        ->get();

                    foreach ($rx as $grade) {
                        $ball = (float)$grade['ball'];
                        if ($ball > $maxGrade) {
                            $maxGrade = $ball;
                            $ex_ids_on = $grade['quizzes_id'];
                            $maxResultIdOn = $grade['id'];
                        }
                    }
                }
            }
            $data_on[$user->id] = [
                'user' => $user->name ?? null,
                'user_id' => $user->id ?? null,
                'ball' => $maxGrade * 10,
                'ex_ids' => $ex_ids_on,
                'type' => 1,
                'result_id' => $maxResultIdOn
            ];
        }

// Processing for 'jn'
        foreach ($group as $uid) {
            $user = User::where('student_id', $uid)->first();
            $results2 = Result::where('users_id', $user->id)
                ->where('examtypes_id', 5)
                ->get();

            $maxGrade = 0;
            $ex_ids_jn = 0;
            $maxResultIdJn = null;
            if ($results2->isNotEmpty()) {
                $quizs = $results2->pluck('quizzes_id')->unique();
                foreach ($quizs as $q) {
                    $rx = Result::where('subjects_id', $subjects_id)
                        ->where('users_id', $user->id)
                        ->where('examtypes_id', 5)
                        ->where('quizzes_id', $q)
                        ->get();

                    foreach ($rx as $grade) {
                        $ball = (float)$grade['ball'];
                        if ($ball > $maxGrade) {
                            $maxGrade = $ball;
                            $ex_ids_jn = $grade['quizzes_id'];
                            $maxResultIdJn = $grade['id'];
                        }
                    }
                }
            }
            $data_jn[$user->id] = [
                'user' => $user->name ?? null,
                'user_id' => $user->id ?? null,
                'ball' => $maxGrade * 10,
                'ex_ids' => $ex_ids_jn,
                'type' => 5,
                'result_id' => $maxResultIdJn
            ];
        }

// Processing for 'yn'
        foreach ($group as $uid) {
            $user = User::where('student_id', $uid)->first();
            $results2 = Result::where('users_id', $user->id)
                ->where('examtypes_id', 4)
                ->get();

            $maxGrade = 0;
            $ex_ids_yn = 0;
            $maxResultIdYn = null;
            if ($results2->isNotEmpty()) {
                $quizs = $results2->pluck('quizzes_id')->unique();
                foreach ($quizs as $q) {
                    $rx = Result::where('subjects_id', $subjects_id)
                        ->where('users_id', $user->id)
                        ->where('examtypes_id', 4)
                        ->where('quizzes_id', $q)
                        ->get();

                    foreach ($rx as $grade) {
                        $ball = (float)$grade['ball'];
                        if ($ball > $maxGrade) {
                            $maxGrade = $ball;
                            $ex_ids_yn = $grade['quizzes_id'];
                            $maxResultIdYn = $grade['id'];
                        }
                    }
                }
            }
            $data_yn[$user->id] = [
                'user' => $user->name ?? null,
                'user_id' => $user->id ?? null,
                'ball' => $maxGrade * 10,
                'ex_ids' => $ex_ids_yn,
                'type' => 4,
                'result_id' => $maxResultIdYn
            ];
        }

// Combine the results
        $data = [];
        foreach ($group as $uid) {
            $user = User::where('student_id', $uid)->first();
            $userId = $user->id;
            $data[] = [
                'name' => $data_mi[$userId]['user'] ?? null,
                'user_id' => $data_jn[$userId]['user_id'] ?? null,
                'ball_mi' => $data_mi[$userId]['ball'] ?? null,
                'ball_on' => $data_on[$userId]['ball'] ?? null,
                'ball_jn' => $data_jn[$userId]['ball'] ?? null,
                'ball_yn' => $data_yn[$userId]['ball'] ?? null,
                'type_on' => $data_on[$userId]['type'] ?? null,
                'type_jn' => $data_jn[$userId]['type'] ?? null,
                'type_yn' => $data_yn[$userId]['type'] ?? null,
                'ex_ids_on' => $data_on[$userId]['ex_ids'] ?? null,
                'ex_ids_jn' => $data_jn[$userId]['ex_ids'] ?? null,
                'ex_ids_yn' => $data_yn[$userId]['ex_ids'] ?? null,
                'result_id_mi' => $data_mi[$userId]['result_id'] ?? null,
                'result_id_on' => $data_on[$userId]['result_id'] ?? null,
                'result_id_jn' => $data_jn[$userId]['result_id'] ?? null,
                'result_id_yn' => $data_yn[$userId]['result_id'] ?? null
            ];
        }


        return response()->json($data);


    }


    public function getDataExam(Request $request)
    {
        $id = intval($request->input('id'));

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
    public function edit($id)
    {
        $data = explode(",", $id);
        $exam = $data[0];
        $examtype = $data[1];
        $result= $data[2];
        $user = $data[3];
        $result = Result::where('id',$result)
            ->where('examtypes_id', $examtype)
            ->where('users_id', $user)
            ->where('quizzes_id', $exam)
            ->first();
        if ($result) {
            return view('pages.results.edit', compact('id', 'result'));
        } else {
            return redirect()->back()->with('error', 'Bunday malumot mavjud emas');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateResultRequest $request
     * @param \App\Models\Result $result
     * @return \Illuminate\Http\Response
     */
    public
    function update(UpdateResultRequest $request, $id)
    {
        $data = explode(",", $request->data);
        $exam = $data[0];
        $examtype = $data[1];
        $result= $data[2];
        $user = $data[3];
        $result = Result::where('id',$result)
            ->where('examtypes_id', $examtype)
            ->where('users_id', $user)
            ->where('quizzes_id', $exam)
            ->first();

        $result->update([
            'ball' => $request->ball
        ]);

        return redirect()->route('results.index')->with('success', 'Ball muvvafaqiyatli tahrirlandi');

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

        $difficulty = 0.0;
        $arr = [];
        $arr2 = [];
        foreach ($data as $d) {
            $questionId = $d['questionId'];
            $variantList = $d['variantList'];

            $question = Question::find($questionId);

            $arr2 [] = $question;
            $option = Options::where('question_id', $question->id)
                ->get();

            $vk = key($variantList);
            $value = value($variantList);

            if ($option[ord($vk) - 97]['is_correct'] == 1 && $value) {
                $correctCount++;
                $difficulty += $option[ord($vk) - 97]['difficulty'];
                $arr [] = $option[ord($vk) - 97]['difficulty'];
            }
        }

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
