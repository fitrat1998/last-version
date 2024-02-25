<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendancecheck extends Model
{
    use HasFactory;
    public $table = "attendance_checks";

    protected $fillable = [
        'absent',
        'exercises_id',
        'students_id',
        'topics_id',
        'subjects_id'
    ];

}
