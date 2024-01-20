<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\AuthController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\OrderManagementController;
use App\Http\Controllers\Front\UserDashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::post('/forgot/password', [AuthController::class, 'forgotPassword']);
Route::post('/reset/password', [AuthController::class, 'resetPassword']);

Route::get('home-banner', [HomeController::class, 'getHomeBanner']);
Route::get('overviews', [HomeController::class, 'getOverviews']);
Route::get('course', [HomeController::class, 'getCourseData']);
Route::get('packages', [OrderManagementController::class, 'packages']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('orders', [UserDashboardController::class, 'getAgentOrders']);
    Route::get('get-product', [UserDashboardController::class, 'getProduct']);
    Route::get('get-product-details', [UserDashboardController::class, 'getProductDetails']);
});

Route::post('package-subscribe/{package}', [OrderManagementController::class, 'subscribe'])->name('subscribe');
Route::post('user-subscribe-check-session', [OrderManagementController::class, 'checkSession'])->name('subscribe.checkSession');