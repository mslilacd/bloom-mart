<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssistantController;
use App\Http\Controllers\AttendanceController;

// Admin Schedule Controller
use App\Http\Controllers\Admin\ScheduleController as AdminScheduleController;

// Middleware
use App\Http\Middleware\AssistantAuth;
use App\Http\Middleware\AdminAuth;


// ===============================
// PUBLIC ROUTES
// ===============================

Route::get('/', function () {
    return redirect('/login');
});


// Login
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);


// Logout (FIXED)
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])
    ->name('logout');



// ===============================
// ASSISTANT ROUTES
// ===============================

Route::middleware([AssistantAuth::class])->group(function () {

    // Dashboard
    Route::get('/assistant/dashboard', [AssistantController::class, 'dashboard']);


    // Schedule
    Route::get('/assistant/schedule', [ScheduleController::class, 'index']);


    // Attendance
    Route::get('/assistant/attendance', [AttendanceController::class, 'index']);

    Route::post('/assistant/attendance/time-in', 
        [AttendanceController::class, 'timeIn']);

    Route::post('/assistant/attendance/time-out', 
        [AttendanceController::class, 'timeOut']);

    Route::post('/assistant/attendance/verification', 
        [AttendanceController::class, 'submitVerification']);


    // Report
    Route::get('/assistant/report', 
        [AssistantController::class, 'report']);

});




// ===============================
// ADMIN ROUTES
// ===============================

Route::middleware([AdminAuth::class])->group(function () {


    // Dashboard
    Route::get('/admin/dashboard', 
        [AdminController::class, 'dashboard']);



    // ===========================
    // Schedule Management
    // ===========================

    Route::get('/admin/schedules', 
        [AdminScheduleController::class, 'index']);

    Route::post('/admin/schedules', 
        [AdminScheduleController::class, 'store']);

    Route::get('/admin/schedules/{id}/edit', 
        [AdminScheduleController::class, 'edit']);

    Route::put('/admin/schedules/{id}', 
        [AdminScheduleController::class, 'update']);

    Route::delete('/admin/schedules/{id}', 
        [AdminScheduleController::class, 'destroy']);



    // ===========================
    // User Registration
    // ===========================

    Route::get('/admin/users/create', 
        [AdminController::class, 'showRegisterForm']);

    Route::post('/admin/users/store', 
        [AdminController::class, 'storeUser']);



    // ===========================
    // User Management
    // ===========================

    Route::get('/admin/manage-users', 
        [AdminController::class, 'manageUsers']);

    Route::get('/admin/users/manage', 
        [AdminController::class, 'manageUsers']);

    Route::post('/admin/users/{id}/deactivate', 
        [AdminController::class, 'deactivateUser']);



    // ===========================
    // User Edit
    // ===========================

    Route::get('/admin/users/{id}/edit', 
        [AdminController::class, 'edit']);

    Route::put('/admin/users/{id}', 
        [AdminController::class, 'update']);



    // ===========================
    // Attendance Verification
    // ===========================

    Route::get('/admin/attendance', 
        [AdminController::class, 'attendanceList']);

    Route::get('/admin/verifications', 
        [AdminController::class, 'verificationsList']);

    Route::post('/admin/verifications/{id}/approve', 
        [AdminController::class, 'approveVerification']);

    Route::post('/admin/verifications/{id}/reject', 
        [AdminController::class, 'rejectVerification']);



    // ===========================
    // Admin Report
    // ===========================

    Route::get('/admin/report', 
        [AdminController::class, 'report']);

});