<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;
    public $table = 'faculties';

    protected $fillable = [
        'faculty_name',
    ];

    public function program()
    {
        return $this->hasMany(Programm::class);
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class,'id');
    }
}
