<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Admission;

class AdmissionProcessController extends Controller
{
    public function showInterview()
    {
        $schedules = Schedule::orderBy('created_at', 'desc')->where('status', 'active')->where('process', 'exam')->get();
        $applicants = Admission::with(['applicant', 'interviewSchedule'])
            ->where('interview_result', 'pending')
            ->paginate(20);

        return view('admission.interview', [
            'schedules' => $schedules,
            'applicants' => $applicants,
        ]);
    }

    public function updateInterview(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'interview_score' => 'required|string|max:255',
                'interview_remark' => 'required|string',
                'interview_result' => 'required|in:pending,passed,failed',
            ]);

            $admission = Admission::findOrFail($id);
            $admission->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Interview updated successfully.',
                'data' => $admission,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update interview: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function showExam()
    {
        return view('admission.entrance_exam');
    }

    public function showEvaluation()
    {
        return view('admission.final_eval');
    }
}