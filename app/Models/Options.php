<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
    use HasFactory;
    public $fillable = ['question_id','option','is_correct', 'difficulty'];


    public function question() {
        return $this->belongsTo(Question::class);
    }
}
