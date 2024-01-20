<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseRequirement;
use App\Models\CourseDetail;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\RequirementResource;

class CourseRequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = CourseRequirement::query();
        return RequirementResource::collection(executeQuery($query));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'requirement_title' => 'required|string',
        ]);
        $data['course_detail_id'] = 1;
        $requirement = CourseRequirement::create($data);
        return new RequirementResource($requirement);
    }

    public function show(CourseRequirement $requirement)
    {
        return new RequirementResource($requirement);
    }

    public function update(Request $request, CourseRequirement $requirement)
    {
        $data = $request->validate([
            'requirement_title' => 'required|string',
        ]);
        $requirement->update($data);
        return new RequirementResource($requirement);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseRequirement $requirement)
    {
        $requirement->delete();
    }
}
