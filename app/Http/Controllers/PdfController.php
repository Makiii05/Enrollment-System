<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;
use App\Models\Admission;
use App\Models\Level;
use App\Models\Schedule;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class PdfController extends Controller
{
    public function printAdmissionStats(Request $request)
    {
        $selectedYear = $request->query('academic_year', '2025 - 2026');

        // Group by applicants.level (e.g. "College", "Senior High", "Junior High", etc.)
        $levelStats = Applicant::select(
                'applicants.level as level_name',
                DB::raw("COUNT(DISTINCT applicants.id) as total_applicants"),
                DB::raw("SUM(CASE WHEN admissions.interview_result IN ('passed','failed') THEN 1 ELSE 0 END) as total_interviewee"),
                DB::raw("SUM(CASE WHEN admissions.exam_result IN ('passed','failed') THEN 1 ELSE 0 END) as total_examinee"),
                DB::raw("SUM(CASE WHEN admissions.decision IN ('accepted','rejected') THEN 1 ELSE 0 END) as total_evaluatee"),
                DB::raw("SUM(CASE WHEN admissions.decision = 'accepted' THEN 1 ELSE 0 END) as total_admitted")
            )
            ->leftJoin('admissions', 'applicants.id', '=', 'admissions.applicant_id')
            ->where('applicants.academic_year', $selectedYear)
            ->groupBy('applicants.level')
            ->orderBy('applicants.level')
            ->get();

        // Calculate grand totals
        $grandTotals = [
            'total_applicants'  => $levelStats->sum('total_applicants'),
            'total_interviewee' => $levelStats->sum('total_interviewee'),
            'total_examinee'    => $levelStats->sum('total_examinee'),
            'total_evaluatee'   => $levelStats->sum('total_evaluatee'),
            'total_admitted'    => $levelStats->sum('total_admitted'),
        ];
        $grandTotals['variance'] = $grandTotals['total_applicants'] - $grandTotals['total_admitted'];

        $pdf = Pdf::loadView('pdf.print_admission_stats', compact('levelStats', 'grandTotals', 'selectedYear'));
        
        return $pdf->stream('admission_stats_' . date('Y-m-d') . '.pdf');
    }

    public function printApplicantDetails($id)
    {
        $applicants = Applicant::where('id', $id)->get();

        $pdf = Pdf::loadView('pdf.print_applicant_details', compact('applicants'));
        
        return $pdf->stream('applicant_details_' . date('Y-m-d') . '.pdf');
        // return view('pdf.print_applicant_details', compact('applicants'));
    }

    public function printInterviewList(Request $request)
    {
        $levelId = $request->query('level_id');
        $level = null;

        $query = Admission::with(['applicant', 'interviewSchedule'])
            ->whereHas('applicant', function ($query) {
                $query->where('status', 'interview');
            });;
        
        if ($levelId) {
            $level = Level::find($levelId);
            $query->whereHas('applicant', function($q) use ($level) {
                $q->where('year_level', $level->description);
            });
        }
        
        $applicants = $query->get();

        $pdf = Pdf::loadView('pdf.print_interview_list', compact('applicants', 'level'))
            ->setPaper('a4', 'landscape');
        
        return $pdf->stream('interview_list_' . date('Y-m-d') . '.pdf');
    }

    public function printExamList(Request $request)
    {
        $levelId = $request->query('level_id');
        $level = null;
        
        $query = Admission::with(['applicant', 'examSchedule'])
            ->whereHas('applicant', function ($query) {
                $query->where('status', 'exam');
            });;
        if ($levelId) {
            $level = Level::find($levelId);
            $query->whereHas('applicant', function($q) use ($level) {
                $q->where('year_level', $level->description);
            });
        }
        
        $applicants = $query->get();

        $pdf = Pdf::loadView('pdf.print_exam_list', compact('applicants', 'level'))
            ->setPaper('a4', 'landscape');
        
        return $pdf->stream('exam_list_' . date('Y-m-d') . '.pdf');
    }

    public function printEvaluationList(Request $request)
    {
        $levelId = $request->query('level_id');
        $level = null;
        
        $query = Admission::with(['applicant', 'evaluationSchedule'])
            ->whereHas('applicant', function ($query) {
                $query->where('status', 'evaluation');
            });;
        
        if ($levelId) {
            $level = Level::find($levelId);
            $query->whereHas('applicant', function($q) use ($level) {
                $q->where('year_level', $level->description);
            });
        }
        
        $applicants = $query->get();

        $pdf = Pdf::loadView('pdf.print_evaluation_list', compact('applicants', 'level'))
            ->setPaper('a4', 'landscape');
        
        return $pdf->stream('evaluation_list_' . date('Y-m-d') . '.pdf');
    }

    public function printScheduleApplicants($id)
    {
        $schedule = Schedule::where('id', $id)->first();
        $scheduleType = $schedule->process;

        $applicants = Applicant::whereHas('admission', function($q) use ($id, $scheduleType) {
                if ($scheduleType == 'interview') {
                    $q->where('interview_schedule_id', $id);
                } elseif ($scheduleType == 'exam') {
                    $q->where('exam_schedule_id', $id);
                } elseif ($scheduleType == 'evaluation') {
                    $q->where('evaluation_schedule_id', $id);
                }
        })->get();

        $pdf = Pdf::loadView('pdf.print_schedule_applicants', compact('schedule', 'applicants'));
        
        return $pdf->stream('schedule_applicants_' . date('Y-m-d') . '.pdf');
    }
}
