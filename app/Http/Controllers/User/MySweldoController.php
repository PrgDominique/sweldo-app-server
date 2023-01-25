<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MySweldoController extends Controller
{
    public function index(Request $request)
    {
        // Hours work
        $week = 0;
        $monthly = 0;

        // Weekly attendance
        $weeklyAttendances = $request->user()->attendances()->whereBetween(
            'created_at',
            [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]
        )->get();
        foreach ($weeklyAttendances as $attendance) {
            $week += Carbon::parse($attendance->clock_in)->diffInHours(Carbon::parse($attendance->clock_out));
        }

        // Monthly attendance
        $monthlyAttendances = $request->user()->attendances()->whereBetween(
            'created_at',
            [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]
        )->get();
        foreach ($monthlyAttendances as $attendance) {
            $monthly += Carbon::parse($attendance->clock_in)->diffInHours(Carbon::parse($attendance->clock_out));
        }

        // TODO: Return rate and deductions

        return response()->json([
            'week' => $week,
            'monthly' => $monthly,
        ]);
    }
}
