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
use App\Models\User;
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

        $role = auth()->user()->roles->pluck('name');
        $user = auth()->user()->id;


        if ($role[0] == 'teacher') {

            $middleexams = Middleexam::where('user_id', $user)->get();

        } else if (auth()->user()->roles->pluck('name')[0] == 'Super Admin') {
            $middleexams = Middleexam::all();

        }


        return view('pages.middleexams.index', compact('middleexams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if_forbidden('middleexam.create');

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
        $user_id = auth()->user()->id;

        $middleexams = Middleexam::create([
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

//        dd($middleexams);

        $duration = DB::table('quiz_has_duration')->insert([
            'quiz_id' => $middleexams->id,
            'duration' => $request->duration,
            'examtype_id' => $middleexams->examtypes_id,
        ]);

        $topicsValues = [];
        foreach ($request->topics_id as $topic_id) {
            $topicsValues[] = [
                'exams_id' => $middleexams->id,
                'topics_id' => $topic_id,
                'examtypes_id' => $request->examtypes_id,
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
        $topics = Topic::where('subject_id', $middleexam->subjects_id)->get();

        $duration = DB::table('quiz_has_duration')
            ->where('quiz_id', $id)
            ->where('examtype_id', $middleexam->examtypes_id)
            ->first();


        return view('pages.middleexams.edit', compact('middleexam', 'examtypes', 'subjects', 'groups', 'semesters', 'topics','duration'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateMiddleexamRequest $request
     * @param \App\Models\middleexam $middleexam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_if_forbidden('middleexam.edit');


        $middleexams = Middleexam::find($id);

     $duration = DB::table('quiz_has_duration')
            ->where('quiz_id', $id)
            ->where('examtype_id', $middleexams->examtypes_id)
            ->update([
                'duration' => $request->duration
            ]);



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

         $duration = DB::table('quiz_has_duration')
            ->where('quiz_id', $id)
            ->where('examtype_id', $middleexams->examtypes_id)
            ->update([
                'duration' => $request->duration
            ]);


        DB::table('exam_has_topic')->where('exams_id', $id)->delete();

        $topicsValues = [];
        foreach ($request->topics_id as $topic_id) {
            $topicsValues[] = [
                'exams_id' => $middleexams->id,
                'topics_id' => $topic_id,
                'examtypes_id' => $request->examtypes_id,
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

        $res = Middleexam::whereIn('id', $ids)->delete();


        if ($res) {
            return response()->json([
                'success' => true,
                "message" => "This action successfully complated"
            ]);
        }
        return response()->json([
            'success' => false,
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
