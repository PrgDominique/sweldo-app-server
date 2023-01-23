<?php

namespace App\Http\Controllers\Verify;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utils\ValidationUtil;
use DateTime;
use Illuminate\Http\Request;

class VerifyAccountController extends Controller
{
    public function verify(Request $request)
    {
        $id = $request->id;
        $token = $request->token;

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

        // Find user by id
        $user = User::find($id);

        // User not found
        if ($user == null) {
            return response()->json([
                'message' => 'Invalid id',
            ], 400);
        }

        // Get verify token
        $verifyToken = $user->verify_token->where('type', 'verify_account')->first();

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
                'message' => 'Account already verified',
            ], 400);
        }

        // Valid
        if ($user->email_verified_at) {
            return response()->json([
                'message' => 'Account already verified',
            ], 400);
        }

        // Update emaiL_verified_at
        $user->email_verified_at = new DateTime();
        $user->save();

        // Update token
        $verifyToken->update([
            'is_done' => true
        ]);

        return response()->json([
            'message' => 'Account verified successfully'
        ]);
    }
}
