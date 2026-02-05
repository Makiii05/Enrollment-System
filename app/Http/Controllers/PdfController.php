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
    public function printAdmissionStats()
    {
        // Get all levels with their applicant counts by status
        $levelStats = Level::select(
                'levels.id',
                'levels.code',
                'levels.description',
                DB::raw("COUNT(applicants.id) as total_applicants"),
                DB::raw("SUM(CASE WHEN applicants.status = 'admitted' THEN 1 ELSE 0 END) as total_admitted"),
                DB::raw("SUM(CASE WHEN applicants.status = 'interview' THEN 1 ELSE 0 END) as total_interview"),
                DB::raw("SUM(CASE WHEN applicants.status = 'exam' THEN 1 ELSE 0 END) as total_exam"),
                DB::raw("SUM(CASE WHEN applicants.status = 'evaluation' THEN 1 ELSE 0 END) as total_eval")
            )
            ->leftJoin('applicants', 'levels.code', '=', 'applicants.level')
            ->groupBy('levels.id', 'levels.code', 'levels.description')
            ->orderBy('levels.program_id')
            ->get();

        // Calculate grand totals
        $grandTotals = [
            'total_applicants' => $levelStats->sum('total_applicants'),
            'total_admitted' => $levelStats->sum('total_admitted'),
            'total_interview' => $levelStats->sum('total_interview'),
            'total_exam' => $levelStats->sum('total_exam'),
            'total_eval' => $levelStats->sum('total_eval'),
        ];

        $pdf = Pdf::loadView('pdf.print_admission_stats', compact('levelStats', 'grandTotals'));
        
        return $pdf->stream('admission_stats_' . date('Y-m-d') . '.pdf');

        // return view('pdf.print_admission_stats', compact('levelStats', 'grandTotals'));
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
