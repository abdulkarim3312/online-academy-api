<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
{

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
            'product_title' => $this->product_title,
            'product_sub_title' => $this->product_sub_title,
            'product_image' => $this->product_image ? Storage::url($this->product_image) : '',
            'product_logo' => $this->product_logo ? Storage::url($this->product_logo) : '',
            'product_welcome_page' => new ProductWelcomeResource($this->whenLoaded('product_welcome_page')),
        ];
    }
}
