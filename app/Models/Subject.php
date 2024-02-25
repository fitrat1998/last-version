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
        return $this->hasMany(Exercise::class,'exercise_id','id');
    }

    public function groups() {
        return $this->belongsToMany(Group::class,'subject_has_group','subjects_id','groups_id');
    }

    public function check(int $subjects_id,int $id): bool
    {
        $group = DB::table('subject_has_group')
            ->where('subjects_id','=',$subjects_id)
            ->get();

        foreach ($group as $g){
            if($id == $g->groups_id){
                return true;
            }
        }

        return false;
    }
}
