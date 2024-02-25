<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class Teacher extends Authenticatable
{
    use HasRoles;
    public $table = 'teachers';

    public $fillable = [
        'fullname',
        'status',
        'photo',
        'email',
        'phone',
        'login',
        'password',
        'faculties_id',
    ];

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function faculties()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function attendance_log_id()
    {
        return $this->hasMany(Attendance_log::class);
    }
}
