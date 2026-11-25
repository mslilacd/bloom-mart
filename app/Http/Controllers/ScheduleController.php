<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display schedule for assistant
     */
    public function index()
{
    $userId = session('user_id');

    $schedules = Schedule::with('user')
        ->where('user_id', $userId)
        ->orderBy('schedule_date', 'asc')
        ->orderBy('start_time', 'asc')
        ->get();

    return view('assistant.schedule', compact('schedules'));
}


    /**
     * Store schedule (if needed)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'schedule_date' => 'required|date|after_or_equal:today',
            'shift' => 'required|in:Morning,Afternoon,Evening,Full Day',
            'description' => 'nullable|string|max:255',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);


        Schedule::create($validated);


        return back()->with(
            'success',
            'Schedule created successfully!'
        );
    }


    /**
     * Delete schedule
     */
    public function destroy($id)
    {
        // Schedule uses schedule_id as primary key
        $schedule = Schedule::where('schedule_id', $id)
            ->first();


        if (!$schedule) {
            return back()->with(
                'error',
                'Schedule record not found or already deleted!'
            );
        }


        $schedule->delete();


        return back()->with(
            'success',
            'Schedule deleted successfully!'
        );
    }
}