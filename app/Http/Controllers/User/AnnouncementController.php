<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    //fetch all announcements from the database
    public function index(Request $request)
    {
        $announcements = $request->user()->announcements()->orderBy('created_at', 'desc')->get();

        return response()->json([
            'announcements' => $announcements
        ]);
    }

    
    //add function that will generate fake announcements

 



}
