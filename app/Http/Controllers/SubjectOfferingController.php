<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Curriculum;
use App\Models\Prospectus;
use App\Models\Level;
use App\Models\AcademicTerm;
use App\Models\SubjectOffering;

class SubjectOfferingController extends Controller
{
    public function showSubjectOffering(Request $request)
    {
        $departments = Department::where('status', 'active')->orderBy('created_at', 'asc')->get();

        $academicTermId = $request->query('academic_term_id');
        $academicTerm = $academicTermId ? AcademicTerm::find($academicTermId) : null;

        return view('department.offering', [
            'departments' => $departments,
            'academicTerm' => $academicTerm,
        ]);
    }

    public function searchOffering(Request $request)
    {
        $validated = $request->validate([
            'department' => 'required|string|max:255',
            'curriculum' => 'required|exists:curricula,id',
            'academic_term_id' => 'nullable|exists:academic_terms,id',
        ]);

        $department = $validated['department'];
        $curriculum_id = $validated['curriculum'];
        $academicTermId = $validated['academic_term_id'] ?? null;
        $academicTerm = $academicTermId ? AcademicTerm::find($academicTermId) : null;

        $prospectuses = Prospectus::where('status', 'active')
            ->where('curriculum_id', $curriculum_id)
            ->whereHas('curriculum', function ($query) use ($department) {
                $query->where('department_id', $department);
            })
            ->with(['curriculum.department', 'level.program', 'subject'])
            ->orderBy('created_at', 'asc')
            ->get();

        $departments = Department::where('status', 'active')->orderBy('created_at', 'asc')->get();

        // Load subject offerings for this academic term and department
        $subjectOfferings = null;
        if ($academicTerm) {
            $subjectOfferings = SubjectOffering::where('academic_term_id', $academicTerm->id)
                ->where('department_id', $department)
                ->with('subject')
                ->get();
        }

        return view('department.offering', [
            'prospectuses' => $prospectuses,
            'departments' => $departments,
            'old_department' => $department,
            'old_curriculum' => $curriculum_id,
            'academicTerm' => $academicTerm,
            'subjectOfferings' => $subjectOfferings,
        ]);
    }

    public function getCurriculaByDepartment($departmentId)
    {
        $curricula = Curriculum::where('department_id', $departmentId)
            ->where('status', 'active')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($curricula);
    }
}
