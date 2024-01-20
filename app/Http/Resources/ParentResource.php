<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class ParentResource extends JsonResource
{
    public function situation($value)
    {
        $valueText = '';
        switch ($value) {
            case 'approval':
                $valueText = __('admin.auth.approval');
                break;
            case 'stop':
                $valueText = __('admin.auth.stop');
                break;
            case 'dormancy':
                $valueText = __('admin.auth.dormancy');
                break;
            case 'secession':
                $valueText = __('admin.auth.secession');
                break;

            default:
                # code...
                break;
        }

        return $valueText;
    }

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'postal_code' => $this->postal_code,
            'address' => $this->address,
            'detailed_address' => $this->detailed_address,
            'situation' => $this->situation,
            'formatted_situation' => $this->situation ? $this->situation($this->situation) : '',
            'memo' => $this->memo,
            'photo' => $this->photo ? Storage::url($this->photo) : '',
            'login_count' => $this->loginHistory->count(),
            'enrolled_student' => $this->students->count(),
            'last_login' => $this->last_login ?  date('Y.m.d H:i', strtotime($this->last_login)) : null,
            'created_at' => $this->created_at ?  date('Y.m.d H:i', strtotime($this->created_at)) : null,
            'registered_at' => $this->registered_at ?  date('Y.m.d H:i', strtotime($this->registered_at)) : null,
            'register_by' => $this->register_by
        ];
    }
}
