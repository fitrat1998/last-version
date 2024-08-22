<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Selfstudyexams extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'user_id',
        'examtypes_id',
        'groups_id',
        'subjects_id',
        'semesters_id',
        'start',
        'end',
        'attempts',
        'passing',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class, 'groups_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subjects_id', 'id');
    }

    public function examtype()
    {
        return $this->belongsTo(Examtype::class, 'examtypes_id', 'id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semesters_id', 'id');
    }

    public function TimeStatus($start,$end): bool
    {
        $startVaqti = Carbon::createFromFormat('Y-m-d H:i:s', $start);
        $endVaqti = Carbon::createFromFormat('Y-m-d H:i:s', $end);

        $hozirgiVaqti = Carbon::now();
        return ($hozirgiVaqti->greaterThanOrEqualTo($startVaqti) && $hozirgiVaqti->lessThanOrEqualTo($endVaqti));
    }

    public function status($id){
        return count(ExamsStatusUser::where('user_id',$id)->get()) == 1;
    }

     public function duration($id)
    {

        $d = DB::table('quiz_has_duration')->where('quiz_id', $id)->first();


        if ($d && $d->duration > 0) {
            $minutes = $d->duration;
            $hours = floor($minutes / 60);
            $remainingMinutes = $minutes % 60;
            $seconds = 0;

            return sprintf('%02d:%02d:%02d', $hours, $remainingMinutes, $seconds);
        }


        return '00:00:00';
    }
}
