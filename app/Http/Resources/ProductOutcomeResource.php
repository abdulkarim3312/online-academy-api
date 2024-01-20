<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
class ProductOutcomeResource extends JsonResource
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
            'title' => $this->title,
            'sub_title' => $this->sub_title,
            'outcome_one' => $this->outcome_one,
            'outcome_two' => $this->outcome_two,
            'note' => $this->note,
            'page_image' => $this->page_image ? Storage::url($this->page_image) : '',
        ];
    }
}
