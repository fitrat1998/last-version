<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;
use App\Models\Selfstudyexams;
use App\Models\Subject;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $questions = Question::all();
        return view('students.quiz', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreQuizRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuizRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $quiz = Selfstudyexams::find($id);

         $subject = Subject::find($quiz->subjects_id);

        if ($subject) {
            $questions = Question::whereIn('topic_id', $subject->topics->pluck('id'))
                ->orderByRaw('RAND()')
                ->get();

            $tests = $questions->chunk(1);

            return view('students.quiz', compact('subject', 'questions','quiz','tests'));
        } else {
            return view('students.quiz', ['subject' => null, 'questions' => null]);
        }


//        if ($subject) {
//            $topics = $subject->topics;

//            $questions = Question::whereIn('topic_id', $topics->pluck('id'))->get();
//
//            foreach ($questions as $question) {
//                echo "Savol: " . $question->question . "<br>";
//
//                $options = $question->options; // Savolning variantlari
//                foreach ($options as $option) {
//                    echo "Variant: " . $option->option . "<br>";
//                    echo "difficulty: " . $option->difficulty . "<br>";
//                }
//
//                echo "<br>";
//            }
//        } else {
//            echo "not found";
//        }
//        exit();

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function edit(Quiz $quiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateQuizRequest  $request
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuizRequest $request, Quiz $quiz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        //
    }
}
