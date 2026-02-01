<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function showSchedule()
    {
        $user = auth()->user();
        
        // If user is a proctor, only show their schedules
        $query = Schedule::orderBy('date', 'desc')->orderBy('start_time', 'asc');
        
        if ($user->role === 'proctor') {
            $query->where('proctor_id', $user->id);
        }
        
        $schedules = $query->paginate(10);
        
        // Get applicants for each schedule
        $schedules->getCollection()->transform(function ($schedule) {
            $applicants = $schedule->process === 'exam'
                ? Admission::where('exam_schedule_id', $schedule->id)->with('applicant')->get()->pluck('applicant')->filter()
                : Admission::where('interview_schedule_id', $schedule->id)->with('applicant')->get()->pluck('applicant')->filter();
            
            $schedule->applicants = $applicants;
            return $schedule;
        });

        // Get users with proctor role
        $proctors = User::where('role', 'proctor')->orderBy('name')->get();

        return view('admission.schedule', [
            'schedules' => $schedules,
            'proctors' => $proctors
        ]);
    }

    public function createSchedule(Request $request)
    {
        $request->validate([
            'proctor_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'status' => 'required|in:active,inactive',
            'process' => 'required|in:exam,interview,evaluation',
        ]);

        Schedule::create([
            'proctor_id' => $request->proctor_id,
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
            'proctor_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'status' => 'required|in:active,inactive',
            'process' => 'required|in:exam,interview,evaluation',
        ]);

        $schedule->update([
            'proctor_id' => $request->proctor_id,
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

    public function getSchedulesByProcess(Request $request)
    {
        $process = $request->query('process');
        
        if (!$process || !in_array($process, ['exam', 'interview', 'evaluation'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid process type',
                'data' => []
            ], 400);
        }

        $schedules = Schedule::where('process', $process)
            ->where('status', 'active')
            ->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get()
            ->map(function ($schedule) {
                return [
                    'id' => $schedule->id,
                    'label' => date('M d, Y', strtotime($schedule->date)) . ' | ' . 
                               date('g:i A', strtotime($schedule->start_time)) . ' - ' . 
                               date('g:i A', strtotime($schedule->end_time)),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $schedules
        ]);
    }
}
