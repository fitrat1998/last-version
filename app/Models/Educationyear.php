<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Educationyear extends Model
{
    use HasFactory;
    protected $fillable = [
        'education_year',
    ];

    public function group()
    {
        return $this->hasMany(Group::class);
    }
}
