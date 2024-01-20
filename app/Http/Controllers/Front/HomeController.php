<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseDetailsResource;
use App\Http\Resources\HomeBannerResource;
use App\Http\Resources\OverviewResource;
use App\Models\CourseDetail;
use App\Models\CourseOverview;
use App\Models\HomeBanner;

class HomeController extends Controller
{
    public function getHomeBanner()
    {
        $home_banner = HomeBanner::first();

        if ($home_banner) {
            return new HomeBannerResource($home_banner);
        } else {
            return response()->json(['data' => [], 'success' => true, 'message' => 'No data found!']);
        }
    }

    public function getOverviews()
    {
        $overviews = CourseOverview::take(3)->get();
        return OverviewResource::collection($overviews);
    }

    public function getCourseData()
    {
        $course = CourseDetail::with('course_circullums','course_requirements')->first();
        return new CourseDetailsResource($course);
    }
}
