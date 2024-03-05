<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Topic;
use App\Models\Options;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Requests\StoreQuetionsRequest;
use App\Http\Requests\UpdateQuetionsRequest;
use Illuminate\Support\Facades\Validator;


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

        return view('pages.questions.index', compact('users', 'questions'));
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
        return view('pages.questions.add', compact('topic'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreQuestionsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Questions $questions
     * @return \Illuminate\Http\Response
     */
    public function show(Questions $questions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Questions $questions
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if_forbidden('question.edit');

        $question = Question::find($id);


        $topics = Topic::all();

        $options = Options::where('question_id', $question->id)->get();


        return view('pages.questions.edit', compact('topics', 'question', 'options'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateQuestionsRequest $request
     * @param \App\Models\Questions $questions
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuetionsRequest $request, Question $questions, $id)
    {
        // abort_if_forbidden('question.edit');

        $question = Question::find($id);

         $validatedData = $request->validated();

//        dd($validatedData);
        $question->update([
            'question' => $validatedData['question'],
            'topic_id' => $validatedData['topic_id']
        ]);;

        $options = Options::where('question_id', $question->id)
            ->whereIn('id', $request->option_id)
            ->get();

        if ($request->status) {
            foreach ($request->option_id as $key => $id) {
                $status = isset($request->status[$id]) ? 1 : 0;
                $option = Options::where('question_id', $question->id)
                    ->where('id', $id)
                    ->first();
                $option->update([
                    'is_correct' => $status,
                    'option' => $request->option[$key],
                    'difficulty' => $request->difficulty[$key] * 10,
                ]);
            }
        } else {

            foreach ($request->option_id as $k => $id) {
                $option = Options::where('question_id', $question->id)
                    ->where('id', $id)
                    ->first();
                $option->update([
                    'is_correct' => 0,
                    'option' => $request->option[$key],
                    'difficulty' => $request->difficulty[$k] * 10,
                ]);
            }
        }





        return redirect()->route('questions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Quetions $quetions
     * @return \Illuminate\Http\Response
     */
    public function deleteAll(Request $request)
    {

        $ids = $request->ids;

        $res = Question::whereIn('id', $ids)->delete();
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

    public function destroy($quetions)
    {
        abort_if_forbidden('question.destroy');

        Question::find($quetions)->delete();
//        Options::where('$quetions',$quetions)->get();
        return redirect()->back();
    }
}
