<?php

namespace App\Http\Controllers;

use App\Models\Examtype;
use App\Models\Finalexam;
use App\Http\Requests\StoreFinalexamRequest;
use App\Http\Requests\UpdateFinalexamRequest;
use App\Models\Group;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinalexamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if_forbidden('finalexam.show');


        $role = auth()->user()->roles->pluck('name');
        $user = auth()->user()->id;


        if ($role[0] == 'teacher') {

            $finalexams = Finalexam::where('user_id', $user)->get();

        } else if (auth()->user()->roles->pluck('name')[0] == 'Super Admin') {
            $finalexams = Finalexam::all();

        }


        return view('pages.finalexams.index', compact('finalexams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if_forbidden('finalexam.create');


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

        $examtypes = Examtype::all();
        $semesters = Semester::all();


        return view('pages.finalexams.add', compact('examtypes', 'subjects', 'groups', 'semesters'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreFinalexamRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFinalexamRequest $request)
    {
        abort_if_forbidden('finalexam.create');
        $user_id = auth()->user()->id;

        $finalexams = Finalexam::create([
            'number' => $request->number,
            'user_id' => $user_id,
            'examtypes_id' => $request->examtypes_id,
            'groups_id' => $request->groups_id,
            'subjects_id' => $request->subjects_id,
            'semesters_id' => $request->semesters_id,
            'start' => $request->start,
            'end' => $request->end,
            'attempts' => $request->attempts,
            'passing' => $request->passing,
        ]);

        $topicsValues = [];
        foreach ($request->topics_id as $topic_id) {
            $topicsValues[] = [
                'exams_id' => $finalexams->id,
                'topics_id' => $topic_id,
                'examtypes_id' => $request->examtypes_id,
            ];
        }

        DB::table('exam_has_topic')->insert($topicsValues);


        return redirect()->route('finalexams.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Finalexam $finalexam
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $id = $request->input('id');
        $subject = Subject::find($id);
        $topics = $subject->topics;

        return response()->json($topics);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Finalexam $finalexam
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if_forbidden('finalexam.edit');

        $finalexam = Finalexam::find($id);
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
        $examtypes = Examtype::all();
        $semesters = Semester::all();
        $topics = Topic::where('subject_id', $finalexam->subjects_id)->get();

        return view('pages.finalexams.edit', compact('finalexam', 'examtypes', 'subjects', 'groups', 'semesters', 'topics'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateFinalexamRequest $request
     * @param \App\Models\Finalexam $finalexam
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFinalexamRequest $request, $id)
    {
        abort_if_forbidden('finalexam.edit');

        $finalexam = Finalexam::find($id);

        $finalexam->update([
            'number' => $request->number,
            'examtypes_id' => $request->examtypes_id,
            'groups_id' => $request->groups_id,
            'subjects_id' => $request->subjects_id,
            'semesters_id' => $request->semesters_id,
            'start' => $request->start,
            'end' => $request->end,
            'attempts' => $request->attempts,
            'passing' => $request->passing,
        ]);

        DB::table('exam_has_topic')->where('exams_id', $id)->delete();

        $topicsValues = [];
        foreach ($request->topics_id as $topic_id) {
            $topicsValues[] = [
                'exams_id' => $finalexam->id,
                'topics_id' => $topic_id,
                'examtypes_id' => $request->examtypes_id,
            ];
        }

        DB::table('exam_has_topic')->insert($topicsValues);

        return redirect()->route('finalexams.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Finalexam $finalexam
     * @return \Illuminate\Http\Response
     */
    public function deleteAll(Request $request)
    {
        abort_if_forbidden('finalexam.destroy');

        $ids = $request->ids;

        $res = Finalexam::whereIn('id', $ids)->delete();
        if ($res) {
            return response()->json([
                'success' => true,
                "message" => "This action successfully complated"
            ]);
        }
        return response()->json([
            'success' => false,
            "message" => "This delete action failed! dda"
        ]);
    }

    public function destroy($id)
    {
        abort_if_forbidden('finalexam.destroy');

        Finalexam::find($id)->delete();
        return redirect()->back();
    }
}
