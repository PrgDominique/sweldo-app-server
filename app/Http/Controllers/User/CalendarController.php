<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Utils\ValidationUtil;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{

    public function getMonthlyTasks(Request $request)
    {

        $timestamp = $request->date;

        // Validate date
        $result = ValidationUtil::validateTimestamp($timestamp);
        if ($result != null) {
            return response()->json([
                'message' => $result,
            ], 400);
        }

        $tasks = $request->user()->tasks()->whereBetween(
            'created_at',
            [Carbon::createFromTimestamp($timestamp)->addDay(1)->startOfMonth(), Carbon::createFromTimestamp($timestamp)->addDay(1)->endOfMonth()]
        )->get();

        $taskList = [];
        foreach ($tasks as $task) {
            $day = Carbon::parse($task->created_at)->rawFormat('d');
            if (isset($taskList[$day])) {
                $taskList[$day]++;
            } else {
                $taskList[$day] = 1;
            }
        }

        return response()->json([
            'tasks' => $taskList
        ]);
    }

    public function getDailyTasks(Request $request)
    {
        $timestamp = $request->date;

        // Validate date
        $result = ValidationUtil::validateTimestamp($timestamp);
        if ($result != null) {
            return response()->json([
                'message' => $result,
            ], 400);
        }

        // Get all task by date
        $tasks = $request->user()->tasks()->whereDate('created_at', Carbon::createFromTimestamp($timestamp)->addDay(1)->toDateString())->get();
        
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
