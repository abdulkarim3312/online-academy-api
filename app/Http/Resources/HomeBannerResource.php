<?php

namespace App\Http\Resources;

use App\Http\Resources\ParentResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeBannerResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'background_color' => $this->background_color,
            'top_title' => $this->top_title,
            'sub_title' => $this->sub_title,
            'banner_image' => $this->banner_image ? Storage::url($this->banner_image): null,
        ];
    }
}
