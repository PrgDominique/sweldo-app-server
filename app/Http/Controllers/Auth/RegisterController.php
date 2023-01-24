<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utils\ValidationUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $email = $request->email;
        $password = $request->password;

        // Validate first name
        $result = ValidationUtil::validateFirstName($first_name);
        if ($result != null) {
            return response()->json([
                'message' => $result,
                'type' => 'first_name'
            ], 400);
        }

        // Validate last name
        $result = ValidationUtil::validateLastName($last_name);
        if ($result != null) {
            return response()->json([
                'message' => $result,
                'type' => 'last_name'
            ], 400);
        }

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

        
        



        // Check if email already exist

        $result = User::where('email', $email)->first();
        if ($result != null) {
            return response()->json([
                'message' => 'Email already exist',
                'type' => 'email'
            ], 400);
        }

        // Create new user

        User::create([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'password' => Hash::make($password)
        ]);

        return response()->json([
            'message' => 'Registered successfully'
        ]);
    }
}
