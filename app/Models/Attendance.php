<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
    ];

    public function studenst()
    {
        return $this->HasMany(Student::class);
    }

    public function topics()
    {
        return $this->HasMany(Topic::class);
    }

    public function subjects()
    {
        return $this->HasMany(Subject::class);
    }

}
