<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance_log extends Model
{
    use HasFactory;

    protected $fillable = [
        'groups_id',
        'subjects_id',
        'educationyears_id',
        'semesters_id',
        'lessontypes_id',
        'teachers_id',
    ];


    public function semesters()
    {
        return $this->hasMany(Semester::class);
    }
    public function group()
    {
        return $this->belongsTo(Group::class, 'groups_id', 'id');
    }

    public function educationyears()
    {
        return $this->hasMany(Educationyear::class);
    }
}
