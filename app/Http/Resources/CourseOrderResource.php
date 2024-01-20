<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'course_id' => $this->course_id,
            'package_id' => $this->package_id,
            'price_type' => $this->price_type,
            'amount' => $this->amount,
            'amount_formated' => '£ '.$this->amount,
            'stripe_price_id' => $this->stripe_price_id,
            'stripe_session_id' => $this->stripe_session_id,
            'stripe_subscription_id' => $this->stripe_subscription_id,
            'next_billing_date' => $this->next_billing_date ? $this->next_billing_date->format('d/m/Y h:i:s') : null,
            'is_active' => $this->is_active,
            'formatted_order_status' => $this->is_active == 1 ? 'Active' : 'Inactive',
            'cancelled_at' => $this->cancelled_at ? $this->cancelled_at->format('d/m/Y h:i:s') : null,
            'ends_at' => $this->ends_at ? $this->ends_at->format('d/m/Y h:i:s') : null,
            'resumed_at' => $this->resumed_at ? $this->resumed_at->format('d/m/Y h:i:s') : null,
            'created_at' => $this->created_at ? $this->created_at->format('d/m/Y h:i:s') : null,
            'user' => new ParentResource($this->whenLoaded('user')),
            'package' => new PackageResource($this->whenLoaded('package')),
            'course' => new CourseDetailsResource($this->whenLoaded('course')),
            'payments' => UserPaymentResource::collection($this->whenLoaded('payments')),
        ];
    }
}
