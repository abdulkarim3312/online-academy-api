<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $guarded = [];

    public function product_welcome_page()
    {
        return $this->hasOne(ProductWelcomePage::class);
    }

    public function product_outcome()
    {
        return $this->hasOne(ProductOutcome::class);
    }

    public function product_overview()
    {
        return $this->hasOne(ProductOverview::class);
    }
}
