<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utils\ValidationUtil;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //get user 
    public function getProfile(Request $request)
    {
        $id = $request->id;

        // Validate id
        $result = ValidationUtil::validateId($id);
        if ($result != null) {
            return response()->json([
                'message' => $result,
                'type' => 'id'
            ], 400);
        }

        $user = User::find($id);

        if ($user == null) {
            return response()->json([
                'message' => 'User not found',
                'type' => 'id'
            ], 400);
        }

        return response()->json([
            'user' => $user
        ]);
    }


    //update user




}
