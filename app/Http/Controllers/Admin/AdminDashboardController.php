<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {

        $totalEmployee = User::where('is_admin', 0)->count();

        return response()->json([
            'totalEmployee' => $totalEmployee,
        ]);
    }
}
