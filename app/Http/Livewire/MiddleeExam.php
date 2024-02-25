<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;

class MiddleeExam extends Component
{
    public $m;
    public $startTime;

    public function render()
    {
        $this->startTime = $this->startTime();
        return view('livewire.middlee-exam');
    }

    private function startTime()
    {
        $givenTime = \Carbon\Carbon::create($this->m->start,'Asia/Tashkent');
        return $givenTime->diffForHumans(now());
    }
}
