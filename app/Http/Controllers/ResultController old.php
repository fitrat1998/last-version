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
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
        $id = intval($request->input('id'));
        $group_id = intval($request->input('group_id'));
        $subject_id = intval($request->input('subject_id'));

        $result = Result::where('examtypes_id', $id)
            ->get();

        $u_id = $result->pluck('users_id');
        $nid = $result->pluck('examtypes_id');


        $max_balls = Result::whereIn('users_id', $u_id)
            ->where('examtypes_id', $id)
            ->select('users_id', DB::raw('MAX(ball) as max_ball'))
            ->groupBy('users_id', 'examtypes_id', 'subjects_id')
            ->pluck('max_ball')
            ->toArray();


        $results = Result::whereIn('examtypes_id', $nid)
            ->join('examtypes', 'results.examtypes_id', '=', 'examtypes.id')
            ->join('users', 'results.users_id', '=', 'users.id')
            ->join('student_has_attach', 'users.student_id', '=', 'student_has_attach.students_id')
            ->join('groups', 'student_has_attach.groups_id', '=', 'groups.id')
            ->join('semesters', 'results.semesters_id', '=', 'semesters.id')
            ->join('subjects', 'results.subjects_id', '=', 'subjects.id')
            ->join('students', 'users.student_id', '=', 'students.id')
            ->whereIn('results.ball', array_values($max_balls))
            ->where('groups.id', $group_id)
            ->where('subjects.id', $subject_id)
            ->select(
                'results.id as id',
                'results.correct as correct',
                'results.ball as ball',
                'semesters.semester_number as semester',
                'subjects.subject_name as subject',
                'groups.name as group',
                'students.fullname as student',
                'examtypes.name as examtype'
            )
            ->distinct()
            ->get();


        return response()->json($results);
    }


    public function getDataExam(Request $request)
    {
        $id = intval($request->input('id'));

        $result = Result::where('examtypes_id', $id);


        return response()->json($result);
    }


    public function data($id)
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
    public function edit(Result $result)
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
    public function update(UpdateResultRequest $request, Result $result)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Result $result
     * @return \Illuminate\Http\Response
     */
    public function destroy(Result $result)
    {
        //
    }

    public function examsSolutionSelfTestResult(Request $request, $type_id, $id): \Illuminate\Http\JsonResponse
    {

        $data = $request->get('data');

        if (!$data || count($data) < 1) {
            return response()->json([
                "status" => "success",
                "data" => null
            ]);
        }
        $k = 0;
        $array = [];
        $correctCount = 0;
        $difficulty = 0;


        foreach ($data as $d) {
            $questionId = $d['questionId'];
            $variantList = $d['variantList'];

            $question = Question::find($questionId);

            $option = Options::where('question_id', $question->id)
                ->get();

            $option_correct = Options::where('question_id', $question->id)
                ->where('is_correct', 1)
                ->get();

            $correctCount = 0;

            foreach ($variantList as $vk => $value) {
                if ($option[ord($vk) - 97]['is_correct'] && $value) {
                    $correctCount ++;
                    $difficulty += $option[ord($vk) - 97]['difficulty'];
                    $difficulty = (float)$difficulty;
                }
            }
        }

        if ($type_id == 1) {
            $examp = Middleexam::find($id);
        } else if ($type_id == 2) {
            $examp = Selfstudyexams::find($id);
        } else if ($type_id == 3) {
            $examp = Retriesexam::find($id);
        } else if ($type_id == 4) {
            $examp = Finalexam::find($id);
        } else if ($type_id == 5) {
            $examp = Currentexam::find($id);
        }

        Result::create([
            'users_id' => auth()->user()->id,
            'ball' => $difficulty,
            'examtypes_id' => $type_id,
            'quizzes_id' => $id,
            'subjects_id' => $examp->subjects_id ?? 0,
            'semesters_id' => $examp->semesters_id ?? 0,
            'correct' => $correctCount,
            'incorrect' => (($examp->number) - $correctCount)
        ]);

        return response()->json($examp);
    }
}
