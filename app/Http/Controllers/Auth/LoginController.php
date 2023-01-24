<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utils\ValidationUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        // Validate email
        $result = ValidationUtil::validateEmail($email);
        if ($result != null) {
            return response()->json([
                'message' => $result,
                'type' => 'email'
            ], 400);
        }

        // Validate password
        $result = ValidationUtil::validatePassword($password);
        if ($result != null) {
            return response()->json([
                'message' => $result,
                'type' => 'password'
            ], 400);
        }

        // Set credentials
        $credentials = [
            'email' => $email,
            'password' => $password
        ];

        // Authenticate user
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Credentials does not match our records.',
            ], 400);
        }

        // Get authenticated user
        $user = $request->user();

        // Check if verified email
        if ($user->email_verified_at == null) {
            return response()->json([
                'message' => 'Please verify your email first.',
            ], 400);
        }

        // Create token
        $accessToken = $user->createToken('Personal Access Token')->accessToken;

        // TODO: Return specific user data and access token
        return response()->json([
            'message' => 'Login successfully',
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'access_token' => $accessToken->token,
            ]
        ]);
    }
}
