<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function showSchedule()
    {
        $schedules = Schedule::orderBy('date', 'desc')->orderBy('start_time', 'asc')->paginate(10);
        return view('admission.schedule', [
            'schedules' => $schedules
        ]);
    }

    public function createSchedule(Request $request)
    {
        $request->validate([
            'proctor' => 'required|string|max:255',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'status' => 'required|in:active,inactive',
            'process' => 'required|in:exam,interview',
        ]);

        Schedule::create([
            'proctor' => $request->proctor,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => $request->status,
            'process' => $request->process,
        ]);

        return redirect()->route('admission.schedule')->with('success', 'Schedule created successfully');
    }

    public function updateSchedule(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);

        $request->validate([
            'proctor' => 'required|string|max:255',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'status' => 'required|in:active,inactive',
            'process' => 'required|in:exam,interview',
        ]);

        $schedule->update([
            'proctor' => $request->proctor,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => $request->status,
            'process' => $request->process,
        ]);

        return redirect()->route('admission.schedule')->with('success', 'Schedule updated successfully');
    }

    public function deleteSchedule($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('admission.schedule')->with('success', 'Schedule deleted successfully');
    }
}
