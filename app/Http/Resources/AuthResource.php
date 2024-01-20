<?php

namespace App\Http\Resources;

use App\Models\CourseOrder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
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

    public function rating($value)
    {
        $valueText = '';
        switch ($value) {
            case 'system':
                $valueText = __('admin.auth.system');
                break;
            case 'top-level':
                $valueText = __('admin.auth.top_level');
                break;
            case 'teacher':
                $valueText = __('admin.auth.teacher');
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

    public function get_package($user_id){
        $latest_order = CourseOrder::with('package')->where(['user_id' => $user_id, 'is_active' => 1])->first();
        if($latest_order){
            return $latest_order->package_id;
        }else{
            return '';
        }
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
            'admin_id' => $this->admin_id,
            'parent_id' => $this->parent_id,
            'student_id' => $this->student_id,
            'type' => $this->type,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'situation' => $this->situation ? $this->situation($this->situation) : '',
            'rating' => $this->rating ? $this->rating($this->rating) : '',
            'created_by' => $this->created_by,
            'token' => $this->token,
            'photo' => $this->photo ? $this->get_photo($this->photo) : asset('/images/avatar.png'),
            'last_login' => $this->last_login ?  date('Y.m.d H:i', strtotime($this->last_login)) : null,
            'login_attempt' => $this->login_attempt,
            'stripe_id' => $this->stripe_id,
            'package_id' => $this->get_package($this->id)
        ];
    }
}
