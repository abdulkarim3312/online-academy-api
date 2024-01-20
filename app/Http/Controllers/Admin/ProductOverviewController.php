<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ProductOverviewContentResource;
use App\Models\ProductOverviewContent;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class ProductOverviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = ProductOverviewContent::query();
        return ProductOverviewContentResource::collection(executeQuery($query));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    public function formatImage($file)
    {
        $images = Image::make($file)->encode('jpg');
        $imageName = 'content_image/' . Str::uuid() . '.jpg';
        Storage::put($imageName, $images);
        return $imageName;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
