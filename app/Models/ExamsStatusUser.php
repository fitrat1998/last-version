<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamsStatusUser extends Model
{
    use HasFactory;

    protected $fillable = ['examtypes_id','exams_id','user_id'];

}