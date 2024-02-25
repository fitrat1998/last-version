<?php

namespace App\Http\Livewire;

use App\Models\Subject;
use App\Models\Topic;
use Livewire\Component;

class Subjects extends Component
{
    public $subjects;

    public $subject_id = null;
    public $showDiv = true;
    public $topics = [];

    public function OpenDiv()
    {
        $this->showDiv = true;
    }

    public function openSubject(int $id)
    {
        $this->topics = Topic::where('subject_id',$id)
            ->get();
    }

    public function render()
    {
        return view('livewire.subjects',[
            'subjects'  => $this->subjects
        ]);
    }
}
