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
       
        $user = $request->user();

        

        return response()->json([
            'user' => $user
        ]);
    }


    //update user




}
