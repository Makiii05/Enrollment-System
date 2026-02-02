<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Applicant;
use App\Models\Admission;

class DashboardController extends Controller
{
    public function admissionDashboard()
    {
        $officialStudents = Student::count();
        $totalApplicants = Applicant::count();
        $interviewCount = Applicant::where('status', 'interview')->count();
        $examCount = Applicant::where('status', 'exam')->count();
        $evaluationCount = Applicant::where('status', 'evaluation')->count();

        // Get feeder schools with applicant counts by status
        $feederSchools = Applicant::select(
                DB::raw("
                    CASE
                        WHEN college_school_name IS NOT NULL AND college_school_name != '' AND college_school_name != 'N/A' THEN college_school_name
                        WHEN senior_school_name IS NOT NULL AND senior_school_name != '' AND senior_school_name != 'N/A' THEN senior_school_name
                        WHEN junior_school_name IS NOT NULL AND junior_school_name != '' AND junior_school_name != 'N/A' THEN junior_school_name
                        WHEN elementary_school_name IS NOT NULL AND elementary_school_name != '' AND elementary_school_name != 'N/A' THEN elementary_school_name
                        ELSE 'Unknown'
                    END as last_school_attended
                "),
                DB::raw("COUNT(*) as total_applicants"),
                DB::raw("SUM(CASE WHEN status IN ('pending', 'interview', 'exam', 'evaluation') THEN 1 ELSE 0 END) as ongoing"),
                DB::raw("SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as failed"),
                DB::raw("SUM(CASE WHEN status = 'admitted' THEN 1 ELSE 0 END) as passed")
            )
            ->groupBy('last_school_attended')
            ->orderByDesc('total_applicants')
            ->get();

        return view('admission.dashboard', compact(
            'officialStudents',
            'totalApplicants',
            'interviewCount',
            'examCount',
            'evaluationCount',
            'feederSchools'
        ));
    }
}
