<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Kirschbaum\PowerJoins\PowerJoins;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, PowerJoins;

    protected $table = 'students';
    protected $guarded = [];

    protected $dates = [
        'last_login',
        'registered_at'
    ];

    public function parents()
    {
        return $this->belongsTO(User::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(PackageOrder::class, 'student_id', 'id');
    }

    public function loginHistory()
    {
        return $this->hasMany(LoginHistory::class, 'user_id', 'id')->where('user_type', 'student');
    }
}
