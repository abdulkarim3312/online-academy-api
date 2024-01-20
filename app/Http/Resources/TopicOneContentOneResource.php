<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TopicOneContentOneResource extends JsonResource
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
            'short_description' => $this->short_description ?? '',
            'image' => $this->image ? Storage::url($this->image) : '',
            'video' => $this->video ? Storage::url('topic_one_content_one_image/'.$this->video) : '',
        ];
    }
}
