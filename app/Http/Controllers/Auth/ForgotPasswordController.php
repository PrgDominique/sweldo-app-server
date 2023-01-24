<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utils\ValidationUtil;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $email = $request->email;

        // Validate email
        $result = ValidationUtil::validateEmail($email);
        if ($result != null) {
            return response()->json([
                'message' => $result,
                'type' => 'email'
            ], 400);
        }

        // Find user by email
        $user = User::where('email', $email)->first();

        // User not found
        if ($user == null) {
            return response()->json([
                'message' => 'User not found',
            ], 400);
        }

        // Check if verified email
        if ($user->email_verified_at == null) {
            return response()->json([
                'message' => 'User is not verified',
            ], 400);
        }

        // TODO: Send email

        return response()->json([
            'message' => 'Check your email for a link to reset your password'
        ]);
    }
}
