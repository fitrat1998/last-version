<?php

namespace App\Http\Controllers;

use App\Models\Attendance_log;
use App\Models\Educationyear;
use App\Models\Examtype;
use App\Models\Group;
use App\Models\Lessontype;
use App\Models\Middleexam;
use App\Http\Requests\StoreMiddleexamRequest;
use App\Http\Requests\UpdateMiddleexamRequest;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MiddleexamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if_forbidden('middleexam.show');

        $middleexams = Middleexam::all();
        $groups = Group::all();


        return view('pages.middleexams.index', compact('middleexams', 'groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if_forbidden('middleexam.create');

        $subjects = Subject::all();
        $groups = Group::all();
        $examtypes = Examtype::all();
        $semesters = Semester::all();

        return view('pages.middleexams.add', compact('examtypes', 'subjects', 'groups', 'semesters'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreMiddleexamRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMiddleexamRequest $request)
    {
        abort_if_forbidden('middleexam.create');

//        dd($request);

        $middleexams = Middleexam::create([
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

        $topicsValues = [];
        foreach ($request->topics_id as $topic_id) {
            $topicsValues[] = [
                'exams_id' => $middleexams->id,
                'topics_id' => $topic_id,
            ];
        }

        DB::table('exam_has_topic')->insert($topicsValues);


        return redirect()->route('middleexams.index');
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\middleexam $middleexam
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
     * @param \App\Models\middleexam $middleexam
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if_forbidden('middleexam.edit');

        $middleexam = Middleexam::find($id);
        $subjects = Subject::all();
        $groups = Group::all();
        $semesters = Semester::all();
        $examtypes = Examtype::all();
        $topics = Topic::where('subject_id', $middleexam->subjects_id)->get();

        return view('pages.middleexams.edit', compact('middleexam', 'examtypes', 'subjects', 'groups', 'semesters', 'topics'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateMiddleexamRequest $request
     * @param \App\Models\middleexam $middleexam
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMiddleexamRequest $request, $id)
    {
        abort_if_forbidden('middleexam.edit');


        $middleexams = Middleexam::find($id);

        $middleexams->update([
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
                'exams_id' => $middleexams->id,
                'topics_id' => $topic_id,
            ];
        }

        DB::table('exam_has_topic')->insert($topicsValues);

        return redirect()->route('middleexams.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\middleexam $middleexam
     * @return \Illuminate\Http\Response
     */
    public function deleteAll(Request $request)
    {
        abort_if_forbidden('middleexam.destroy');

        $ids = $request->ids;

         $res = Middleexam::whereIn('id',$ids)->delete();
        

        if($res){
            return response()->json([
                'success'=>true,
                "message" => "This action successfully complated"
            ]); 
        }
        return response()->json([
            'success'=>false,
            "message" => "SIHBDISA"
        ]);
    }

    public function destroy($id)
    {
        abort_if_forbidden('middleexam.destroy');

        Middleexam::find($id)->delete();
        return redirect()->back();
    }
}
