<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CourseDetailsResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            'short_description' => $this->short_description,
            'long_description' => $this->long_description,
            'image' => $this->image ? Storage::url($this->image): null,
            'course_circullums' => CurriculumResource::collection($this->whenLoaded('course_circullums')),
            'course_requirements' => RequirementResource::collection($this->whenLoaded('course_requirements')),
        ];
    }
}
