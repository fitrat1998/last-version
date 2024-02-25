<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use DateTimeInterface;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password','theme','login','teacher_id','student_id','role'
    ];
    public function setTheme(string $theme)
    {
        $this->theme = $theme;
        $this->save();
    }

    public function theme():array
    {
        $classes = [
            'default' => [
                'body' => '',
                'navbar' => ' navbar-light ',
                'sidebar' => 'sidebar-dark-primary ',
            ],
            'light' => [
                'body' => '',
                'navbar' => ' navbar-white ',
                'sidebar' => ' sidebar-light-lightblue '
            ],
            'dark' => [
                'body' => ' dark-mode ',
                'navbar' => ' navbar-dark ',
                'sidebar' => ' sidebar-dark-secondary '
            ]
        ];
        return $classes[$this->theme] ?? [
                'body' => '',
                'navbar' => ' navbar-light ',
                'sidebar' => ' sidebar-dark-primary ',
            ];
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
