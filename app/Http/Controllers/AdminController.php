<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalAssistants = User::where('role', 'assistant')->count();
        $totalSchedules = class_exists('\App\Models\Schedule') ? \App\Models\Schedule::count() : 0;
        $pendingVerifications = AttendanceVerification::where('status', 'pending')->count();
        $totalWorkHours = Attendance::sum('total_hours');

        return view('admin.dashboard', compact(
            'totalAssistants', 
            'totalSchedules', 
            'pendingVerifications', 
            'totalWorkHours'
        ));
    }

    // --- User Registration Methods ---

    // Show Register User Form
    public function showRegisterForm()
    {
        return view('admin.users');
    }

    // Handle User Registration Form Submission
    public function storeUser(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'ic_number'  => 'required|string|max:20',
            'email'      => 'required|email|unique:users,email',
            'phone'      => 'nullable|string|max:20',
            'role'       => 'required|in:admin,assistant',
            'start_date' => 'nullable|date',
            'password'   => 'required|min:6',
        ]);

        User::create([
            'name'       => $request->name,
            'ic_number'  => $request->ic_number,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'role'       => $request->role,
            'start_date' => $request->start_date,
            'status'     => 'active',
            'password'   => Hash::make($request->password), // Upgraded from md5 to secure Hash
        ]);

        return back()->with('success', 'User registered successfully!');
    }

    // --- User Management Methods ---

    // View and search registration records
    public function manageUsers(Request $request)
    {
        $search = trim($request->input('search'));

        $users = User::where('role', 'assistant')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('user_id', 'LIKE', "%{$search}%")
                      ->orWhere('ic_number', 'LIKE', "%{$search}%");
                });
            })
            ->orderBy('user_id', 'desc')
            ->get();

        return view('admin.users_manage', compact('users', 'search'));
    }

    // Show Edit Form for Assistant
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users_edit', compact('user'));
    }

    // Update Assistant Details
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'       => 'required|string|max:255',
            'ic_number'  => 'required|string|max:20',
            'email'      => 'required|email|unique:users,email,' . $id . ',user_id', // Ensure 'user_id' matches your DB primary key column name
            'phone'      => 'nullable|string|max:20',
            'start_date' => 'nullable|date',
        ]);

        $user->update([
            'name'       => $request->name,
            'ic_number'  => $request->ic_number,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'start_date' => $request->start_date,
        ]);

        return redirect('/admin/manage-users')->with('success', 'Assistant details updated successfully.');
    }

    // Deactivate assistant user account
    public function deactivateUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'inactive']);

        return back()->with('success', 'User account deactivated successfully.');
    }

    // --- Attendance & Verification Methods ---

    // View overall attendance records
    public function attendanceList()
    {
        $attendances = Attendance::with('user')
            ->orderBy('attendance_date', 'desc')
            ->get();

        return view('admin.attendance_list', compact('attendances'));
    }

    // View pending and processed verification requests
    public function verificationsList()
    {
        $pendingRequests = AttendanceVerification::with(['user', 'attendance'])
            ->where('status', 'pending')
            ->orderBy('requested_at', 'asc')
            ->get();

        $processedRequests = AttendanceVerification::with(['user', 'attendance'])
            ->whereIn('status', ['approved', 'rejected'])
            ->orderBy('reviewed_at', 'desc')
            ->get();

        return view('admin.verifications_list', compact('pendingRequests', 'processedRequests'));
    }

    // Approve a verification request
    public function approveVerification(Request $request, $id)
    {
        $verification = AttendanceVerification::with('attendance')->findOrFail($id);

        if ($verification->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        $attendance = $verification->attendance;
        $requestType = $verification->request_type;
        $requestedTime = $verification->requested_time;

        if ($requestType === 'time_in') {
            $attendance->time_in = $requestedTime;
        } elseif ($requestType === 'time_out') {
            $attendance->time_out = $requestedTime;
        }

        if (!empty($attendance->time_in) && !empty($attendance->time_out)) {
            $timeInStamp = strtotime("{$attendance->attendance_date} {$attendance->time_in}");
            $timeOutStamp = strtotime("{$attendance->attendance_date} {$attendance->time_out}");

            if ($timeOutStamp > $timeInStamp) {
                $attendance->total_hours = round(($timeOutStamp - $timeInStamp) / 3600, 2);
            }
        }

        $attendance->save();

        $verification->update([
            'status'       => 'approved',
            'admin_remark' => $request->input('admin_remark', 'Approved by Admin'),
            'reviewed_at'  => Carbon::now('Asia/Kuala_Lumpur'),
        ]);

        return back()->with('success', 'Verification request approved and attendance record updated.');
    }

    // Reject a verification request
    public function rejectVerification(Request $request, $id)
    {
        $request->validate([
            'admin_remark' => 'required|min:3|max:255',
        ], [
            'admin_remark.required' => 'Please provide a remark explaining the rejection.',
        ]);

        $verification = AttendanceVerification::findOrFail($id);

        if ($verification->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        $verification->update([
            'status'       => 'rejected',
            'admin_remark' => $request->admin_remark,
            'reviewed_at'  => Carbon::now('Asia/Kuala_Lumpur'),
        ]);

        return back()->with('success', 'Verification request rejected successfully.');
    }

    // --- Attendance Report Method ---

    public function report(Request $request)
    {
        $assistants = User::where('role', 'assistant')
            ->orderBy('name', 'asc')
            ->get();

        $query = Attendance::with('user');

        if ($request->filled('user_id') && $request->user_id > 0) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('attendance_date')) {
            $query->whereDate('attendance_date', $request->attendance_date);
        }

        if ($request->filled('month')) {
            $query->whereMonth('attendance_date', $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('attendance_date', $request->year);
        }

        $records = $query->orderBy('attendance_date', 'desc')->get();

        $total_records = $records->count();
        $grand_total_hours = $records->sum('total_hours');

        return view('admin.report', compact('assistants', 'records', 'total_records', 'grand_total_hours'));
    }
}