<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Topic;
use App\Models\Options;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Requests\StoreQuetionsRequest;
use App\Http\Requests\UpdateQuetionsRequest;


class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if_forbidden('question.show');

        $users = User::all();
        $questions = Question::all();

        return view('pages.questions.index',compact('users','questions'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if_forbidden('question.create');

        $topic = Topic::all();
        return view('pages.questions.add',compact('topic'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreQuestionsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Questions  $questions
     * @return \Illuminate\Http\Response
     */
    public function show(Questions $questions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Questions  $questions
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if_forbidden('question.edit');

        $question = Question::find($id);


        $topics = Topic::all();

        $options = Options::where('question_id',$question->id)->get();


        return view('pages.questions.edit', compact('topics','question','options'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateQuestionsRequest  $request
     * @param  \App\Models\Questions  $questions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $questions,$id)
    {
        // dd($request);

        // abort_if_forbidden('question.edit');
        dd($request);
        $question = Question::find($id);


        $question->update([
            'question' => $request->question,
            'topic_id' => $request->topic_id
        ]);

        $options = Options::where('question_id',$question->id)
                            ->whereIn('id',$request->option_id)
                            ->get();

        $option = Options::where('question_id', $question->id)
            ->whereIn('id', $request->option_id)
            ->delete();


        foreach ($request->option as $key => $id) {
            $option = Options::where('id', $id)
            ->where('question_id',
                $question->id
            )
            ->first();


            Options::create([
                'question_id' => $question->id ,
                'option' => $id,
                'is_correct' => $request->status[$key] ?? false,
                'difficulty' => $request->difficulty[$key] ?? 0,
            ]);


        }


        return redirect()->route('questions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quetions  $quetions
     * @return \Illuminate\Http\Response
     */
    public function deleteAll(Request $request)
    {
        abort_if_forbidden('question.destroy');

        $ids = $request->ids;

        $res = Question::whereIn('id',$ids)->delete();
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

    public function destroy( $quetions)
    {
        abort_if_forbidden('question.destroy');

        Question::find($quetions)->delete();
        return redirect()->back();
    }
}
