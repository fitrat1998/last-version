<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Student extends Authenticatable
{
    use HasFactory, HasRoles;
    public $table = 'students';

    protected $fillable = [
        'user_id',
        'fullname',
        'photo',
        'programm_id',
        'email',
        'phone',
        'login',
        'password',
    ];
    /**
     * @var mixed
     */


    public function group()
    {
        $student_id = $this->id;

        $groupAttach = DB::table('student_has_attach')
            ->where('students_id', $student_id)
            ->get();

        if (count($groupAttach) > 0) {
            $group = Group::find($groupAttach[0]->groups_id);

            if ($group) {
                return $group->name;
            }

            return "Bunday guruh mavjud emas";
        }

        return "Biriktirilmagan";
    }

}
