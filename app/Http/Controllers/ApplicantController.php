<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Level;
use App\Models\Program;
use App\Models\Applicant;
use App\Models\Schedule;
use Carbon\Carbon;

class ApplicantController extends Controller
{
    //
    public function showApplication(){
        $levels = Level::all();
        $strands =  Program::whereHas('department', function($query){
            $query->where('code', 'SHS');
        })->get();
        $college_programs = Program::whereHas('department', function($query){
            $query->where('description', 'like', '%College%');
        })->get();

        return view('application', [
            'levels' => $levels,
            'strands' => $strands,
            'college_programs' => $college_programs,
        ]);
    }
    
    public function createApplication(Request $request){
        // Validate the request
        $validated = $request->validate([
            "application_no" => "required|unique:applicants,application_no",
            "level" => "required",
            "student_type" => "required",
            "year_level" => "nullable",
            "strand" => "nullable",
            "first_program_choice" => "nullable",
            "second_program_choice" => "nullable",
            "third_program_choice" => "nullable",
            "last_name" => "required",
            "first_name" => "required",
            "middle_name" => "required",
            "sex" => "required",
            "citizenship" => "required",
            "religion" => "required",
            "birthdate" => "required|date",
            "place_of_birth" => "required",
            "civil_status" => "required",
            "present_address" => "required",
            "zip_code" => "required|integer",
            "permanent_address" => "required",
            "telephone_number" => "nullable",
            "mobile_number" => "nullable",
            "email" => "required|email",
            "email_confirmation" => "required|email|same:email",
            "mother_name" => "required",
            "mother_occupation" => "required",
            "mother_contact_number" => "required",
            "mother_monthly_income" => "required|integer",
            "father_name" => "required",
            "father_occupation" => "required",
            "father_contact_number" => "required",
            "father_monthly_income" => "required|integer",
            "guardian_name" => "required",
            "guardian_occupation" => "required",
            "guardian_contact_number" => "required",
            "guardian_monthly_income" => "required|integer",
            "elementary_school_name" => "required",
            "elementary_school_address" => "required",
            "elementary_inclusive_years" => "required",
            "junior_school_name" => "required",
            "junior_school_address" => "required",
            "junior_inclusive_years" => "required",
            "senior_school_name" => "required",
            "senior_school_address" => "required",
            "senior_inclusive_years" => "required",
            "college_school_name" => "required",
            "college_school_address" => "required",
            "college_inclusive_years" => "required",
            "lrn" => "required|integer",
        ]);
        
        // Check if applicant with this email already exists
        $existingApplicant = Applicant::where('email', $validated['email'])->first();
        
        if($existingApplicant){
            // Update existing applicant (keep original application_no)
            $existingApplicant->update($request->except(['email_confirmation']));
            $applicant = $existingApplicant;
            $isNew = false;
        } else {
            // Create new applicant
            $applicant = Applicant::create($request->except('email_confirmation'));
            $isNew = true;
        }
        
        // Redirect with success notification
        return redirect()->route('applicant.form')
            ->with('success', true)
            ->with('application_no', $applicant->application_no)
            ->with('is_new', $isNew);
    }

    public function showApplicant(){
        $applicants = Applicant::orderBy('created_at', 'desc')->paginate(20);
        $schedules = Schedule::orderBy('created_at', 'desc')->where('status', 'active')->where('process', 'interview')->get();

        return view('admission.applicant', [
            'applicants' => $applicants,
            'schedules' => $schedules,
        ]);
    }

    public function markForInterview(Request $request){
        $validated = $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'applicant_ids' => 'required|array|min:1',
            'applicant_ids.*' => 'exists:applicants,id',
        ]);

        // Update all selected applicants to 'interview' status
        Applicant::whereIn('id', $validated['applicant_ids'])
            ->update([
                'status' => 'interview',
            ]);

        $count = count($validated['applicant_ids']);
        
        return redirect()->route('admission.applicant')
            ->with('success', "{$count} applicant(s) marked for interview successfully.");
    }
}
