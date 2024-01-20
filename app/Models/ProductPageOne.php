<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPageOne extends Model
{
    use HasFactory;
    protected $table = 'product_welcome_pages';
    protected $guarded = [];
}
