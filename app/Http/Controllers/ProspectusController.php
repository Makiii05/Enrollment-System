<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prospectus;
use App\Models\Curriculum;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\Program;

class ProspectusController extends Controller
{
    //
    public function showProspectus(){
        $curricula = Curriculum::where('status', 'active')->orderBy("created_at", "asc")->get();
        $semesters = Semester::where('status', 'active')->orderBy("created_at", "asc")->get();
        $subjects = Subject::where('status', 'active')->orderBy("created_at", "asc")->get();
        $programs = Program::where('status', 'active')->orderBy("created_at", "asc")->get();
        
        return view('registrar.prospectus', [
            'curricula' => $curricula,
            'semesters' => $semesters,
            'subjects' => $subjects,
            'programs' => $programs,
        ]);
    }

    public function searchProspectus(Request $request){
        // validate
        $request->validate([
            'program' => 'required|string|max:255',
            'academic_year' => 'required|string|max:255',
        ]);
        // assign
        $program = $request->program;
        $academic_year = $request->academic_year;
        // query
        $prospectuses = Prospectus::whereHas('curriculum', function ($query) use ($program) {
            $query->where('program_id', $program);
        })->whereHas('semester', function ($query) use ($academic_year) {
            $query->where('academic_year', $academic_year);
        })
        ->with('curriculum', 'semester', 'subject')
        ->get();

        $curricula = Curriculum::where('status', 'active')->orderBy("created_at", "asc")->get();
        $semesters = Semester::where('status', 'active')->orderBy("created_at", "asc")->get();
        $subjects = Subject::where('status', 'active')->orderBy("created_at", "asc")->get();
        $programs = Program::where('status', 'active')->orderBy("created_at", "asc")->get();

        return view('registrar.prospectus', [
            'prospectuses' => $prospectuses,
            'curricula' => $curricula,
            'semesters' => $semesters,
            'subjects' => $subjects,
            'programs' => $programs,
            'old_program' => $program,
            'old_academic_year' => $academic_year,
        ]);
    }
    
    public function insertProspectus(Request $request){
        // Validate the request
        $validated = $request->validate([
            'curriculum' => 'required|exists:curricula,id',
            'semester' => 'required|exists:semesters,id',
            'subject' => 'required|exists:subjects,id',
            'status' => 'required|in:active,inactive',
        ]);

        // Create the prospectus
        $prospectus = Prospectus::create([
            'curriculum_id' => $validated['curriculum'],
            'semester_id' => $validated['semester'],
            'subject_id' => $validated['subject'],
            'status' => $validated['status'],
        ]);

        // Get the curriculum and semester to extract program and academic_year
        $curriculum = Curriculum::find($validated['curriculum']);
        $semester = Semester::find($validated['semester']);

        // Redirect to searchProspectus with program and academic_year
        return redirect()->route('registrar.prospectus.search', [
            'program' => $curriculum->program_id,
            'academic_year' => $semester->academic_year,
        ]);
    }

    public function updateProspectus(Request $request, $id){
        $prospectus = Prospectus::findOrFail($id);
        
        $validated = $request->validate([
            'curriculum' => 'required|exists:curricula,id',
            'semester' => 'required|exists:semesters,id',
            'subject' => 'required|exists:subjects,id',
            'status' => 'required|in:active,inactive',
        ]);

        $prospectus->update([
            'curriculum_id' => $validated['curriculum'],
            'semester_id' => $validated['semester'],
            'subject_id' => $validated['subject'],
            'status' => $validated['status'],
        ]);

        // Get the curriculum and semester to extract program and academic_year
        $curriculum = Curriculum::find($validated['curriculum']);
        $semester = Semester::find($validated['semester']);

        return redirect()->route('registrar.prospectus.search', [
            'program' => $curriculum->program_id,
            'academic_year' => $semester->academic_year,
        ])->with('success', 'Prospectus updated successfully');
    }

    public function deleteProspectus($id){
        $prospectus = Prospectus::findOrFail($id);
        
        // Store the program and academic year before deleting
        $curriculum = $prospectus->curriculum;
        $semester = $prospectus->semester;
        
        $prospectus->delete();

        return redirect()->route('registrar.prospectus.search', [
            'program' => $curriculum->program_id,
            'academic_year' => $semester->academic_year,
        ])->with('success', 'Prospectus deleted successfully');
    }
}
