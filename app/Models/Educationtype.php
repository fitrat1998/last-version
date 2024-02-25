<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Educationtype extends Model
{
    use HasFactory;

    protected $fillable = [
        'education_type',
    ];

    public function group()
    {
        return $this->hasMany(Group::class);
    }
}
