<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'date',
        'lessontypes_id',
        'teachers_id',
        'groups_id',
        'semesters_id',
        'subjects_id',
        'topics_id',
        'educationyears_id'
    ];

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semesters_id', 'id');
    }
    public function group()
    {
        return $this->belongsTo(Group::class, 'groups_id', 'id');
    }

    public function lessontype()
    {
        return $this->belongsTo(Lessontype::class, 'lessontypes_id', 'id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teachers_id', 'id');
    }

    public function educationyear()
    {
        return $this->belongsTo(Educationyear::class, 'educationyears_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subjects_id', 'id');
    }
}
