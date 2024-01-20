<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ProductOverviewContentResource;
use App\Models\ProductOverviewContent;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class ProductOverviewContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = ProductOverviewContent::query();
        return ProductOverviewContentResource::collection(executeQuery($query->with('productOverview')));
    }


    public function formatImage($file)
    {
        $images = Image::make($file)->encode('jpg');
        $imageName = 'content_image/' . Str::uuid() . '.jpg';
        Storage::put($imageName, $images);
        return $imageName;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string',
            'short_description' => 'required|string',
            'long_description' => 'required|string',
        ]);
        $data['product_overview_id'] = 1;
        if ($request->hasFile('image')) {
            $data['image'] = $this->formatImage($request->file('image'));
        }
        $product_content = ProductOverviewContent::create($data);
        return new ProductOverviewContentResource($product_content);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product_overview_content = ProductOverviewContent::find($id);
        return new ProductOverviewContentResource($product_overview_content);
    }

    public function update($id, Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string',
            'short_description' => 'required|string',
            'long_description' => 'required|string',
        ]);
        $product_overview_content = ProductOverviewContent::find($id);
        $data['product_overview_id'] = 1;
        if ($request->hasFile('image')) {
            if ($product_overview_content->image != null) {
                if (Storage::exists($product_overview_content->image))
                    Storage::delete($product_overview_content->image);
            }
            $data['image'] = $this->formatImage($request->file('image'));
        } else if ($request->image) {
            $data['image'] = $product_overview_content->image;
        } else {
            $data['image'] = null;
        }
        $product_overview_content->update($data);
        return new ProductOverviewContentResource($product_overview_content);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product_overview_content = ProductOverviewContent::find($id);
        if ($product_overview_content->image != null) {
            if (Storage::exists($product_overview_content->image))
                Storage::delete($product_overview_content->image);
        }
        return $product_overview_content->delete();
    }
}
