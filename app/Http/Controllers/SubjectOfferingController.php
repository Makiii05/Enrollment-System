<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Curriculum;
use App\Models\Prospectus;
use App\Models\Level;

class SubjectOfferingController extends Controller
{
    public function showSubjectOffering()
    {
        $departments = Department::where('status', 'active')->orderBy('created_at', 'asc')->get();

        return view('department.offering', [
            'departments' => $departments,
        ]);
    }

    public function searchOffering(Request $request)
    {
        $validated = $request->validate([
            'department' => 'required|string|max:255',
            'curriculum' => 'required|exists:curricula,id',
        ]);

        $department = $validated['department'];
        $curriculum_id = $validated['curriculum'];

        $prospectuses = Prospectus::where('status', 'active')
            ->where('curriculum_id', $curriculum_id)
            ->whereHas('curriculum', function ($query) use ($department) {
                $query->where('department_id', $department);
            })
            ->with(['curriculum.department', 'level.program', 'subject'])
            ->orderBy('created_at', 'asc')
            ->get();

        $departments = Department::where('status', 'active')->orderBy('created_at', 'asc')->get();

        return view('department.offering', [
            'prospectuses' => $prospectuses,
            'departments' => $departments,
            'old_department' => $department,
            'old_curriculum' => $curriculum_id,
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
