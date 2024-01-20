<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use TheSeer\Tokenizer\Token;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\PersonalAccessToken;

class LfmAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('Authorization') !== null)
            $token = explode(' ', $request->header('Authorization'))[1];
        else
            $token = $request->token;

        $token = PersonalAccessToken::findToken($token);
        $user = $token->tokenable;

        if ($user)
            return $next($request);

        abort(404);
    }
}
