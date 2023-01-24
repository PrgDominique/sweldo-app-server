<?php

namespace App\Services;

use App\Mail\ForgotPasswordMail;
use App\Models\User;
use App\Models\VerifyToken;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class VerifyTokenService
{
    public static function createToken(User $user, string $type)
    {
        $token = self::generateToken();
        $user->verify_token()->create([
            'type' => $type,
            'token' => $token
        ]);
        if ($type == 'verify_account') {
            $link = 'http://localhost:3000/verify/account?id=' . $user->id . '&token=' . $token;
            // TODO: Send verify account email
            // Mail::to($user->email)->send(new ForgotPasswordMail($link));
        }
        if ($type == 'reset_password') {
            $link = 'http://localhost:3000/reset-password?id=' . $user->id . '&token=' . $token;
            Mail::to($user->email)->send(new ForgotPasswordMail($link));
        }
    }

    private static function generateToken()
    {
        while (true) {
            $newToken = Str::random(30);
            $verifyToken = VerifyToken::where('token', $newToken)->first();
            if ($verifyToken == null) {
                return $newToken;
            }
        }
    }
}
