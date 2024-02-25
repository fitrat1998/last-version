<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programm extends Model
{
    use HasFactory;

    protected $fillable = [
        'faculty_id',
        'programm_name',
    ];

    public function Group()
    {
        return $this->hasMany(Group::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
}
