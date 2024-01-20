<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'orders';
    protected $guarded = [];
    protected $casts = [
        'order_init_at' => 'datetime',
        'order_accepted_at' => 'datetime',
        'order_delivered_at' => 'datetime',
        'order_canceled_at' => 'datetime',
        'transaction_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
