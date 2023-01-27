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
}
