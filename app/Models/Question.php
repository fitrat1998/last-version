<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    public $fillable = ['question','topic_id'];

    public function options()
    {
        return $this->hasMany(Options::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function Subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
