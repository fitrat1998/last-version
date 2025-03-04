<?php

namespace App\Http\Controllers;

use App\Models\Examtype;
use App\Models\Group;
use App\Models\Middleexam;
use App\Models\Selfstudy;
use App\Models\Selfstudyexams;
use App\Http\Requests\StoreSelfstudyexamsRequest;
use App\Http\Requests\UpdateSelfstudyexamsRequest;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SelfstudyexamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if_forbidden('selfstudyexam.show');

        $role = auth()->user()->roles->pluck('name');
        $user = auth()->user()->id;



        if ($role[0] == 'teacher') {

            $selfstudyexams = Selfstudyexams::where('user_id', $user)->get();

        } else if (auth()->user()->roles->pluck('name')[0] == 'Super Admin') {
           $selfstudyexams = Selfstudyexams::all();

        }


        return view('pages.selfstudyexams.index', compact('selfstudyexams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if_forbidden('selfstudyexam.create');

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


        return view('pages.selfstudyexams.add', compact('examtypes', 'subjects', 'groups', 'semesters'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreSelfstudyexamsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSelfstudyexamsRequest $request)
    {
        abort_if_forbidden('selfstudyexam.create');
        $user_id = auth()->user()->id;

        //        dd($request);

        $selfstudyexams = Selfstudyexams::create([
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

         $duration = DB::table('quiz_has_duration')->insert([
            'quiz_id' => $selfstudyexams->id,
            'duration' => $request->duration,
            'examtype_id' => $selfstudyexams->examtypes_id,
        ]);

        $topicsValues = [];
        foreach ($request->topics_id as $topic_id) {
            $topicsValues[] = [
                'exams_id' => $selfstudyexams->id,
                'topics_id' => $topic_id,
                'examtypes_id' => $request->examtypes_id,
            ];
        }

        DB::table('exam_has_topic')->insert($topicsValues);

        return redirect()->route('selfstudyexams.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Selfstudyexams $selfstudyexams
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
     * @param \App\Models\Selfstudyexams $selfstudyexams
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if_forbidden('selfstudyexam.edit');

        $selfstudy = Selfstudyexams::find($id);
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
        $topics = Topic::where('subject_id', $selfstudy->subjects_id)->get();

        $duration = DB::table('quiz_has_duration')
            ->where('quiz_id', $id)
            ->where('examtype_id', $selfstudy->examtypes_id)
            ->first();

        return view('pages.selfstudyexams.edit', compact('selfstudy', 'examtypes', 'subjects', 'groups', 'semesters', 'topics','duration'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateSelfstudyexamsRequest $request
     * @param \App\Models\Selfstudyexams $selfstudyexams
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSelfstudyexamsRequest $request, $id)
    {
        abort_if_forbidden('selfstudyexam.edit');

         $selfstudyexam = Selfstudyexams::find($id);

        $selfstudyexam->update([
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

        $duration = DB::table('quiz_has_duration')
            ->where('quiz_id', $id)
            ->where('examtype_id', $selfstudyexam->examtypes_id)
            ->update([
                'duration' => $request->duration
            ]);

        DB::table('exam_has_topic')->where('exams_id', $id)->delete();

        $topicsValues = [];
        foreach ($request->topics_id as $topic_id) {
            $topicsValues[] = [
                'exams_id' => $selfstudyexam->id,
                'topics_id' => $topic_id,
                'examtypes_id' => $request->examtypes_id,
            ];
        }

        DB::table('exam_has_topic')->insert($topicsValues);

        return redirect()->route('selfstudyexams.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Selfstudyexams $selfstudyexams
     * @return \Illuminate\Http\Response
     */
    public function deleteAll(Request $request)
    {
        abort_if_forbidden('selfstudyexam.destroy');

        $ids = $request->ids;

        $res = Selfstudyexams::whereIn('id',$ids)->delete();
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
        abort_if_forbidden('selfstudyexam.destroy');

        Selfstudyexams::find($id)->delete();
        return redirect()->back();
    }
}
