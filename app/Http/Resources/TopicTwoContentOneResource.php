<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TopicTwoContentOneResource extends JsonResource
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
            'id' => $this->id ?? '',
            'title' => $this->title ?? '',
            'description' => $this->description ?? '',
            'details_one' => $this->details_one ?? '',
            'details_two' => $this->details_two ?? '',
            'details_three' => $this->details_three ?? '',
            'image' => $this->image ? Storage::url($this->image): null,
        ];
    }
}
