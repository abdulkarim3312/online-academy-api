<?php

namespace App\Http\Resources;

use App\Http\Resources\ParentResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutUsResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id ?? '',
            'title' => $this->title ?? '',
            'sub_title' => $this->sub_title ?? '',
            'description' => $this->description ?? '',
            'image' => $this->image ? Storage::url($this->image): null,
        ];
    }
}
