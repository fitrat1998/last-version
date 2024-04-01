<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Topic;
use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Models\User;
use App\Models\Faculty;
use App\Models\Subject;
use App\Services\LogWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if_forbidden('topic.show');


        $role = auth()->user()->roles->pluck('name');
        $user = auth()->user()->id;

        $t_id = User::find($user);


        if ($role[0] == 'teacher') {

            $group = DB::table('teacher_has_group')->where('teachers_id', $t_id->teacher_id)->pluck('groups_id');

            $groups = Group::whereIn('id', $group)->pluck('id');

            $subjects_id = DB::table('subject_has_group')->whereIn('groups_id', $groups)->pluck('subjects_id');

            $subjects = Subject::whereIn('id', $subjects_id)->get();
            $topics = Topic::whereIn('subject_id', $subjects_id)->get();


        } else if (auth()->user()->roles->pluck('name')[0] == 'Super Admin') {
            $subjects = Subject::all()->pluck('id');

            $topics = Topic::whereIn('subject_id', $subjects)->get();

        }

        return view('pages.topics.index', compact('topics', 'subjects'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if_forbidden('topic.create');

        $role = auth()->user()->roles->pluck('name');
        $user = auth()->user()->id;

        $t_id = User::find($user);


        if ($role[0] == 'teacher') {

            $subjects = Subject::where('user_id', $t_id->id)->get();

        } else if (auth()->user()->roles->pluck('name')[0] == 'Super Admin') {
            $subjects = Subject::all();
        }

        return view('pages.topics.add', compact('subjects'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreTopicRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTopicRequest $request)
    {
        abort_if_forbidden('topic.create');

        $topic_name = Topic::create([
            'topic_name' => $request->get('topic_name'),
            'subject_id' => $request->get('subject_id'),
        ]);

        return redirect()->route('topics.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Topic $topic
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $topics = Topic::where('subject_id', $id)->get();

        return response()->json($topics);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Topic $topic
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if_forbidden('topic.edit');

        $topic = Topic::find($id);
        $subjects = Subject::all();

        return view('pages.topics.edit', compact('topic', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateTopicRequest $request
     * @param \App\Models\Topic $topic
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTopicRequest $request, $id)
    {
        abort_if_forbidden('topic.edit');

        $topic = Topic::find($id);
        $topic->fill($request->all());
        $topic->update([
            'topic_name' => $request->topic_name,
            'subject_id' => $request->subject_id,
        ]);

        return redirect()->route('topics.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Topic $topic
     * @return \Illuminate\Http\Response
     */

    public function deleteAll(Request $request)
    {
        abort_if_forbidden('topic.destroy');

        $ids = $request->ids;

        $res = Topic::whereIn('id', $ids)->delete();
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

        Topic::find($id)->delete();
        return redirect()->route('topics.index');

    }
}
