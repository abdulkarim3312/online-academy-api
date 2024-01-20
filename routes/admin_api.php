<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ParentController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\CourseOverviewController;
use App\Http\Controllers\Admin\CourseRequirementController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\CourseCurriculumController;
use App\Http\Controllers\Admin\ExtendLearningController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductOverviewContentController;
use App\Http\Controllers\Admin\TopicFourController;
use App\Http\Controllers\Admin\TopicOneController;
use App\Http\Controllers\Admin\TopicThreeController;
use App\Http\Controllers\Admin\TopicTwoController;

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

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth.lfm')->prefix('ly-lfm')->group(function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

//Remove Duplicate


Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);

    //Dashboard

    // Agent
    Route::apiResource('parents', ParentController::class);

    // Student
    Route::apiResource('students', StudentController::class);

    // Package
    Route::apiResource('packages', PackageController::class);

    // Orders
    Route::apiResource('orders', OrderController::class);

    Route::get('order-details', [OrderController::class, 'getOrderDetails']);

    // Course Overview
    Route::apiResource('overviews', CourseOverviewController::class);

    // Course Requirement
    Route::apiResource('requirements', CourseRequirementController::class);

    // Course Curriculum
    Route::apiResource('curriculums', CourseCurriculumController::class);

    // Product Content
    Route::apiResource('product-content-overview', ProductOverviewContentController::class);
    // Product overview
    Route::post('product-overview', [ProductController::class, 'createOrUpdateProductOverview']);
    Route::get('product-overview-data', [ProductController::class, 'getOverviewData']);
    // Product outcome
    Route::post('product-outcome', [ProductController::class, 'createOrUpdateProductOutcome']);
    Route::get('product-outcome-data', [ProductController::class, 'getOutcomeData']);
    // Product Welcome
    Route::post('product-welcome', [ProductController::class, 'createOrUpdateProductWelcome']);
    Route::get('product-welcome-data', [ProductController::class, 'getWelcomeData']);
    // Product
    Route::post('product', [ProductController::class, 'createOrUpdateProduct']);
    Route::get('product-data', [ProductController::class, 'getProductData']);

    // Topic One Content One Route
    Route::post('topic-one-content-one', [TopicOneController::class, 'createOrUpdateTopicOneContentOne']);
    Route::get('topic-one-content-data', [TopicOneController::class, 'getTopicOneContentOneData']);

    // Topic One Content Two Route
    Route::post('topic-one-content-two', [TopicOneController::class, 'createOrUpdateTopicOneContentTwo']);
    Route::get('topic-one-content-two-data', [TopicOneController::class, 'getTopicOneContentTwoData']);

    // Topic One Content Three Route
    Route::post('topic-one-content-three', [TopicOneController::class, 'createOrUpdateTopicOneContentThree']);
    Route::get('topic-one-content-three-data', [TopicOneController::class, 'getTopicOneContentThreeData']);

    // Topic One Content Four Route
    Route::post('topic-one-content-four', [TopicOneController::class, 'createOrUpdateTopicOneContentFour']);
    Route::get('topic-one-content-four-data', [TopicOneController::class, 'getTopicOneContentFourData']);

    // Topic One Content Four Route
    Route::post('topic-one-content-five', [TopicOneController::class, 'createOrUpdateTopicOneContentFive']);
    Route::get('topic-one-content-five-data', [TopicOneController::class, 'getTopicOneContentFiveData']);

    // Topic Two Content One Route
    Route::post('topic-two-content-one', [TopicTwoController::class, 'createOrUpdateTopicTwoContentOne']);
    Route::get('topic-two-content-one-data', [TopicTwoController::class, 'getTopicTwoContentOneData']);
    // Topic Two Content One Route
    Route::post('topic-two-content-two', [TopicTwoController::class, 'createOrUpdateTopicTwoContentTwo']);
    Route::get('topic-two-content-two-data', [TopicTwoController::class, 'getTopicTwoContentTwoData']);

    // Topic Two Content Three Route
    Route::post('topic-two-content-three', [TopicTwoController::class, 'createOrUpdateTopicTwoContentThree']);
    Route::get('topic-two-content-three-data', [TopicTwoController::class, 'getTopicTwoContentThreeData']);

    // Topic Two Content Four Route
    Route::post('topic-two-content-four', [TopicTwoController::class, 'createOrUpdateTopicTwoContentFour']);
    Route::get('topic-two-content-four-data', [TopicTwoController::class, 'getTopicTwoContentFourData']);

    // Topic Two Content Five Route
    Route::post('topic-two-content-five', [TopicTwoController::class, 'createOrUpdateTopicTwoContentFive']);
    Route::get('topic-two-content-five-data', [TopicTwoController::class, 'getTopicTwoContentFiveData']);

    // Topic Two Content Five Route
    Route::post('topic-two-content-six', [TopicTwoController::class, 'createOrUpdateTopicTwoContentSix']);
    Route::get('topic-two-content-six-data', [TopicTwoController::class, 'getTopicTwoContentSixData']);

    // Topic Four Content One Route
    Route::post('topic-four-content-one', [TopicFourController::class, 'createOrUpdateTopicFourContentOne']);
    Route::get('topic-four-content-one-data', [TopicFourController::class, 'getTopicFourContentOneData']);

    // Topic Four Content Two Route
    Route::post('topic-four-content-two', [TopicFourController::class, 'createOrUpdateTopicFourContentTwo']);
    Route::get('topic-four-content-two-data', [TopicFourController::class, 'getTopicFourContentTwoData']);

    // Topic Three Content One Route
    Route::post('topic-three-content-one', [TopicThreeController::class, 'createOrUpdateTopicThreeContentOne']);
    Route::get('topic-three-content-one-data', [TopicThreeController::class, 'getTopicThreeContentOneData']);

    // Topic Three Content Two Route
    Route::post('topic-three-content-two', [TopicThreeController::class, 'createOrUpdateTopicThreeContentTwo']);
    Route::get('topic-three-content-two-data', [TopicThreeController::class, 'getTopicThreeContentTwoData']);

    // Extend learning Route
    Route::post('extend-learning', [ExtendLearningController::class, 'createOrUpdateExtendLearning']);
    Route::get('extend-learning-data', [ExtendLearningController::class, 'getExtendLearningData']);

    Route::get('course-details', [SettingsController::class, 'getCourseDetails']);
    Route::post('course-details', [SettingsController::class, 'createOrUpdateCourseDetails']);
    Route::get('home-banner', [SettingsController::class, 'getHomeBanner']);
    Route::post('home-banner', [SettingsController::class, 'createOrUpdateHomeBanner']);

    Route::get('about-us-data', [SettingsController::class, 'getAboutUsData']);
    Route::post('about-us', [SettingsController::class, 'createOrUpdateAboutUs']);

    Route::get('logo-data', [SettingsController::class, 'getLogoData']);
    Route::post('logo', [SettingsController::class, 'createOrUpdateLogo']);
});
