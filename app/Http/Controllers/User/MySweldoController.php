<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MySweldoController extends Controller
{
    public function index(Request $request)
    {
        // Hours work
        $week = 0;
        $monthly = 0;

        // Rate
        $rateNormal = 0;
        $rateHoliday = 0;

        // Deduction
        $deductionTardiness = 0;
        $deductionAbsences = 0;

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

        // Rate
        if ($request->user()->rate != null) {
            $rateNormal = $request->user()->rate->normal;
            $rateHoliday = $request->user()->rate->holiday;
        }

        // Deduction
        if ($request->user()->deduction != null) {
            $deductionTardiness = $request->user()->deduction->tardiness;
            $deductionAbsences = $request->user()->deduction->absences;
        }

        return response()->json([
            'week' => $week,
            'monthly' => $monthly,
            'rate' => [
                'normal' => $rateNormal,
                'holiday' => $rateHoliday,
            ],
            'deduction' => [
                'tardiness' => $deductionTardiness,
                'absences' => $deductionAbsences,
            ]
        ]);
    }
}
