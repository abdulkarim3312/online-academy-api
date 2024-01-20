<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TopicOneContentFiveResource extends JsonResource
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
            'point_five_content' => $this->point_five_content ?? '',
            'point_six_content' => $this->point_six_content ?? '',
            'point_seven_content' => $this->point_seven_content ?? '',
            'point_eight_content' => $this->point_eight_content ?? '',
            'point_nine_content' => $this->point_nine_content ?? '',
            'image' => $this->image ? Storage::url($this->image): null,
        ];
    }
}
