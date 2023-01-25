<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Utils\ValidationUtil;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{

    public function index(Request $request)
    {
        // TODO: Return all dates that have tasks by month
    }

    public function getTasks(Request $request)
    {
        $timestamp = $request->date;

        // Validate date
        $result = ValidationUtil::validateTimestamp($timestamp);
        if ($result != null) {
            return response()->json([
                'message' => $result,
            ], 400);
        }

        // Get all task by dates
        $tasks = $request->user()->tasks()->where('date', Carbon::createFromTimestamp($timestamp)->addDay(1)->toDateString())->get();

        return response()->json([
            'tasks' => $tasks
        ]);
    }

    public function store(Request $request)
    {
        // TODO: Create new task
    }

    public function delete(Request $request)
    {
        // TODO: Delete task
    }
}
