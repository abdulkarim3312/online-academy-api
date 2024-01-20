<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{

    public function formatted_interval($value)
    {
        $valueText = '';
        switch ($value) {
            case 'day':
                $valueText = 'Daily';
                break;
            case 'week':
                $valueText = 'Weekly';
                break;
            case 'month':
                $valueText = 'Monthly';
                break;
            case 'year':
                $valueText = 'yearly';
                break;

            default:
                # code...
                break;
        }

        return $valueText;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status ? '1' : '0',
            'formatted_status' => $this->status ? __('admin.form.active') : __('admin.form.in_active'),
            'currency' => $this->currency,
            'user_capacity' => $this->user_capacity,
            'unit_amount' => $this->unit_amount,
            'interval' => $this->interval,
            'formatted_interval' => $this->interval ? $this->formatted_interval($this->interval) : '',
            'feature_one' => $this->feature_one,
            'feature_two' => $this->feature_two,
            'feature_three' => $this->feature_three,
            'feature_four' => $this->feature_four,
            'feature_five' => $this->feature_five,
            'stripe_product_id' => $this->stripe_product_id,
            'stripe_price_id' => $this->stripe_price_id
        ];
    }
}
