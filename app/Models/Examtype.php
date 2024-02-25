<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examtype extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function middleexams()
    {
        return $this->belongsTo(Middleexam::class, 'foreign_key');
    }

}
