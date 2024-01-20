<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CurriculumResource;
use App\Models\CourseCircullum;

class CourseCurriculumController extends Controller
{
    public function index()
    {
        $query = CourseCircullum::query();
        return CurriculumResource::collection(executeQuery($query));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'circullum_title' => 'required|string',
        ]);
        $data['course_detail_id'] = 1;
        $requirement = CourseCircullum::create($data);
        return new CurriculumResource($requirement);
    }

    public function show(CourseCircullum $curriculum)
    {
        return new CurriculumResource($curriculum);
    }

    public function update(Request $request, CourseCircullum $curriculum)
    {
        $data = $request->validate([
            'circullum_title' => 'required|string',
        ]);
        $curriculum->update($data);
        return new CurriculumResource($curriculum);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseCircullum $curriculum)
    {
        $curriculum->delete();
    }

}
