<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseOrderResource;
use App\Models\CourseOrder;
use Illuminate\Http\Request;

class OrderController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $query = CourseOrder::query();

        if (isset($request->is_active) && $request->is_active !== '')
            $query->where('is_active', $request->is_active);

        return CourseOrderResource::collection(executeQuery($query->with('user', 'package')));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return PackageResource
     */
    public function show($id)
    {
        $course_order = CourseOrder::find($id);
        return new CourseOrderResource($course_order->load('user', 'package', 'payments'));
    }

    public function update(Request $request, $id)
    {
        $course_order = CourseOrder::find($id);
        $course_order->order_status = $request->order_status;
        $course_order->note = $request->note;
        $course_order->save();
    }

    public function destroy($id)
    {
        $course_order = CourseOrder::where('id', $id)->first();
        if ($course_order)
            $course_order->delete();

        return response()->json(['success' => true, 'message' => '삭제 성공']);
    }

    public function getOrderDetails($id){
        $course_order = CourseOrder::find($id);
        return new CourseOrderResource($course_order->load('user', 'package', 'payments'));
    }
}
