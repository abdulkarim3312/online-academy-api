<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseOrderResource;
use App\Http\Resources\ProductResource;
use App\Models\CourseOrder;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function getAgentOrders(){
        $orders = CourseOrder::where('user_id', Auth::user()->id)->get();
        return CourseOrderResource::collection($orders->load('package'));
    }

    public function getProduct(){
        $product = Product::where('course_id', 1)->first();
        return new ProductResource($product);
    }
    public function getProductDetails(){
        $product = Product::where('course_id', 1)->first();
        return new ProductResource($product->load('product_welcome_page'));
    }
}
