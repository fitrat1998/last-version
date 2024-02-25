<?php

namespace App\Http\Livewire;

use App\Models\Group;
use App\Models\Selfstudyexams;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RightSidebar extends Component
{
    public $subject;
    public $group;
    public $selfstudyexams;

    public function render()
    {
        $student_id = auth()->user()->id;

        $group_id = Student::find($student_id);

        if($group_id){
            $group_id = $group_id->group_id;
            $this->group = Group::find($group_id);

            $subjects_id = DB::table('subject_has_group')
                ->where('groups_id',$group_id)
                ->pluck('subjects_id');
            $this->selfstudyexams = Selfstudyexams::whereIn('subjects_id',$subjects_id)
                ->whereRaw('DATE(NOW()) BETWEEN start AND end')
                ->get();
        }
        return view('livewire.right-sidebar');
    }
}
