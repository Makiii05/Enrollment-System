<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Admission;
use App\Models\Applicant;

class AdmissionProcessController extends Controller
{
    public function showInterview()
    {
        $schedules = Schedule::orderBy('created_at', 'desc')->where('status', 'active')->where('process', 'exam')->get();
        $applicants = Admission::with(['applicant', 'interviewSchedule'])
            ->whereHas('applicant', function ($query) {
                $query->where('status', 'interview');
            })
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

    public function markForExam(Request $request){
        $validated = $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'applicant_ids' => 'required|array|min:1',
            'applicant_ids.*' => 'exists:admissions,id',
        ]);

        // check if applicants in admission has someone not passed the exam
        $ifNotPassed = Admission::whereIn('id', $validated['applicant_ids'])
            ->where('interview_result', '!=', 'passed')
            ->count();
        if($ifNotPassed > 0){
            return redirect()->route('admission.interview')
                ->with('error', 'Some selected applicants have not passed the interview.');
        }

        // Update all selected applicants using admission id to 'exam' status

        Applicant::whereIn('id', function($query) use ($validated) {
                $query->select('applicant_id')
                      ->from('admissions')
                      ->whereIn('id', $validated['applicant_ids']);
            })
            ->update([
                'status' => 'exam',
            ]);

        // Update admission records for each applicant
        foreach($validated['applicant_ids'] as $applicantId){
            $admission = Admission::find($applicantId);
            $admission->update([
                'exam_schedule_id' => $validated['schedule_id'],
                'exam_result' => 'pending',
            ]);
        }

        $count = count($validated['applicant_ids']);
        
        return redirect()->route('admission.interview')
            ->with('success', "{$count} applicant(s) marked for interview successfully.");
    }

    public function showExam()
    {
        $applicants = Admission::with(['applicant', 'examSchedule'])
            ->whereHas('applicant', function ($query) {
                $query->where('status', 'exam');
            })
            ->paginate(20);

        return view('admission.entrance_exam', [
            'applicants' => $applicants,
        ]);    
    }

    public function updateExam(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'math_score' => 'nullable|numeric|min:0',
                'science_score' => 'nullable|numeric|min:0',
                'english_score' => 'nullable|numeric|min:0',
                'filipino_score' => 'nullable|numeric|min:0',
                'abstract_score' => 'nullable|numeric|min:0',
                'exam_score' => 'nullable|numeric|min:0',
                'exam_result' => 'required|in:pending,passed,failed',
            ]);

            $admission = Admission::findOrFail($id);
            $admission->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Exam scores updated successfully.',
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
                'message' => 'Failed to update exam scores: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function markForEvaluation(Request $request){
        $validated = $request->validate([
            'applicant_ids' => 'required|array|min:1',
            'applicant_ids.*' => 'exists:admissions,id',
        ]);

        // check if applicants in admission has someone not passed the exam
        $ifNotPassed = Admission::whereIn('id', $validated['applicant_ids'])
            ->where('exam_result', '!=', 'passed')
            ->count();
        if($ifNotPassed > 0){
            return redirect()->route('admission.exam')
                ->with('error', 'Some selected applicants have not passed the exam.');
        }

        // Update all selected applicants using admission id to 'exam' status
        Applicant::whereIn('id', function($query) use ($validated) {
                $query->select('applicant_id')
                      ->from('admissions')
                      ->whereIn('id', $validated['applicant_ids']);
            })
            ->update([
                'status' => 'evaluation',
            ]);

        // Update admission records for each applicant
        foreach($validated['applicant_ids'] as $applicantId){
            $admission = Admission::find($applicantId);
            $admission->update([
                'final_score' => $admission->interview_score + $admission->exam_score,
            ]);
        }

        $count = count($validated['applicant_ids']);
        
        return redirect()->route('admission.exam')
            ->with('success', "{$count} applicant(s) marked for interview successfully.");
    }

    public function showEvaluation()
    {
        return view('admission.final_eval');
    }
}