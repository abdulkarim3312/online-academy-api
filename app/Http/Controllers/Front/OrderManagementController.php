<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\PackageResource;
use App\Models\CourseDetail;
use App\Models\CourseOrder;
use App\Models\Package;
use App\Models\User;
use App\Models\UserPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Cashier;

class OrderManagementController extends Controller
{
    public function packages(){
        $packages = Package::where('status', 'active')->get();
        return PackageResource::collection($packages);
    }

    public function subscribe(Package $package,Request $request)
    {
        $stripe = Cashier::stripe();
        $payload = [
            'success_url' => env('FRONT_URL').'/subscription/complete?session_id={CHECKOUT_SESSION_ID}&user_id=' . $request->id,
            'cancel_url' => $request->url ? $request->url : env('FRONT_URL').'/pricing',
            'customer' => $request->stripe_id,
            'allow_promotion_codes' => true,
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price' => $package->stripe_price_id,
                    'quantity' => 1,
                ],
            ],
            'mode' => 'subscription'
        ];

        $stripeResponse = $stripe->checkout->sessions->create($payload);

        return response()->json([
            'data' => [
                'url' => $stripeResponse['url']
            ]
        ]);
    }

    public function checkSession(Request $request)
    {
        $data = $request->validate([
            'session_id' => 'required',
            'user_id' => 'required',
        ]);

        $stripe = Cashier::stripe();
        $user = User::where('id',$data['user_id'])->first();

        $sessionResponse = $stripe->checkout->sessions->retrieve(
            $data['session_id'],
            []
        );

        $exists = CourseOrder::where('stripe_session_id', $sessionResponse['id'])->first();

        if (!$exists && $sessionResponse['payment_status'] === 'paid' && $sessionResponse['status'] === 'complete') {
            $invoiceResponse = $stripe->invoices->retrieve(
                $sessionResponse['invoice'],
                []
            );

            $priceId = $invoiceResponse['lines']['data'][0]['price']['id'];
            $productId = $invoiceResponse['lines']['data'][0]['price']['product'];
            $package = Package::where('stripe_product_id', $productId)->first();
            $course_detail = CourseDetail::first();

            $course_order = CourseOrder::create([
                'user_id' => $user->id,
                'course_id' => $course_detail ? $course_detail->id : 1,//need to assign course id
                'package_id' => $package->id,
                'price_type' => $package->interval,
                'amount' => $invoiceResponse['total'] / 100,
                'stripe_price_id' => $priceId,
                'stripe_session_id' => $sessionResponse['id'],
                'stripe_subscription_id' => $sessionResponse['subscription'],
                'next_billing_date' => Carbon::parse($invoiceResponse['lines']['data'][0]['period']['end']),
            ]);

            $course_order->payments()->save(new UserPayment([
                'user_id' => $user->id,
                'package_id' => $package->id,
                'course_id' => $course_detail ? $course_detail->id : 1,
                'amount' => $invoiceResponse['total'] / 100,
                'payment_method' => $sessionResponse['payment_method_types'][0],
                'stripe_invoice_id' => $sessionResponse['invoice'],
                'stripe_invoice_number' => $invoiceResponse['number'],
                'stripe_invoice_pdf' => $invoiceResponse['invoice_pdf'],
                'stripe_payment_intent' => $invoiceResponse['payment_intent'],
            ]));
        }
    }
    public function currentSubscription()
    {
        $auth_parent = Auth::guard('parent')->user();

        $subscription = CourseOrder::with('package')->where([
            'vendor_id' => $auth_parent->id,
            'status' => 'active'
        ])->first();

        return response()->json($subscription);
    }
    public function subscriptionPaymentHistory()
    {
        $auth_parent = Auth::guard('parent')->user();

        $query = UserPayment::query()->with('package', 'subscription')->where('vendor_id', $auth_parent->id);


        return UserPaymentResource::collection(
            executeQuery($query)
        );
    }

    public function subscriptionCancel()
    {
        $vendor = auth('vendor')->user();

        $subscription = VendorSubscription::firstWhere([
            'vendor_id' => $vendor->id,
            'status' => 'active',
        ]);

        if ($subscription) {
            $stripe = Cashier::stripe();

            $response = $stripe->subscriptions->cancel(
                $subscription->stripe_subscription_id,
                ['prorate' => 'true']
            );

            if (isset($response) && $response->status == 'canceled') {
                $subscription->status = 'cancelled';
                $subscription->cancelled_at = now();
                $subscription->ends_at = now();

                $subscription->save();

                return response()->json(['success' => true, 'message' => 'Subscription has been canceled.']);
            }
        }

        return response()->json(['success' => false,'message' => 'User is not subscribed to any plan.']);
    }
}
