<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachstudent extends Model
{
    use HasFactory;
protected $fillable = [
    'students_id',
    'faculties_id',
    'educationtypes_id',
    'groups_id',
    'educationyears_id',
    'semesters_id'
];

    public function student()
    {
        return $this->hasMany(Student::class,'student_id','id');
    }

    public function programm()
    {
        return $this->hasMany(Programm::class,'programm_id','id');
    }


    public function educationform()
    {
        return $this->hasMany(Formofeducation::class,'student_id','id');
    }

    public function educationtype()
    {
        return $this->hasMany(Educationtype::class,'student_id','id');
    }
}
