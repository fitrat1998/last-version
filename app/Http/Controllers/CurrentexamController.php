<?php

namespace App\Http\Controllers;

use App\Models\Currentexam;
use App\Http\Requests\StoreCurrentexamRequest;
use App\Http\Requests\UpdateCurrentexamRequest;
use App\Models\Examtype;
use App\Models\Group;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CurrentexamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if_forbidden('currentexam.show');

        $currentexams = Currentexam::all();
        $groups = Group::all();


        return view('pages.currentexams.index', compact('currentexams', 'groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if_forbidden('currentexam.create');

        $subjects = Subject::all();
        $groups = Group::all();
        $examtypes = Examtype::all();
        $semesters = Semester::all();


        return view('pages.currentexams.add', compact('examtypes', 'subjects', 'groups', 'semesters'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreCurrentexamRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCurrentexamRequest $request)
    {
        abort_if_forbidden('currentexam.create');

        $user_id = auth()->user()->id;

        $currentexam = Currentexam::create([
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
                'exams_id' => $currentexam->id,
                'topics_id' => $topic_id,
            ];
        }

        DB::table('exam_has_topic')->insert($topicsValues);


        return redirect()->route('currentexams.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Currentexam $currentexam
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
     * @param \App\Models\Currentexam $currentexam
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if_forbidden('currentexam.edit');

        $currentexam = Currentexam::find($id);
        $subjects = Subject::all();
        $groups = Group::all();
        $semesters = Semester::all();
        $examtypes = Examtype::all();
        $topics = Topic::where('subject_id', $currentexam->subjects_id)->get();

        return view('pages.currentexams.edit', compact('currentexam', 'examtypes', 'subjects', 'groups', 'semesters', 'topics'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateCurrentexamRequest $request
     * @param \App\Models\Currentexam $currentexam
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCurrentexamRequest $request, $id)
    {
        abort_if_forbidden('currentexam.edit');

        $currentexam = Currentexam::find($id);

        $currentexam->update([
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
                'exams_id' => $currentexam->id,
                'topics_id' => $topic_id,
            ];
        }

        DB::table('exam_has_topic')->insert($topicsValues);

        return redirect()->route('currentexams.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Currentexam $currentexam
     * @return \Illuminate\Http\Response
     */

    public function deleteAll(Request $request)
    {
        abort_if_forbidden('currentexam.destroy');

        $ids = $request->ids;

        $res = Currentexam::whereIn('id',$ids)->delete();
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
        abort_if_forbidden('currentexam.destroy');

        Currentexam::find($id)->delete();
        return redirect()->back();
    }
}
