<?php

namespace App\Http\Resources;

use App\Http\Resources\ParentResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class LogoResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id ?? '',
            'admin_logo' => $this->admin_logo ? Storage::url($this->admin_logo): null,
            'site_logo' => $this->site_logo ? Storage::url($this->site_logo): null,
        ];
    }
}
