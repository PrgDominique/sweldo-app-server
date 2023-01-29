<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Carbon\Carbon;
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



        //Sahod

        // Hours work
        $weekly = 0;
        $monthly = 0;

        // Rate
        $rateNormal = 0;
        $rateHoliday = 0;


         // Weekly attendance
         $weeklyAttendances = $request->user()->attendances()->whereBetween(
            'created_at',
            [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]
        )->get();
        foreach ($weeklyAttendances as $attendance) {
            $weekly += Carbon::parse($attendance->clock_in)->diffInHours(Carbon::parse($attendance->clock_out));
        }

        // Monthly attendance
        $monthlyAttendances = $request->user()->attendances()->whereBetween(
            'created_at',
            [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]
        )->get();
        foreach ($monthlyAttendances as $attendance) {
            $monthly += Carbon::parse($attendance->clock_in)->diffInHours(Carbon::parse($attendance->clock_out));
        }

        // Rate
        if ($request->user()->rate != null) {
            $rateNormal = $request->user()->rate->normal;
            $rateHoliday = $request->user()->rate->holiday;
        }


        return response()->json([
            'message' => 'Sample response',
            'isClockIn' => $isClockIn,
            'announcements' => $announcements,
            'weekly' => $weekly,
            'monthly' => $monthly,
            'rate' => [
                'normal' => $rateNormal,
                'holiday' => $rateHoliday,
            ]
        ]);
    }
}
