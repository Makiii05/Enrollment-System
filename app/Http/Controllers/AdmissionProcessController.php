<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdmissionProcessController extends Controller
{
    public function showInterview()
    {
        return view('admission.interview');
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