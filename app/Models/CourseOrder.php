<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;

class CourseOrder extends Model
{
    use HasFactory, PowerJoins;

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
        'next_billing_date' => 'datetime',
        'cancelled_at' => 'datetime',
        'ends_at' => 'datetime',
        'resumed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function course()
    {
        return $this->belongsTo(CourseDetail::class);
    }

    public function payments()
    {
        return $this->hasMany(UserPayment::class);
    }
}
