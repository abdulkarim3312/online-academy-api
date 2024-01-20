<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TopicTwoContentFourResource extends JsonResource
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
            'footer_title' => $this->footer_title ?? '',
            'description' => $this->description ?? '',
            'term_one_title' => $this->term_one_title ?? '',
            'term_one_sub_title' => $this->term_one_sub_title ?? '',
            'term_one_content_one' => $this->term_one_content_one ?? '',
            'term_one_content_two' => $this->term_one_content_two ?? '',
            'term_two_title' => $this->term_two_title ?? '',
            'term_two_sub_title' => $this->term_two_sub_title ?? '',
            'term_two_content' => $this->term_two_content ?? '',
            'term_three_title' => $this->term_three_title ?? '',
            'term_three_sub_title' => $this->term_three_sub_title ?? '',
            'term_three_content' => $this->term_three_content ?? '',
            'term_four_title' => $this->term_four_title ?? '',
            'term_four_sub_title' => $this->term_four_sub_title ?? '',
            'term_four_content' => $this->term_four_content ?? '',
        ];
    }
}
