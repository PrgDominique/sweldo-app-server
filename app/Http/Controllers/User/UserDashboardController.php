<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    

    public function index(Request $request)
    {
        // Clock in status
        $isClockIn = false;

        $attendance = $request->user()->attendances()->where('created_at', '>=', now()->startOfDay())->first();

        if ($attendance !== null && $attendance->clock_out === null) {
            $isClockIn = true;
        }
      
        // Announcements
        $announcements = Announcement::latest()->get();

        //Expected Salary
        
   

        return response()->json([
            'message' => 'Sample response',
            'isClockIn' => $isClockIn,
            'announcements' => $announcements
        ]);

     
    }
}
