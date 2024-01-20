<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use App\Models\Admin;
use App\Models\LoginHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|string',
            'password' => 'required|min:6',
        ], [
            'admin_id.required' => 'Please enter a valid ID.'
        ]);

        $admin = Admin::where('admin_id', $request->admin_id)->where('situation', 'approval')->first();

        if (!$admin || ($request->admin_id != $admin->admin_id)) {
            throw ValidationException::withMessages([
                'admin_id' => ['admin123456'],
            ]);
        }

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            throw ValidationException::withMessages([
                'password' => ['admin123456#'],
            ]);
        }

        $admin->last_login = now();
        $admin->save();


        $login_history = new LoginHistory();
        $login_history->user_id = $admin->id;
        $login_history->user_type = 'admin';
        $login_history->login_by = 'web';
        $login_history->ip = $request->ip();
        $login_history->save();

        $admin->token = $admin->createToken('web')->plainTextToken;

        $admin->type = 'admin';
        return new AuthResource($admin);
    }

    public function user(Request $request)
    {
        return $request->user();
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();
    }
}
