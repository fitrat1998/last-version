<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Retrisexams extends Component
{
    public $r;
    public $startTime;

    public function render()
    {
        $this->startTime = $this->startTime();
        return view('livewire.retrisexams');
    }

    private function startTime()
    {
        $givenTime = \Carbon\Carbon::create($this->r->start,'Asia/Tashkent');
        return $givenTime->diffForHumans(now());
    }
}
