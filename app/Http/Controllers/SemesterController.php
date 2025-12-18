<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Semester;

class SemesterController extends Controller
{
    //
    public function showSemester(){
        $semesters = Semester::orderBy("created_at", "asc")->paginate(10);
        return view('registrar.semester', [
            'semesters' => $semesters
        ]);
    }
    
    public function createSemester(Request $request){
        $request->validate([
            'code' => 'required|string|max:255|unique:semesters',
            'description' => 'required|string|max:255',
            'academic_year' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,inactive',
        ]);

        Semester::create([
            'code' => $request->code,
            'description' => $request->description,
            'academic_year' => $request->academic_year,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        return redirect()->route('registrar.semester')->with('success', 'Semester created successfully');
    }
    
    public function updateSemester(Request $request, $id){
        $semester = Semester::findOrFail($id);
        
        $request->validate([
            'code' => 'required|string|max:255|unique:semesters,code,'.$id,
            'description' => 'required|string|max:255',
            'academic_year' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,inactive',
        ]);

        $semester->update([
            'code' => $request->code,
            'description' => $request->description,
            'academic_year' => $request->academic_year,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        return redirect()->route('registrar.semester')->with('success', 'Semester updated successfully');
    }
    
    public function deleteSemester($id){
        $semester = Semester::findOrFail($id);
        $semester->delete();
        
        return redirect()->route('registrar.semester')->with('success', 'Semester deleted successfully');
    }
}
