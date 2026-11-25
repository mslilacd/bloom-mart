<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    // Display schedule management page & active assistants
    public function index()
    {
        // Fetch active Store Assistants
        $assistants = User::where('role', 'assistant')
            ->where('status', 'active')
            ->orderBy('name', 'asc')
            ->get();

        // Fetch all schedules with assigned assistant information
        $schedules = Schedule::with('user')
            ->orderBy('schedule_date', 'desc')
            ->orderBy('start_time', 'asc')
            ->get();

        return view('admin.schedules_manage', compact('schedules', 'assistants'));
    }


    // Store new schedule
    public function store(Request $request)
    {
        $request->validate([
            'user_id'       => 'required|exists:users,user_id',
            'schedule_date' => 'required|date|after_or_equal:today',
            'shift'         => 'required|in:Morning,Afternoon,Evening,Full Day',
            'description'   => 'nullable|string|max:255',
            'start_time'    => 'required',
            'end_time'      => 'required|after:start_time',
        ], [
            'end_time.after' => 'End time must be later than start time.',
            'schedule_date.after_or_equal' => 'Schedule date cannot be in the past.',
        ]);


        // Check assistant exists and active
        $assistant = User::where('user_id', $request->user_id)
            ->where('role', 'assistant')
            ->where('status', 'active')
            ->first();


        if (!$assistant) {
            return back()
                ->withInput()
                ->with('error', 'The selected Store Assistant is invalid or inactive.');
        }


        // Check schedule overlap
        $overlap = Schedule::where('user_id', $request->user_id)
            ->where('schedule_date', $request->schedule_date)
            ->where('start_time', '<', $request->end_time)
            ->where('end_time', '>', $request->start_time)
            ->exists();


        if ($overlap) {
            return back()
                ->withInput()
                ->with('error', 'Schedule overlaps with an existing shift for this Store Assistant.');
        }


        // Create schedule
        Schedule::create([
            'user_id'       => $request->user_id,
            'schedule_date' => $request->schedule_date,
            'shift'         => $request->shift,
            'description'   => $request->description,
            'start_time'    => $request->start_time,
            'end_time'      => $request->end_time,
        ]);


        return back()->with('success', 'Schedule created successfully.');
    }



    // Show edit form
    public function edit($id)
    {
        $schedule = Schedule::where('schedule_id', $id)
            ->firstOrFail();


        $assistants = User::where('role', 'assistant')
            ->where('status', 'active')
            ->orderBy('name', 'asc')
            ->get();


        return view('admin.schedules_edit', compact('schedule', 'assistants'));
    }



    // Update schedule
    public function update(Request $request, $id)
    {
        $schedule = Schedule::where('schedule_id', $id)
            ->firstOrFail();


        $request->validate([
            'user_id'       => 'required|exists:users,user_id',
            'schedule_date' => 'required|date',
            'shift'         => 'required|in:Morning,Afternoon,Evening,Full Day',
            'description'   => 'nullable|string|max:255',
            'start_time'    => 'required',
            'end_time'      => 'required|after:start_time',
        ], [
            'end_time.after' => 'End time must be later than start time.',
        ]);



        // Check assistant exists and active
        $assistant = User::where('user_id', $request->user_id)
            ->where('role', 'assistant')
            ->where('status', 'active')
            ->first();



        if (!$assistant) {
            return back()
                ->withInput()
                ->with('error', 'The selected Store Assistant is invalid or inactive.');
        }



        // Check overlap excluding current schedule
        $overlap = Schedule::where('user_id', $request->user_id)
            ->where('schedule_date', $request->schedule_date)
            ->where('schedule_id', '!=', $id)
            ->where('start_time', '<', $request->end_time)
            ->where('end_time', '>', $request->start_time)
            ->exists();



        if ($overlap) {
            return back()
                ->withInput()
                ->with('error', 'Schedule overlaps with an existing shift for this Store Assistant.');
        }



        // Update schedule
        $schedule->update([
            'user_id'       => $request->user_id,
            'schedule_date' => $request->schedule_date,
            'shift'         => $request->shift,
            'description'   => $request->description,
            'start_time'    => $request->start_time,
            'end_time'      => $request->end_time,
        ]);


        return redirect('/admin/schedules')
            ->with('success', 'Schedule updated successfully.');
    }



    // Delete schedule
    public function destroy($id)
    {
        $schedule = Schedule::where('schedule_id', $id)
            ->firstOrFail();


        $schedule->delete();


        return back()->with('success', 'Schedule deleted successfully.');
    }
}