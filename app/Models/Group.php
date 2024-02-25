<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    public $table = 'groups';

    protected $fillable = [
        'user_id',
        'name',
      
    ];

    public function subjecs()
    {
        return $this->belongsToMany(Subject::class, 'subject_has_group',  'groups_id','subjects_id');
    }

    public function student()
    {
        return $this->belongsToMany(Student::class,'id','student_id');
    }


}
