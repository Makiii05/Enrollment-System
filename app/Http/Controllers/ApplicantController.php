<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    //
    public function showApplication(){
        return view('application');
    }
    
    public function createApplication(Request $request){
    }
    
    public function updateApplication(Request $request, $id){
    }
}
