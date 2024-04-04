<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Http\Requests\StoreExerciseRequest;
use App\Http\Requests\UpdateExerciseRequest;
use App\Models\Group;
use App\Models\Lessontype;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Educationyear;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if_forbidden('exercise.show');


        $role = auth()->user()->roles->pluck('name');
        $user = auth()->user()->id;

        $t_id = User::find($user);


        if ($role[0] == 'teacher') {

            $exercises = Exercise::where('user_id', $t_id->id)->get();

        } else if (auth()->user()->roles->pluck('name')[0] == 'Super Admin') {
            $exercises = Exercise::all();
        }

        return view('exercises.index', compact('exercises'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if_forbidden('exercise.create');

        $role = auth()->user()->roles->pluck('name');
        $user = auth()->user()->id;

        $t_id = User::find($user);


        if ($role[0] == 'teacher') {

            $group = DB::table('teacher_has_group')->where('teachers_id', $t_id->teacher_id)->pluck('groups_id');

            $groups = Group::whereIn('id', $group)->get();

        } else if (auth()->user()->roles->pluck('name')[0] == 'Super Admin') {
            $groups = Group::all();
        }

        if ($role[0] == 'teacher') {
            $subjects = Subject::where('user_id', $user)->get();
        } else if (auth()->user()->roles->pluck('name')[0] == 'Super Admin') {
            $subjects = Subject::all();
        }
        $semesters = Semester::all();
        $lessontypes = Lessontype::all();



        if ($role[0] == 'teacher') {
            $teachers = Teacher::where('id',$t_id->teacher_id)->get();
        } else if (auth()->user()->roles->pluck('name')[0] == 'Super Admin') {
            $teachers = Teacher::all();
        }

        $educationyears = Educationyear::all();
        return view('exercises.create', compact('groups', 'subjects', 'semesters', 'lessontypes', 'teachers', 'educationyears'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreExerciseRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExerciseRequest $request)
    {
        abort_if_forbidden('exercise.create');
        $user = auth()->user()->id;
        //    dd($request);
        Exercise::create([
            'user_id' => $user,
            'title' => $request->title,
            'date' => $request->date,
            'lessontypes_id' => $request->lessontypes_id,
            'teachers_id' => $request->teachers_id,
            'groups_id' => $request->groups_id,
            'semesters_id' => $request->semesters_id,
            'subjects_id' => $request->subjects_id,
            'topics_id' => $request->topics_id,
            'educationyears_id' => $request->educationyear_id,
        ]);

        return redirect()->route('exercises.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Exercise $exercise
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->input('id');

        $subjects_id = DB::table('subject_has_group')
            ->where('groups_id', '=', $id)
            ->pluck('subjects_id')
            ->toArray();
        $subjects = Subject::whereIn('id', $subjects_id)->get();


        return response()->json($subjects);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Exercise $exercise
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if_forbidden('exercise.edit');

        $exercises = Exercise::find($id);
        $groups = Group::all();
        $subjects = Subject::all();
        $semesters = Semester::all();
        $lessontypes = Lessontype::all();
        $teachers = Teacher::all();
        $educationyears = Educationyear::all();
        return view('exercises.edit', compact('groups', 'subjects', 'semesters', 'lessontypes', 'teachers', 'educationyears', 'exercises'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateExerciseRequest $request
     * @param \App\Models\Exercise $exercise
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExerciseRequest $request, $id)
    {
        abort_if_forbidden('exercise.edit');

        $exercise = Exercise::find($id);
        $exercise->fill($request->all());
        $exercise->update([
            'title' => $request->title,
            'date' => $request->date,
            'lessontypes_id' => $request->lessontype_id,
            'teachers_id' => $request->teacher_id,
            'groups_id' => $request->group_id,
            'semesters_id' => $request->semester_id,
            'subjects_id' => $request->subject_id,
            'educationyears_id' => $request->educationyear_id,
        ]);

        return redirect()->route('exercises.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Exercise $exercise
     * @return \Illuminate\Http\Response
     */
    public function deleteAll(Request $request)
    {
        abort_if_forbidden('exercise.destroy');

        $ids = $request->ids;

        $res = Exercise::whereIn('id', $ids)->delete();
        if ($res) {
            return response()->json([
                'success' => true,
                "message" => "This action successfully complated"
            ]);
        }
        return response()->json([
            'success' => false,
            "message" => "This delete action failed!"
        ]);
    }

    public function destroy($id)
    {
        abort_if_forbidden('exercise.destroy');

        $delete = Exercise::destroy($id);
        return redirect()->back();
    }
}
