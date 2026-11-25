<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceVerification;
use App\Models\Schedule;
use Illuminate\Http\Request;

class AssistantController extends Controller
{
    public function dashboard()
    {
        // Fallback check to ensure $userId is retrieved regardless of Auth mechanism
        $userId = auth()->id() ?? session('user_id');
        $currentMonth = now()->month;

        $monthlyHours = Attendance::where('user_id', $userId)
            ->whereMonth('attendance_date', $currentMonth)
            ->sum('total_hours');

        $pendingRequests = AttendanceVerification::where('user_id', $userId)
            ->where('status', 'pending')
            ->count();

        $todayAttendance = Attendance::where('user_id', $userId)
            ->whereDate('attendance_date', now()->toDateString())
            ->first();

        $todayStatus = 'Not Clocked In';
        if ($todayAttendance) {
            if ($todayAttendance->time_in && !$todayAttendance->time_out) {
                $todayStatus = 'On Duty';
            } elseif ($todayAttendance->time_in && $todayAttendance->time_out) {
                $todayStatus = 'Completed';
            }
        }

        $upcomingShifts = class_exists('\App\Models\Schedule') 
            ? Schedule::where('user_id', $userId)->where('schedule_date', '>=', now()->toDateString())->count() 
            : 0;

        return view('assistant.dashboard', compact(
            'monthlyHours',
            'upcomingShifts',
            'pendingRequests',
            'todayStatus'
        ));
    }

    public function report(Request $request)
    {
        $userId = auth()->id() ?? session('user_id');

        $dateFilter = $request->input('attendance_date');
        $monthFilter = $request->input('month');
        $yearFilter = $request->input('year');

        // Build Eloquent Query with dynamic filters
        $query = Attendance::where('user_id', $userId);

        if (!empty($dateFilter)) {
            $query->where('attendance_date', $dateFilter);
        }

        if (!empty($monthFilter) && (int)$monthFilter >= 1 && (int)$monthFilter <= 12) {
            $query->whereMonth('attendance_date', (int)$monthFilter);
        }

        if (!empty($yearFilter) && (int)$yearFilter >= 2000 && (int)$yearFilter <= 2100) {
            $query->whereYear('attendance_date', (int)$yearFilter);
        }

        // Fetch filtered attendance records
        $records = $query->orderBy('attendance_date', 'desc')->get();

        // Calculate report summary totals
        $totalRecords = $records->count();
        $totalHours = $records->sum('total_hours');

        return view('assistant.report', compact(
            'records',
            'totalRecords',
            'totalHours',
            'dateFilter',
            'monthFilter',
            'yearFilter'
        ));
    }
}