<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PackageResource;
use App\Models\Package;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $query = Package::query();

        if (isset($request->status) && $request->status !== 'all') {
            if ($request->status == 'inactive') {
                $status = 0;
            } else {
                $status = 1;
            }

            $query->where('status', $status);
        }

        return PackageResource::collection(executeQuery($query));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return PackageResource
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'status' => 'required|in:0,1',
            'user_capacity' => 'required|integer|min:1',
            'unit_amount' => 'required|integer',
            'interval' => 'required|in:day,month,week,month',
            'feature_one' => 'required|string',
            'feature_two' => 'nullable',
            'feature_three' => 'nullable',
            'feature_four' => 'nullable',
            'feature_five' => 'nullable',
        ]);
        try {
            DB::beginTransaction();

            $package = Package::create($data);
            //create product and pricing on step pay
            $this->create_stripe_product_and_prices($package);
            DB::commit();
            return new PackageResource($package);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $ex->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return PackageResource
     */
    public function show(Package $package)
    {
        return new PackageResource($package);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Package  $package
     * @return bool
     */
    public function update(Request $request, Package $package)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'status' => 'required|in:0,1',
            'user_capacity' => 'required|integer|min:1',
            'unit_amount' => 'required|integer',
            'interval' => 'required|in:day,month,week,month',
            'feature_one' => 'required|string',
            'feature_two' => 'nullable',
            'feature_three' => 'nullable',
            'feature_four' => 'nullable',
            'feature_five' => 'nullable',
        ]);

        try {
            DB::beginTransaction();
            $package->update($data);
            DB::commit();
            return new PackageResource($package);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $ex->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $package
     * @return bool
     */
    public function destroy(Package $package)
    {
        return $package->delete();
    }


    private function create_stripe_product_and_prices($package)
    {
        $product_response = Http::asForm()->withToken(env('STRIPE_SECRET'))
            ->post(env('STRIPE_API_URL') . '/products', [
                'name' => $package->name,
                'active' => 'true'
            ]);
        if ($product_response->successful()) {
            $stripe_product_id = $product_response['id'];
            $price_response = Http::asForm()->withToken(env('STRIPE_SECRET'))
                ->post(env('STRIPE_API_URL') . '/prices', [
                    'active' => 'true',
                    'currency' => 'gbp',
                    'product' => $stripe_product_id,
                    'unit_amount' => $package->unit_amount * 100,
                    'recurring' => [
                        'interval' => $package->interval,
                    ],
                ]);
            if ($price_response->successful()) {
                $stripe_price_id = $price_response['id'];
                $package->update([
                    'stripe_product_id' => $stripe_product_id,
                    'stripe_price_id' => $stripe_price_id,
                ]);
            }

        }
    }
}
