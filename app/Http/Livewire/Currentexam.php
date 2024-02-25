<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Currentexam extends Component
{
    public $c;
    public $startTime;

    public function render()
    {
        $this->startTime = $this->startTime();
        return view('livewire.currentexam');
    }

    private function startTime()
    {
        $givenTime = \Carbon\Carbon::create($this->c->start, 'Asia/Tashkent');
        return $givenTime->diffForHumans(now());
    }
}
