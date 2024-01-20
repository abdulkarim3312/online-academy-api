<?php

namespace App\Http\Controllers\Front;

use App\Models\Student;
use App\Models\ParentModel;
use App\Rules\PasswordComplex;
use Illuminate\Support\Str;
use App\Models\LoginHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\ParentResource;
use App\Jobs\SendForgotPasswordEmailJob;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password as FacadesPassword;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', new PasswordComplex],
            'password_confirmation' => 'required', // Add this field for password confirmation
            'phone' => 'required',
        ]);


        $user = User::where('email', $request->email)->first();
        if ($user) {
            throw ValidationException::withMessages([
                'email' => 'Email already exists.',
            ]);
        }

        $parent_count = User::withTrashed()->count();
        $parent_id = str_pad($parent_count + 1, 6, '0', STR_PAD_LEFT);

        $user = User::create([
            'parent_id' => $parent_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'situation' => 'approval',
            'registered_at' => now(),
            'register_by' => 'web',
        ]);

        return response()->json(['success' => true]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'type' => 'required|in:parent,student',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        switch ($request->type) {
            case 'parent':
                $user = User::where('email', $request->email)->where('situation', 'approval')->first();
                break;
            default:
                $user = Student::where('email', $request->email)->where('situation', 'approval')->first();
                break;
        }

        if ($request->type == 'parent') {
            if (!$user || ($request->email != $user->email)) {
                throw ValidationException::withMessages([
                    'email' => ['Please enter valid email.'],
                ]);
            }
        }
        if ($request->type == 'student') {
            if (!$user || ($request->user_id != $user->student_id)) {
                throw ValidationException::withMessages([
                    'email' => ['Please enter valid email.'],
                ]);
            }
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['Please enter valid password.'],
            ]);
        }

        $user->last_login = now();
        $user->save();

        $login_history = new LoginHistory();
        $login_history->user_id = $user->id;
        $login_history->user_type = $request->type;
        $login_history->login_by = 'web';
        $login_history->ip = $request->ip();
        $login_history->save();

        $user->token = $user->createToken('front')->plainTextToken;
        $user->type = $request->type;

        $this->logoutOtherDevice($user);

        return new AuthResource($user);
    }

    public function user(Request $request)
    {
        $user = null;
        if (isset($request->user()->student_id)) {
            $user = Student::where('student_id', $request->user()->student_id)->where('situation', 'approval')->first();
            $user->type = 'student';
        }
        if (isset($request->user()->email)) {
            $user = User::where('email', $request->user()->email)->where('situation', 'approval')->first();
            $user->type = 'parent';
        }
        return new AuthResource($user);
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'phone' => 'required:parents,phone'
        ], [
            'phone.required' => '휴대폰 번호를 입력해 주세요.',
        ]);

        $parent = ParentModel::where('phone', $request->phone)->whereNotNull('registered_at')->first();

        if (!$parent) {
            throw ValidationException::withMessages([
                'phone' => '일치하는 휴대폰번호가 없습니다. 다시 확인해주세요.',
            ]);
        }

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $otp_delivery_response = send_otp($request->phone, $otp);
        if (!$otp_delivery_response) {
            throw ValidationException::withMessages([
                'phone' => 'OTP 전송에 실패했습니다.',
            ]);
        }

        $parent->otp = $otp;
        $parent->save();

        return response()->json(['success' => true, 'otp_status' => true, 'message' => '인증번호를 발송 하였습니다.']);


        /*$token = Str::random(64);

            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            Mail::to($request->email)
                ->queue(new ForgotPasswordMail($token));

            return response()->json(['success' => true, 'message' => '비밀번호 재설정 링크를 발송하였습니다.']);*/


        // $details = [
        //     'email' => $request->email,
        //     'token' => $token,
        // ];

        // dispatch(new SendForgotPasswordEmailJob($details));

        // Mail::send('email.forgot_password', ['token' => $token], function ($message) use ($request) {
        //     $message->to($request->email);
        //     $message->subject('Reset Password');
        // });

        // return FacadesPassword::sendResetLink(
        //     $request->only('email')
        // );
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'email' => 'nullable|email',
            'password' => 'nullable|string|min:6',
            'token' => ['required_if:otp,false'],
        ], [
            'email.email' => '유효한 이메일 주소를 입력해주세요.',
            'password:min' => '비밀번호는 최소 6자리 이고, 일치해야 합니다.'
        ]);

        if ($request->phone) {
            $parent = ParentModel::where('phone', $request->phone)->whereNotNull('registered_at')->first();
            if ($parent) {
                $parent->update([
                    'password' => $request->password ? bcrypt($request->password) : $parent->password,
                    'email' => $request->email ? $request->email : $parent->email,
                    'otp' => null
                ]);
            }

            return response()->json(['success' => true, 'message' => '비밀번호 재설정이 완료되었습니다.']);
        }

        return response()->json(['success' => false, 'message' => '비밀번호 재설정에 실패했습니다! 다시 한 번 시도해 보세요.']);

        /*} else{
            $updatePassword = DB::table('password_resets')
                ->where([
                    'email' => $request->email,
                    'token' => $request->token
                ])
                ->first();

            if (!$updatePassword) {
                throw ValidationException::withMessages([
                    'email' => '이메일 또는 비밀번호가 일치하지 않습니다.',
                ]);
            }

            ParentModel::where('email', $request->email)->update([
                'password' => Hash::make($request->password)
            ]);

            DB::table('password_resets')->where(['email' => $request->email])->delete();
        }*/
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ], [
            'otp.required' => '인증번호를 입력해 주세요.'
        ]);

        $parent = ParentModel::where('phone', $request->phone)->whereNotNull('registered_at')->first();

        if ($parent->otp != $request->otp) {
            throw ValidationException::withMessages([
                'otp' => '인증번호가 일치하지 않습니다.',
            ]);
        }

        return response()->json(['success' => true, 'message' => '인증이 완료되었습니다.']);
    }

    public function parentFindIdVerifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ], [
            'otp.required' => '인증번호를 입력해 주세요.'
        ]);

        $parent = ParentModel::where('phone', $request->phone)->whereNotNull('registered_at')->first();

        if ($parent->otp != $request->otp) {
            throw ValidationException::withMessages([
                'otp' => '인증번호가 일치하지 않습니다.',
            ]);
        }

        $registerBy = match ($parent->register_by) {
            'google' => '구글로 가입된 계정 입니다. 구글 로그인 후 소셜로그인을 진행해 주세요.',
            'kakao'  => '카카오로 가입된 계정 입니다. 카카오 로그인 후 소셜로그인을 진행해 주세요.',
            default   => null,
        };

        $id = $parent->parent_id ?: $parent->email;

        return response()->json(['success' => true, 'id' => $id, 'message' => '인증이 완료되었습니다.', 'registerBy' => $registerBy]);
    }

    public function sendAuthUserOtp(Request $request)
    {

        $request->validate([
            'phone' => 'required',
        ], [
            'phone.required' => '휴대폰번호를 입력해주세요',
        ]);

        $authUser = $request->user();

        if ($request->phone == $authUser->phone) {

            $parent = ParentModel::where('phone', $request->phone)->whereNotNull('registered_at')->first();
            if ($parent) {
                $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                $otp_delivery_response = send_otp($request->phone, $otp);
                if (!$otp_delivery_response) {
                    throw ValidationException::withMessages([
                        'phone' => 'OTP 전송에 실패했습니다.',
                    ]);
                }

                $parent->otp = $otp;
                $parent->save();

                return response()->json(['success' => true, 'otp_status' => true, 'message' => '인증번호가 발송 되었습니다. ']);
            }
        }

        throw ValidationException::withMessages([
            'phone' => '유효한 전화번호를 입력해주세요.',
        ]);
    }

    protected function logoutOtherDevice($user)
    {
        $currentToken = PersonalAccessToken::findToken($user->token);

        PersonalAccessToken::where('tokenable_id', $user->id)->where('id', '<>', $currentToken->id)->delete();
    }
}
