<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TopicTwoContentSixResource extends JsonResource
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
            'footer_title' => $this->footer_title ?? '',
            'point_one_content' => $this->point_one_content ?? '',
            'point_two_content' => $this->point_two_content ?? '',
            'point_three_content' => $this->point_three_content ?? '',
            'point_four_content' => $this->point_four_content ?? '',
            'image' => $this->image ? Storage::url($this->image): null
        ];
    }
}
