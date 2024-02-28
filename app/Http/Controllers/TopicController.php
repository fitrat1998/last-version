<?php

namespace App\Http\Controllers;

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

        $subjects = Subject::all();
        $users = User::where('id','!=',auth()->user()->id)->get();
        $topics = Topic::all();

        return view('pages.topics.index',compact('users','topics','subjects'));
    }

    public function add()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if_forbidden('topic.create');

        $subjects = Subject::all();
        return view('pages.topics.add',compact('subjects'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTopicRequest  $request
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
     * @param  \App\Models\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $topics = Topic::where('subject_id',$id)->get();

        return response()->json($topics);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if_forbidden('topic.edit');

        $topic = Topic::find($id);
        $subjects = Subject::all();

        return view('pages.topics.edit',compact('topic','subjects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTopicRequest  $request
     * @param  \App\Models\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTopicRequest $request,$id)
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
     * @param  \App\Models\Topic  $topic
     * @return \Illuminate\Http\Response
     */

    public function deleteAll(Request $request)
    {
        abort_if_forbidden('topic.destroy');

        $ids = $request->ids;

        $res = Topic::whereIn('id',$ids)->delete();
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

        Topic::find($id)->delete();
        return redirect()->route('topics.index');

    }
}
