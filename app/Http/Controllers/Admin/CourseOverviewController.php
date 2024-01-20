<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseOverview;
use App\Http\Resources\OverviewResource;

class CourseOverviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = CourseOverview::query();
        return OverviewResource::collection(executeQuery($query));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'sub_title' => 'required|string',
        ]);
        $overview = CourseOverview::create($data);
        return new OverviewResource($overview);
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseOverview $overview)
    {
        return new OverviewResource($overview);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseOverview $overview)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'sub_title' => 'required|string',
        ]);
        $overview->update($data);
        return new OverviewResource($overview);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseOverview $overview)
    {
        $overview->delete();
    }
}
