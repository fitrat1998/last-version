<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;

class SelfStudy extends Component
{
    public $s;
    public $startTime;

    public function render()
    {
        $this->startTime = $this->startTime();
        return view('livewire.self-study');
    }

    private function startTime()
    {
        $givenTime = \Carbon\Carbon::create($this->s->start,'Asia/Tashkent');
        return $givenTime->diffForHumans(now());
    }
}
