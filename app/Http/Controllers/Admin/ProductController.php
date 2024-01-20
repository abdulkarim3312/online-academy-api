<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductOverview;
use Illuminate\Http\Request;
use App\Http\Resources\ProductOverviewResource;
use App\Http\Resources\ProductOutcomeResource;
use App\Http\Resources\ProductWelcomeResource;
use App\Http\Resources\ProductOverviewContentResource;
use App\Http\Resources\ProductResource;
use App\Models\ProductOutcome;
use App\Models\ProductWelcomePage;
use App\Models\ProductOverviewContent;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class ProductController extends Controller
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


    public function show(ProductOverviewContent $item)
    {
        return new ProductOverviewContentResource($item);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductOverviewContent $item)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'short_description' => 'required|string',
            'long_description' => 'required|string',
        ]);
        $data['product_overview_id'] = 1;
        if ($request->hasFile('image')) {
            if ($item->image != null) {
                if (Storage::exists($item->image))
                    Storage::delete($item->image);
            }
            $data['image'] = $this->formatImage($request->file('image'));
        } else if ($request->image) {
            $data['image'] = $item->image;
        } else {
            $data['image'] = null;
        }
        $item->update($data);
        return new ProductOverviewContentResource($item);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductOverviewContent $item)
    {
        $item->delete();
    }

    public function getOverviewData(ProductOverview $item)
    {
        $item = ProductOverview::first();
        return new ProductOverviewResource($item);
    }

    public function createOrUpdateProductOverview(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'sub_title' => 'required|string',
            'footer' => 'required|string',
        ]);
       $check = ProductOverview::first();
       if($check){
            $data['product_id'] = 1;
            $check->update($data);
       }else{
            $data['product_id'] = 1;
            $check = ProductOverview::create($data);
       }
    }
    public function getOutcomeData(ProductOutcome $item)
    {
        $item = ProductOutcome::first();
        return new ProductOutcomeResource($item);
    }

    public function createOrUpdateProductOutcome(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'sub_title' => 'required|string',
            'outcome_one' => 'required|string',
            'outcome_two' => 'required|string',
            'note' => 'required|string',
        ]);
        $page_image = ProductOutcome::first();
        if($page_image){
            if ($request->hasFile('page_image')) {
                if ($page_image->page_image != null) {
                    if (Storage::exists($page_image->page_image))
                        Storage::delete($page_image->page_image);
                }
                $data['page_image'] = $this->formatImageOutcome($request->file('page_image'));
            } else if ($request->page_image) {
                $data['page_image'] = $page_image->page_image;
            } else {
                $data['page_image'] = null;
            }
            $data['product_id'] = 1;
            $page_image->update($data);
        }else{
            if ($request->hasFile('page_image')) {
                $data['page_image'] = $this->formatImageOutcome($request->file('page_image'));
            }
            $data['product_id'] = 1;
            ProductOutcome::create($data);
        }
    }

    public function formatImageOutcome($file)
    {
        $images = Image::make($file)->encode('jpg');
        $imageName = 'outcome_image/' . Str::uuid() . '.jpg';
        Storage::put($imageName, $images);
        return $imageName;
    }

    public function getWelcomeData(ProductWelcomePage $item)
    {
        $item = ProductWelcomePage::first();
        return new ProductWelcomeResource($item);
    }

    public function createOrUpdateProductWelcome(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'note' => 'required|string',
        ]);
        $page_image = ProductWelcomePage::first();
        if($page_image){
            if ($request->hasFile('page_image')) {
                if ($page_image->page_image != null) {
                    if (Storage::exists($page_image->page_image))
                        Storage::delete($page_image->page_image);
                }
                $data['page_image'] = $this->formatImageWelcome($request->file('page_image'));
            } else if ($request->page_image) {
                $data['page_image'] = $page_image->page_image;
            } else {
                $data['page_image'] = null;
            }
            $data['product_id'] = 1;
            $page_image->update($data);
        }else{
            if ($request->hasFile('page_image')) {
                $data['page_image'] = $this->formatImageWelcome($request->file('page_image'));
            }
            $data['product_id'] = 1;
            ProductWelcomePage::create($data);
        }
    }

    public function formatImageWelcome($file)
    {
        $images = Image::make($file)->encode('jpg');
        $imageName = 'welcome_image/' . Str::uuid() . '.jpg';
        Storage::put($imageName, $images);
        return $imageName;
    }

    public function getProductData(Product $item)
    {
        $item = Product::first();
        return new ProductResource($item);
    }

    public function createOrUpdateProduct(Request $request)
    {
        $data = $request->validate([
            'product_title' => 'required|string',
            'product_sub_title' => 'required|string',
        ]);
        $exits_data = Product::first();
        if($exits_data){
            if ($request->hasFile('product_logo')) {
                if ($exits_data->product_logo != null) {
                    if (Storage::exists($exits_data->product_logo))
                        Storage::delete($exits_data->product_logo);
                }
                $data['product_logo'] = $this->formatImageProduct($request->file('product_logo'));
            } else if ($request->product_logo) {
                $data['product_logo'] = $exits_data->product_logo;
            } else {
                $data['product_logo'] = null;
            }

            if ($request->hasFile('product_image')) {
                if ($exits_data->product_image != null) {
                    if (Storage::exists($exits_data->product_image))
                        Storage::delete($exits_data->product_image);
                }
                $data['product_image'] = $this->formatImageProduct($request->file('product_image'));
            } else if ($request->product_image) {
                $data['product_image'] = $exits_data->product_image;
            } else {
                $data['product_image'] = null;
            }

            $exits_data->update($data);

        }else{
            if ($request->hasFile('product_logo')) {
                $data['product_logo'] = $this->formatImageProduct($request->file('product_logo'));
            }
            if ($request->hasFile('product_image')) {
                $data['product_image'] = $this->formatImageProduct($request->file('product_image'));
            }
            $data['course_id'] = 1;
            Product::create($data);
        }
    }

    public function formatImageProduct($file)
    {
        $images = Image::make($file)->encode('jpg');
        $imageName = 'product_image/' . Str::uuid() . '.jpg';
        Storage::put($imageName, $images);
        return $imageName;
    }
}
