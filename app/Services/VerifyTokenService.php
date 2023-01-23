<?php

namespace App\Services;

use App\Models\User;
use App\Models\VerifyToken;
use Illuminate\Support\Str;

class VerifyTokenService
{
    public static function createToken(User $user, string $type)
    {
        $token = self::generateToken();
        $verifyToken = $user->verify_token->create([
            'type' => $type,
            'token' => $token
        ]);
        if ($type == 'verify_account') {
            $link = 'https://project-3-lms.vercel.app/verify/account?id=' . $user->id . '&?token=' . $verifyToken;
            // TODO: Send email
        }
        if ($type == 'reset_password') {
            $link = 'https://project-3-lms.vercel.app/reset-password?id=' . $user->id . '&?token=' . $verifyToken;
            // TODO: Send email
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
