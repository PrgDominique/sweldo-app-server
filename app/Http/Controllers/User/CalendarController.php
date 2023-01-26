<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Task;
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
            'task_date',
            [Carbon::createFromTimestamp($timestamp)->addDay(1)->startOfMonth(), Carbon::createFromTimestamp($timestamp)->addDay(1)->endOfMonth()]
        )->get();

        $taskList = [];
        foreach ($tasks as $task) {
            $day = (int) Carbon::parse($task->task_date)->rawFormat('d');
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
        $tasks = $request->user()->tasks()->whereDate('task_date', Carbon::createFromTimestamp($timestamp)->addDay(1)->toDateString())->get();

        return response()->json([
            'tasks' => $tasks
        ]);
    }

    public function store(Request $request)
    {
        $name = $request->name;
        $description = $request->description;
        $timestamp = $request->date;

        // Validate name
        $result = ValidationUtil::validateTaskName($name);
        if ($result != null) {
            return response()->json([
                'message' => $result,
                'type' => 'name'
            ], 400);
        }

        // Validate description
        $result = ValidationUtil::validateTaskDescription($description);
        if ($result != null) {
            return response()->json([
                'message' => $result,
                'type' => 'description'
            ], 400);
        }

        // Validate date
        $result = ValidationUtil::validateTimestamp($timestamp);
        if ($result != null) {
            return response()->json([
                'message' => $result,
            ], 400);
        }

        // Create new task
        $request->user()->tasks()->create([
            'name' => $name,
            'description' => $description,
            'task_date' => Carbon::createFromTimestamp($timestamp)->addDay(1)
        ]);

        return response()->json([
            'message' => 'Task created successfully',
        ]);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;

        // Validate id
        $result = ValidationUtil::validateId($id);
        if ($result != null) {
            return response()->json([
                'message' => $result,
            ], 400);
        }

        // TODO: Delete task
        $task = $request->user()->tasks()->find($id);

        if ($task == null) {
            return response()->json([
                'message' => 'Task not found',
            ], 400);
        }

        // Delete
        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully',
        ]);
    }
}
