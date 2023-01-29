<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $employees = User::where('is_admin', 0)->paginate(10);
        return response()->json([
            'employees' => $employees,
        ]);
    }

    public function edit(Request $request)
    {
        $employee = User::find($request->id);

        $normal = 0;

        if ($employee->rate != null) {
            $normal = $employee->rate->normal;
        }

        return response()->json([
            'normal' => $normal,
        ]);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $normal = $request->normal;

        $employee = User::find($id);

        if ($employee->rate == null) {
            $employee->rate()->create([
                'normal' => $normal,
                'holiday' => 0, // not needed for now
            ]);
        } else {
            $employee->rate()->update([
                'normal' => $normal
            ]);
        }

        return response()->json([
            'message' => 'Updated employee successfully'
        ]);
    }
}
