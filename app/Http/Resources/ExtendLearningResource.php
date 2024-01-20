<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ExtendLearningResource extends JsonResource
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
            'sub_title' => $this->sub_title ?? '',
            'sub_sub_title' => $this->sub_sub_title ?? '',
            'footer' => $this->footer ?? '',
            'do_more_title' => $this->do_more_title ?? '',
            'do_more_description' => $this->do_more_description ?? '',
            'learn_more_title' => $this->learn_more_title ?? '',
            'learn_more_description' => $this->learn_more_description ?? '',
        ];
    }
}
