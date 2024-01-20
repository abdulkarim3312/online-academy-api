<?php

namespace App\Http\Controllers\Admin;

use Analytics;
use Carbon\Carbon;
use App\Models\PackageOrder;
use Illuminate\Http\Request;
use Spatie\Analytics\Period;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function todaysUniqueVisitor()
    {
        $startDate = Carbon::today()->subHours(8)->startOfDay();
        $endDate = Carbon::today()->subHours(8)->endOfDay();
        $period = Period::create($startDate, $endDate);
        $analyticsData = Analytics::fetchUserTypes($period);

        return response()->json(['data' => $analyticsData->sum('sessions')]);
    }

    public function thisWeekVisitors()
    {
        $startDate = Carbon::now()->subDays(7)->timezone('America/Los_Angeles')->startOfDay();
        $endDate = Carbon::now()->timezone('America/Los_Angeles')->endOfDay();
        $period = Period::create($startDate, $endDate);
        $analyticsData = Analytics::fetchTotalVisitorsAndPageViews($period);

        return response()->json(['data' => $analyticsData->sum('visitors')]);
    }

    public function thisMonthVisitors()
    {
        $startDate = Carbon::now()->subDays(30)->timezone('America/Los_Angeles')->startOfDay();
        $endDate = Carbon::now()->timezone('America/Los_Angeles')->endOfDay();
        $period = Period::create($startDate, $endDate);
        $analyticsData = Analytics::fetchTotalVisitorsAndPageViews($period);

        return response()->json(['data' => $analyticsData->sum('visitors')]);
    }

    public function newVisitors()
    {
        $startDate = Carbon::today()->subHours(8)->startOfDay();
        $endDate = Carbon::today()->subHours(8)->endOfDay();
        $period = Period::create($startDate, $endDate);
        $analyticsData = Analytics::fetchUserTypes($period);

        return response()->json(['data' => $analyticsData->sum('sessions')]);
    }

    public function liveVisitors()
    {
        $client = new \Google_Client();
        $client->setApplicationName("Sungwoo Solutions");
        $client->setAuthConfig(public_path('service-account-credentials.json'));
        $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
        $analytics = new \Google_Service_Analytics($client);


        $optParams = array(
            'dimensions' => 'rt:medium,rt:city,rt:pageTitle,rt:minutesAgo,rt:userType'
        );
        try {
            $results = $analytics->data_realtime->get(
                'ga:' . env('ANALYTICS_VIEW_ID'),
                'rt:activeUsers',
                $optParams
            );

            return $results->getTotalResults();
        } catch (\apiServiceException $e) {
            return $e->getMessage();
        }
    }

    public function totalSales()
    {
        $totalSaleAmount = PackageOrder::select('id', 'order_status', 'amount', 'created_at')
            ->where('order_status', '!=', 'rejected')
            ->whereDate('created_at', Carbon::today())
            ->sum('amount');

        return response()->json(['data' => number_format($totalSaleAmount, 2, '.', ',')]);
    }

    public function totalMonthlySales()
    {
        $totalMonthlySaleAmount = PackageOrder::select('id', 'order_status', 'amount', 'created_at')
            ->where('order_status', '!=', 'rejected')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('amount');

        return response()->json(['data' => number_format($totalMonthlySaleAmount, 2, '.', ',')]);
    }

    public function analyticsRevenueData()
    {
        $labels = [
            '총 수익'
        ];

        // $watched_videos = WatchHistory::whereHas('progress', function ($q) {
        //     $q->where('video_progress_percentage', 100);
        // })->where('student_id', Auth::user()->id)->count();

        // $watching_videos = WatchHistory::whereHas('progress', function ($q) {
        //     $q->where('video_progress_percentage', '>', 0);
        //     $q->where('video_progress_percentage', '<', 100);
        // })->where('student_id', Auth::user()->id)->count();

        // $video_ids = VideoProgress::where('video_progress_percentage', '>', 0)->where('student_id', Auth::user()->id)->get()->pluck('video_id');
        // $not_watch_videos = BulkVideo::whereNotIn('id', $video_ids)->count();

        $data = [100];

        return response()->json(['labels' => $labels, 'data' => $data]);
    }
}
