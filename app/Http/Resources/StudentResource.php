<?php

namespace App\Http\Resources;

use App\Http\Resources\ParentResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'student_id' => $this->student_id,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'situation' => $this->situation,
            'formatted_situation' => $this->situation ? $this->situation($this->situation) : '',
            'memo' => $this->memo,
            'user_id' => $this->user_id,
            'photo' => $this->photo ? $this->get_photo($this->photo) : asset('/images/avatar.png'),
            'parents' => $this->parents ? new ParentResource($this->parents) : null,
            'login_count' => $this->loginHistory->count(),
            'last_login' => $this->last_login ?  date('Y.m.d H:i', strtotime($this->last_login)) : null,
            'created_at' => $this->created_at ?  date('Y.m.d H:i', strtotime($this->created_at)) : null,
            'registered_at' => $this->registered_at ?  date('Y.m.d H:i', strtotime($this->registered_at)) : null,
        ];
    }
}
