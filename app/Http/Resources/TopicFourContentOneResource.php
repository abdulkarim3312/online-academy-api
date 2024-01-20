<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TopicFourContentOneResource extends JsonResource
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
            'summary_one' => $this->summary_one ?? '',
            'summary_two' => $this->summary_two ?? '',
            'summary_three' => $this->summary_three ?? '',
            'image' => $this->image ? Storage::url($this->image): null
        ];
    }
}
