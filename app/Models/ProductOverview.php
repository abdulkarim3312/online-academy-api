<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOverview extends Model
{
    use HasFactory;
    protected $table = 'product_overviews';
    protected $guarded = [];

    public function product_overview_content()
    {
        return $this->hasMany(ProductOverviewContent::class);
    }
}
