<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prospectus;
use App\Models\Curriculum;
use App\Models\AcademicTerm;
use App\Models\Subject;
use App\Models\Level;
use App\Models\Department;

class ProspectusController extends Controller
{
    private function validateSearchRequest(Request $request): array
    {
        return $request->validate([
            'department' => 'required|string|max:255',
            'academic_year' => 'required|string|max:255',
        ]);
    }

    private function validateProspectusRequest(Request $request): array
    {
        return $request->validate([
            'curriculum' => 'required|exists:curricula,id',
            'academic_term' => 'required|exists:academic_terms,id',
            'level' => 'required|exists:levels,id',
            'subject' => 'required|exists:subjects,id',
            'status' => 'required|in:active,inactive',
        ]);
    }

    public function showProspectus(){
        $curricula = Curriculum::where('status', 'active')->orderBy("created_at", "asc")->get();
        $academicTerms = AcademicTerm::where('status', 'active')->orderBy("created_at", "asc")->get();
        $subjects = Subject::where('status', 'active')->orderBy("created_at", "asc")->get();
        $departments = Department::where('status', 'active')->orderBy("created_at", "asc")->get();
        $levels = Level::whereHas('program', function ($query) use ($departments) {
                $query->where('department_id', $departments->first()->id);
            })->orderBy("order", "asc")->get();
        
        return view('registrar.prospectus', [
            'curricula' => $curricula,
            'academicTerms' => $academicTerms,
            'subjects' => $subjects,
            'departments' => $departments,
            'levels' => $levels,
        ]);
    }

    public function searchProspectus(Request $request){
        $validated = $this->validateSearchRequest($request);

        $department = $validated['department'];
        $academic_year = $validated['academic_year'];

        $prospectuses = Prospectus::where('status', 'active')
            ->whereHas('curriculum', function ($query) use ($department) {
                $query->where('department_id', $department);
            })
            ->whereHas('academicTerm', function ($query) use ($academic_year) {
                $query->where('academic_year', $academic_year);
            })
            ->with(['curriculum.department', 'academicTerm', 'level', 'subject'])
            ->orderBy("created_at", "asc")
            ->get();
        $curricula = Curriculum::where('status', 'active')->orderBy("created_at", "asc")->get();
        $academicTerms = AcademicTerm::where('status', 'active')->orderBy("created_at", "asc")->get();
        $subjects = Subject::where('status', 'active')->orderBy("created_at", "asc")->get();
        $departments = Department::where('status', 'active')->orderBy("created_at", "asc")->get();
        $levels = Level::whereHas('program', function ($query) use ($departments) {
                $query->where('department_id', $departments->first()->id);
            })->orderBy("order", "asc")->get();
        
        return view('registrar.prospectus', [
            'prospectuses' => $prospectuses,
            'curricula' => $curricula,
            'academicTerms' => $academicTerms,
            'subjects' => $subjects,
            'departments' => $departments,
            'levels' => $levels,
            'old_department' => $department,
            'old_academic_year' => $academic_year,
        ]);
    }
    
    public function createProspectus(Request $request){
        $validated = $this->validateProspectusRequest($request);

        $prospectus = Prospectus::create([
            'curriculum_id' => $validated['curriculum'],
            'academic_term_id' => $validated['academic_term'],
            'level_id' => $validated['level'],
            'subject_id' => $validated['subject'],
            'status' => $validated['status'],
        ]);

        $prospectus->load(['curriculum.department', 'academicTerm.department', 'level.program', 'subject']);

        return response()->json([
            'success' => true,
            'message' => 'Prospectus created successfully',
            'prospectus' => $prospectus
        ]);
    }

    public function updateProspectus(Request $request, $id){
        $prospectus = Prospectus::findOrFail($id);
        
        $validated = $this->validateProspectusRequest($request);

        $prospectus->update([
            'curriculum_id' => $validated['curriculum'],
            'academic_term_id' => $validated['academic_term'],
            'level_id' => $validated['level'],
            'subject_id' => $validated['subject'],
            'status' => $validated['status'],
        ]);

        $prospectus->load(['curriculum.department', 'academicTerm.department', 'level.program', 'subject']);

        return response()->json([
            'success' => true,
            'message' => 'Prospectus updated successfully',
            'prospectus' => $prospectus
        ]);
    }

    public function deleteProspectus($id){
        $prospectus = Prospectus::findOrFail($id);
        $prospectus->delete();

        return response()->json([
            'success' => true,
            'message' => 'Prospectus deleted successfully'
        ]);
    }

    public function getLevelsByDepartment($departmentId)
    {
        $levels = Level::whereHas('program', function ($query) use ($departmentId) {
                $query->where('department_id', $departmentId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($levels);
    }

    public function getProspectusesApi(Request $request)
    {
        $validated = $this->validateSearchRequest($request);

        $department = $validated['department'];
        $academic_year = $validated['academic_year'];

        $prospectuses = Prospectus::where('status', 'active')
            ->whereHas('curriculum', function ($query) use ($department) {
                $query->where('department_id', $department);
            })
            ->whereHas('academicTerm', function ($query) use ($academic_year) {
                $query->where('academic_year', $academic_year);
            })
            ->with(['curriculum.department', 'academicTerm.department', 'level.program', 'subject'])
            ->orderBy("created_at", "asc")
            ->get();

        $grouped = $prospectuses->groupBy('academic_term_id')->map(function ($termGroup) {
            return [
                'academic_term' => $termGroup->first()->academicTerm,
                'levels' => $termGroup->groupBy('level_id')->map(function ($levelGroup) {
                    return [
                        'level' => $levelGroup->first()->level,
                        'prospectuses' => $levelGroup->values()
                    ];
                })->values()
            ];
        })->values();

        return response()->json([
            'success' => true,
            'data' => $grouped,
            'count' => $prospectuses->count()
        ]);
    }
}