<?php

namespace App\Models;

use App\Models\Exercise;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Subject extends Model
{
    use HasFactory;

    public $table = 'subjects';


    protected $fillable = [
        'user_id',
        'subject_name',
    ];

    public function question()
    {
        return $this->hasMany(Question::class);
    }

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function exercise()
    {
        return $this->hasMany(Exercise::class, 'exercise_id', 'id');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'subject_has_group', 'subjects_id', 'groups_id');
    }

    public function check(int $subjects_id, int $id): bool
    {
        $group = DB::table('subject_has_group')
            ->where('subjects_id', '=', $subjects_id)
            ->get();

        foreach ($group as $g) {
            if ($id == $g->groups_id) {
                return true;
            }
        }

        return false;
    }

    public function mi()
    {
        $results = Result::where('subjects_id', $this->id)->where('users_id', auth()->user()->id)->get();
        $res = [];
        $eid = 2;
        $results = Result::where('subjects_id', $this->id)
            ->where('users_id', auth()->user()->id)
            ->where('examtypes_id', $eid)
            ->get();

        if (count($results) > 0) {
            $ry = Result::where('subjects_id', $this->id)
                ->where('users_id', auth()->user()->id)
                ->where('examtypes_id', $eid)
                ->pluck('quizzes_id');
            $quizs = collect($ry)->unique();

            $h = [];
            $sum = 0;

            foreach ($quizs as $q) {
                $rx = Result::where('subjects_id', $this->id)
                    ->where('users_id', auth()->user()->id)
                    ->where('examtypes_id', $eid)
                    ->where('quizzes_id', $q)
                    ->max('ball');
                $h[] = $rx;
                $sum += floatval($rx);
            }
        }
        return $sum;
    }

    public function onr()
    {
        $results = Result::where('subjects_id', $this->id)->where('users_id', auth()->user()->id)->get();
        $res = [];
        $eid = 1;
        $results = Result::where('subjects_id', $this->id)
            ->where('users_id', auth()->user()->id)
            ->where('examtypes_id', $eid)
            ->get();
        $sum = 0;
        if (count($results) > 0) {
            $ry = Result::where('subjects_id', $this->id)
                ->where('users_id', auth()->user()->id)
                ->where('examtypes_id', $eid)
                ->pluck('quizzes_id');
            $quizs = collect($ry)->unique();
            foreach ($quizs as $q) {
                $rx = Result::where('subjects_id', $this->id)
                    ->where('users_id', auth()->user()->id)
                    ->where('examtypes_id', $eid)
                    ->where('quizzes_id', $q)
                    ->max('ball');
                $sum += floatval($rx);
            }
        }
        return $sum;
    }

    public function jn()
    {
        $results = Result::where('subjects_id', $this->id)->where('users_id', auth()->user()->id)->get();
        $res = [];
        $eid = 5;
        $results = Result::where('subjects_id', $this->id)
            ->where('users_id', auth()->user()->id)
            ->where('examtypes_id', $eid)
            ->get();
        $sum = 0;
        if (count($results) > 0) {
            $ry = Result::where('subjects_id', $this->id)
                ->where('users_id', auth()->user()->id)
                ->where('examtypes_id', $eid)
                ->pluck('quizzes_id');
            $quizs = collect($ry)->unique();
            foreach ($quizs as $q) {
                $rx = Result::where('subjects_id', $this->id)
                    ->where('users_id', auth()->user()->id)
                    ->where('examtypes_id', $eid)
                    ->where('quizzes_id', $q)
                    ->max('ball');
                $sum += floatval($rx);
            }
        }
        return $sum;
    }

    public function yn()
    {
        $x = $this->jn() + $this->onr() + $this->mi();
        if ($x >= 30) {
            return $x;
        }
        else {
            return "-";
        }
    }
}
