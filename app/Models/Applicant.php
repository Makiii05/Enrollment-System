<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    //
    protected $fillable = [
        "application_no",
        "level",
        "student_type",
        "year_level",
        "strand",
        "first_program_choice",
        "second_program_choice",
        "third_program_choice",
        "last_name",
        "first_name",
        "middle_name",
        "sex",
        "citizenship",
        "religion",
        "birthdate",
        "place_of_birth",
        "civil_status",
        "present_address",
        "zip_code",
        "permanent_address",
        "telephone_number",
        "mobile_number",
        "email",
        "mother_name",
        "mother_occupation",
        "mother_contact_number",
        "mother_monthly_income",
        "father_name",
        "father_occupation",
        "father_contact_number",
        "father_monthly_income",
        "guardian_name",
        "guardian_occupation",
        "guardian_contact_number",
        "guardian_monthly_income",
        "elementary_school_name",
        "elementary_school_address",
        "elementary_inclusive_years",
        "junior_school_name",
        "junior_school_address",
        "junior_inclusive_years",
        "senior_school_name",
        "senior_school_address",
        "senior_inclusive_years",
        "college_school_name",
        "college_school_address",
        "college_inclusive_years",
        "lrn",
        "status",
    ];
}
