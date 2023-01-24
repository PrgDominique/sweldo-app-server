<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utils\ValidationUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function update(Request $request)
    {
        $id = $request->id;
        $token = $request->token;
        $password = $request->password;

        // Validate id
        $result = ValidationUtil::validateId($id);
        if ($result != null) {
            return response()->json([
                'message' => $result,
            ], 400);
        }

        // Validate token
        $result = ValidationUtil::validateToken($token);
        if ($result != null) {
            return response()->json([
                'message' => $result,
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

        // Find user by id
        $user = User::find($id);

        // User not found
        if ($user == null) {
            return response()->json([
                'message' => 'Invalid id',
            ], 400);
        }

        // Get verify token
        $verifyToken = $user->verify_token->where('type', 'reset_password')->last();

        // Token not found
        if ($verifyToken == null) {
            return response()->json([
                'message' => 'Invalid token',
            ], 400);
        }

        // Check token
        if ($token != $verifyToken->token) {
            return response()->json([
                'message' => 'Invalid token',
            ], 400);
        }

        // Is done
        if ($verifyToken->is_done) {
            return response()->json([
                'message' => 'Invalid token',
            ], 400);
        }

        // Update password
        $user->update([
            'password' => Hash::make($password)
        ]);

        // Update token
        $verifyToken->update([
            'is_done' => true
        ]);

        return response()->json([
            'message' => 'Password changed successfully'
        ]);
    }
}
