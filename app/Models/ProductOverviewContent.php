<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOverviewContent extends Model
{
    use HasFactory;
    protected $table = 'product_overview_contents';
    protected $guarded = [];

    public function productOverview(){
        return $this->belongsTo(ProductOverview::class, 'product_overview_id');
    }
}
