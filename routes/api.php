<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\User\AnnouncementController;
use App\Http\Controllers\User\AttendanceController;
use App\Http\Controllers\User\CalendarController;
use App\Http\Controllers\User\MySweldoController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\Verify\VerifyAccountController;
use Illuminate\Support\Facades\Route;

/* 
    Auth routes
*/
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
Route::post('/reset-password', [ResetPasswordController::class, 'update']);

// Verify
Route::post('/verify/account', [VerifyAccountController::class, 'verify']);

/*
    Authenticated routes
*/
Route::group([
    'prefix' => '/dashboard',
    'middleware' => [
        'auth:api',
    ]
], function () {
    Route::get('/', [UserDashboardController::class, 'index']);

    // Clock in and out
    Route::post('/clock-in', [AttendanceController::class, 'clockIn']);
    Route::post('/clock-out', [AttendanceController::class, 'clockOut']);
    // fetch announcement from database
});

Route::group([
    'prefix' => '/calendar',
    'middleware' => [
        'auth:api',
    ]
], function () {
    Route::get('/task/monthly/{date}', [CalendarController::class, 'getMonthlyTasks']);
    Route::get('/task/daily/{date}', [CalendarController::class, 'getDailyTasks']);
    Route::post('/task', [CalendarController::class, 'store']);
    Route::post('/task/{id}/delete', [CalendarController::class, 'destroy']);
});



/*
    Admin routes
*/
Route::group([
    'prefix' => '/admin',
    'middleware' => [
        'auth:api',
        'admin'
    ]
], function () {

    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index']);

    // Employee
    Route::get('/employee', [EmployeeController::class, 'index']);
    Route::get('/employee/find/{search}', [EmployeeController::class, 'find']);
    Route::get('/employee/{id}', [EmployeeController::class, 'edit']);
    Route::post('/employee/{id}', [EmployeeController::class, 'update']);
});