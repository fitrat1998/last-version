<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Examtype;
use App\Models\Result;
use Carbon\Carbon;

class Finalexams extends Component
{
    public $f;
    public $startTime;
    public $results = [];
    public $examTypes = [];
    public $latestResult = [];
    public $examTypeId = [];

    public function render()
    {
        $this->examTypes = Examtype::pluck('id');

        foreach ($this->examTypes as $this->examTypeId) {
            $latestResult = Result::where('examtypes_id', $this->examTypeId)
                ->latest('id')
                ->first();

            if (!is_null($this->latestResult)) {
                $this->results[] = $this->latestResult;
            }
        }

        

        $this->startTime = $this->startTime();

        return view('livewire.finalexams',['results'  => $this->results]);
    }

    private function startTime()
    {
        $givenTime = Carbon::create($this->f->start, 'Asia/Tashkent');
        return $givenTime->diffForHumans(now());
    }
}
