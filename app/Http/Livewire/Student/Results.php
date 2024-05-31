<?php

namespace App\Http\Livewire\Student;

use App\Models\Examtype;
use App\Models\Result;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Results extends Component
{
    public $results,$subjects,$student,$subject,$subjects_id;

    public function render()
    {
        $student_id = auth()->user()->student_id ?? 0;
        $student = DB::table('student_has_attach')->where('students_id', $student_id)->first();
        $subject_id = DB::table('subject_has_group')->where('groups_id', $student->groups_id)->pluck('subjects_id');

        $this->subjects = Subject::whereIn('id',$subject_id)->get();
        $examptypes = Examtype::all();
        $this->results = [];

        foreach ($this->subjects as $subject) {
            $arr = [];
            foreach ($examptypes as $e) {
                $result = Result::where('users_id',auth()->user()->id)->where('examtypes_id',$e->id)->where('subjects_id',$subject->id)->get();

                if (count($result)) {
                    $arr[] = [
                        "examtypes" => $e->id,
                        "data"      => $result->sum('ball'),
                        "result"    => json_decode($result)
                    ];
                }
            }

            $this->results[] = [
                "subject" => $subject->id,
                "result"  => $arr,
            ];
        }

        dd($this->results);
        return view('livewire.student.results');
    }
}
