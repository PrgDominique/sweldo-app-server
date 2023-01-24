<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    

    public function index(Request $request)
    {
        $isClockIn = false;

        $attendance = $request->user()->attendances()->where('created_at', '>=', now()->startOfDay())->first();

        if ($attendance !== null && $attendance->clock_out === null) {
            $isClockIn = true;
        }
      
        

        return response()->json([
            'message' => 'Sample response',
            'isClockIn' => $isClockIn,
        ]);
    }
}
