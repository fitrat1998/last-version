<?php

namespace App\Http\Livewire;

use App\Models\Options;
use Livewire\Component;
use App\Models\Question;
use App\Models\Topic;
use Livewire\WithFileUploads;
use App\Imports\ImportQuestion;
use Maatwebsite\Excel\Facades\Excel;


class Questions extends Component
{
    use WithFileUploads;

    public $counter = 1;
    public $question = '';


    public $title = '';
    public $topic_id = '';


    public $variant = [];
    public $answer = [];
    public $difficulty = [];
    public $char = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'T', 'N', 'M', 'O'];
    public $excel;

    public $file;

    protected $rules = [
        'topic_id' => 'required|numeric',
        'variant' => 'required|array',
        'answer' => 'required|array',
        'difficulty' => 'required|array',
        'question' => 'required|string'
    ];

    public function countCreate()
    {
        if ($this->counter < 6) {
            $this->counter++;
        } else {
            session()->flash('errors', "Boshqa variant qo'shib bo'lmaydi");
        }
        // dd("S");
    }


    public function countTrash()
    {
        if ($this->counter > 0) {
            $this->counter--;
        } else {
            session()->flash('errors', "Boshqa variant o'chirib bo'lmaydi");
        }
        // dd("S");
    }

    public function create()
    {
        $date = $this->validate($this->rules);
        $que = Question::create([
            'topic_id' => $date['topic_id'],
            'question' => $date['question']
        ]);

        for ($i = 0; $i < count($date['variant']); $i++) {
        $difficulty = $date['difficulty'][$i];
            Options::create([
                'question_id' => $que->id,
                'option' => $date['variant'][$i],
                'is_correct' => $date['answer'][$i] ?? false,
                'difficulty' => $difficulty ?? 1,
            ]);
        }
        session()->flash('success', "Savol qo'shildi");
        return redirect()->route('questions.index');
    }

    public function import()
    {

        $import = Excel::import(new ImportQuestion, $this->excel);

       if($import){
         return redirect()->route('questions.index')->with('success', 'Savollar muvvafaqiyatli yuklandi');
       }

    }

    public function render()
    {
        $topics = Topic::get();
        return view('livewire.questions', compact('topics'));
    }
}
