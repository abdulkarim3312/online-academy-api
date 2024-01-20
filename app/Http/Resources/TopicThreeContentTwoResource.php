<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TopicThreeContentTwoResource extends JsonResource
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
            'term_one_title' => $this->term_one_title ?? '',
            'term_one_content' => $this->term_one_content ?? '',
            'term_one_topic' => $this->term_one_topic ?? '',
            'term_one_topic_desc' => $this->term_one_topic_desc ?? '',
            'term_one_image' => $this->term_one_image ? Storage::url($this->term_one_image): null,
            'term_two_title' => $this->term_two_title ?? '',
            'term_two_content' => $this->term_two_content ?? '',
            'term_two_topic' => $this->term_two_topic ?? '',
            'term_two_topic_desc' => $this->term_two_topic_desc ?? '',
            'term_two_image' => $this->term_two_image ? Storage::url($this->term_two_image): null,
            'term_three_title' => $this->term_three_title ?? '',
            'term_three_content' => $this->term_three_content ?? '',
            'term_three_topic' => $this->term_three_topic ?? '',
            'term_three_topic_desc' => $this->term_three_topic_desc ?? '',
            'term_three_image' => $this->term_three_image ? Storage::url($this->term_three_image): null,
            'term_four_title' => $this->term_four_title ?? '',
            'term_four_content' => $this->term_four_content ?? '',
            'term_four_topic' => $this->term_four_topic ?? '',
            'term_four_topic_desc' => $this->term_four_topic_desc ?? '',
            'term_four_image' => $this->term_four_image ? Storage::url($this->term_four_image): null
        ];
    }
}
