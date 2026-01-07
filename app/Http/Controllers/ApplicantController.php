<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Level;
use App\Models\Program;

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
    }
    
    public function updateApplication(Request $request, $id){
    }
}
