<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Kirschbaum\PowerJoins\PowerJoins;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, PowerJoins, Billable;

    protected $table = 'users';

    protected $guarded = [];

    protected $casts = [];

    protected $dates = [
        'last_login',
        'registered_at'
    ];

    protected static function booted()
    {
        static::created(function ($user) {
            $user->createAsStripeCustomer();
        });
    }

    public function student()
    {
        return $this->hasOne(Student::class, 'user_id', 'id');
    }
    public function students()
    {
        return $this->hasMany(Student::class, 'user_id', 'id');
    }

    public function loginHistory()
    {
        return $this->hasMany(LoginHistory::class, 'user_id', 'id')->where('user_type', 'parent');
    }
}
