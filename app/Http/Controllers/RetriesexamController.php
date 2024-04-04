<?php

namespace App\Http\Controllers;

use App\Models\Examtype;
use App\Models\Group;
use App\Models\Retriesexam;
use App\Http\Requests\StoreRetriesexamRequest;
use App\Http\Requests\UpdateRetriesexamRequest;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RetriesexamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if_forbidden('retryexam.show');

        $role = auth()->user()->roles->pluck('name');
        $user = auth()->user()->id;


        if ($role[0] == 'teacher') {

            $retriesexams = Retriesexam::where('user_id', $user)->get();

        } else if (auth()->user()->roles->pluck('name')[0] == 'Super Admin') {
            $retriesexams = Retriesexam::all();

        }

        return view('pages.retriesexams.index', compact('retriesexams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if_forbidden('retryexam.create');

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

        return view('pages.retriesexams.add', compact('examtypes', 'subjects', 'groups', 'semesters'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreRetriesexamRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRetriesexamRequest $request)
    {
        abort_if_forbidden('retryexam.create');

        $user_id = auth()->user()->id;

        $retriesexams = Retriesexam::create([
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
                'exams_id' => $retriesexams->id,
                'topics_id' => $topic_id,
            ];
        }

        DB::table('exam_has_topic')->insert($topicsValues);

        return redirect()->route('retriesexams.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Retriesexam $retriesexam
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->input('id');
        $subject = Subject::find($id);

        $topics = $subject->topics;
        return response()->json($topics);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Retriesexam $retriesexam
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if_forbidden('retryexam.edit');

        $retriesexam = Retriesexam::find($id);
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
        $topics = Topic::where('subject_id', $retriesexam->subjects_id)->get();

        return view('pages.retriesexams.edit', compact('retriesexam', 'examtypes', 'subjects', 'groups', 'semesters', 'topics'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateRetriesexamRequest $request
     * @param \App\Models\Retriesexam $retriesexam
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRetriesexamRequest $request,$id)
    {
        abort_if_forbidden('retryexam.edit');

        $retriesexam = Retriesexam::find($id);

        $retriesexam->update([
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
                'exams_id' => $retriesexam->id,
                'topics_id' => $topic_id,
            ];
        }

        DB::table('exam_has_topic')->insert($topicsValues);

        return redirect()->route('retriesexams.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Retriesexam $retriesexam
     * @return \Illuminate\Http\Response
     */
    public function deleteAll(Request $request)
    {
        abort_if_forbidden('retryexam.destroy');

        $ids = $request->ids;

        $res = Retriesexam::whereIn('id',$ids)->delete();
        if($res){
            return response()->json([
                'success'=>true,
                "message" => "This action successfully complated"
            ]);
        }
        return response()->json([
            'success'=>false,
            "message" => "This delete action failed!"
        ]);
    }
    public function destroy($id)
    {
        abort_if_forbidden('retryexam.destroy');

        Retriesexam::find($id)->delete();
        return redirect()->back();
    }
}
