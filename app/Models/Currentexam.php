<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currentexam extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
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

    public function TimeStatus($start, $end): bool
    {
        $start = Carbon::createFromFormat('Y-m-d H:i:s', $start);
        $end = Carbon::createFromFormat('Y-m-d H:i:s', $end);

        $today = Carbon::now();
        return ($today->greaterThanOrEqualTo($start) && $today->lessThanOrEqualTo($end));
    }

    public function status($id)
    {
        return count(ExamsStatusUser::where('user_id', $id)->get()) == 1;
    }
}
