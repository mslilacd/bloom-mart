<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceVerification;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        $userId = session('user_id');
        $today = Carbon::today()->toDateString();

        // Retrieve today's attendance record
        $todayAttendance = Attendance::where('user_id', $userId)
            ->where('attendance_date', $today)
            ->first();

        // Retrieve verification history with joined attendance dates
        $verificationHistory = AttendanceVerification::with('attendance')
            ->where('user_id', $userId)
            ->orderBy('requested_at', 'desc')
            ->get();

        return view('assistant.attendance', compact('todayAttendance', 'verificationHistory', 'today'));
    }

    public function timeIn(Request $request)
    {
        $userId = session('user_id');
        $today = Carbon::today()->toDateString();
        $currentTime = Carbon::now('Asia/Kuala_Lumpur')->toTimeString();

        $todayAttendance = Attendance::where('user_id', $userId)
            ->where('attendance_date', $today)
            ->first();

        if ($todayAttendance && !empty($todayAttendance->time_in)) {
            return back()->with('error', 'Time In has already been recorded for today.');
        }

        if ($todayAttendance) {
            $todayAttendance->update(['time_in' => $currentTime]);
        } else {
            Attendance::create([
                'user_id' => $userId,
                'attendance_date' => $today,
                'time_in' => $currentTime,
                'total_hours' => 0.00,
            ]);
        }

        return redirect('/assistant/attendance')->with('success', 'Time In recorded successfully.');
    }

    public function timeOut(Request $request)
    {
        $userId = session('user_id');
        $today = Carbon::today()->toDateString();
        $currentTime = Carbon::now('Asia/Kuala_Lumpur')->toTimeString();

        $todayAttendance = Attendance::where('user_id', $userId)
            ->where('attendance_date', $today)
            ->first();

        if (!$todayAttendance || empty($todayAttendance->time_in)) {
            return back()->with('error', 'Please record Time In before Time Out.');
        }

        if (!empty($todayAttendance->time_out)) {
            return back()->with('error', 'Time Out has already been recorded for today.');
        }

        $timeInTimestamp = strtotime("{$todayAttendance->attendance_date} {$todayAttendance->time_in}");
        $timeOutTimestamp = strtotime("{$todayAttendance->attendance_date} {$currentTime}");

        if ($timeOutTimestamp <= $timeInTimestamp) {
            return back()->with('error', 'Time Out must be later than Time In.');
        }

        $totalHours = round(($timeOutTimestamp - $timeInTimestamp) / 3600, 2);

        $todayAttendance->update([
            'time_out' => $currentTime,
            'total_hours' => $totalHours,
        ]);

        return redirect('/assistant/attendance')->with('success', 'Time Out recorded successfully.');
    }

    public function submitVerification(Request $request)
    {
        $userId = session('user_id');
        $today = Carbon::today()->toDateString();

        $request->validate([
            'attendance_date' => 'required|date|before_or_equal:' . $today,
            'request_type'    => 'required|in:time_in,time_out',
            'requested_time'  => 'required',
            'reason'          => 'required|min:5|max:255',
        ], [
            'attendance_date.before_or_equal' => 'Verification cannot be requested for a future date.',
            'reason.min'                      => 'Please provide a clear reason of at least 5 characters.',
        ]);

        $attendanceDate = $request->attendance_date;
        $requestType = $request->request_type;
        $requestedTime = $request->requested_time;
        $reason = $request->reason;

        // Find or create attendance record
        $attendance = Attendance::where('user_id', $userId)
            ->where('attendance_date', $attendanceDate)
            ->first();

        if (!$attendance) {
            $attendance = Attendance::create([
                'user_id'         => $userId,
                'attendance_date' => $attendanceDate,
                'time_in'         => null,
                'time_out'        => null,
                'total_hours'     => 0.00,
            ]);
        }

        // Get primary key value dynamically
        $attendanceId = $attendance->attendance_id ?? $attendance->id;

        // Prevent duplicate logs
        if ($requestType === 'time_in' && !empty($attendance->time_in)) {
            return back()->withInput()->with('error', 'Time In already exists for the selected date.');
        }

        if ($requestType === 'time_out' && !empty($attendance->time_out)) {
            return back()->withInput()->with('error', 'Time Out already exists for the selected date.');
        }

        // Prevent duplicate pending requests
        $duplicate = AttendanceVerification::where('attendance_id', $attendanceId)
            ->where('user_id', $userId)
            ->where('request_type', $requestType)
            ->where('status', 'pending')
            ->exists();

        if ($duplicate) {
            return back()->withInput()->with('error', 'A pending verification request already exists for this date and type.');
        }

        // Time sanity check
        if ($requestType === 'time_out' && !empty($attendance->time_in) && $requestedTime <= $attendance->time_in) {
            return back()->withInput()->with('error', 'Requested Time Out must be later than the recorded Time In.');
        }

        if ($requestType === 'time_in' && !empty($attendance->time_out) && $requestedTime >= $attendance->time_out) {
            return back()->withInput()->with('error', 'Requested Time In must be earlier than the recorded Time Out.');
        }

        // Create verification request
        AttendanceVerification::create([
            'attendance_id'  => $attendanceId,
            'user_id'        => $userId,
            'request_type'   => $requestType,
            'requested_time' => $requestedTime,
            'reason'         => $reason,
            'status'         => 'pending',
            'requested_at'   => Carbon::now('Asia/Kuala_Lumpur'),
        ]);

        return redirect('/assistant/attendance')->with('success', 'Verification request submitted successfully.');
    }
}