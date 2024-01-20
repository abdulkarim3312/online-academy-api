<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductOverviewContentResource extends JsonResource
{

    public function get_photo($photo)
    {
        $findPhoto = '';

        if (Storage::exists($photo)) {
            $findPhoto = Storage::url($photo);
        } else {
            $findPhoto = asset($photo);
        }

        return $findPhoto;
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
            'product_overview_id' => $this->product_overview_id,
            'title' => $this->title,
            'short_description' => $this->short_description,
            'long_description' => $this->long_description,
            'image' => $this->image ? Storage::url($this->image) : '',
        ];
    }
}
