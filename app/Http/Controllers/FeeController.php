<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Fee;

class FeeController extends Controller
{
    public function showFees() {
        $programs = Program::where('status', 'active')->orderBy("created_at", "asc")->get();

        return view('accounting.fee', [
            'programs' => $programs,
        ]);
    }

    public function searchFee(Request $request) {
        // validate
        $request->validate([
            'program' => 'required|string|max:255',
            'academic_year' => 'required|string|max:255',
        ]);
        // assign
        $program = $request->program;
        $academic_year = $request->academic_year;

        $major_fees = Fee::where('group','major')->where('academic_year',$academic_year)->where('program_id',$program)->get();
        $other_fees = Fee::where('group','other')->where('academic_year',$academic_year)->where('program_id',$program)->get();
        $additional_fees = Fee::where('group','additional')->where('academic_year',$academic_year)->where('program_id',$program)->get();
        $programs = Program::where('status', 'active')->orderBy("created_at", "asc")->get();

        return view('accounting.fee', [
            'programs' => $programs,
            'major_fees' => $major_fees,
            'other_fees' => $other_fees,
            'additional_fees' => $additional_fees,
            'old_program' => $program,
            'old_academic_year' => $academic_year,
        ]);
    }

    public function createFee(Request $request) {
        // Validate the request
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'months_to_pay' => 'nullable|numeric',
            'group' => 'required|string|max:255',
            'academic_year' => 'required|string|max:255',
            'program_id' => 'required|exists:programs,id',
        ]);

        $fees = Fee::create([
            'description' => $validated['description'],
            'amount' => $validated['amount'],
            'type' => $validated['type'],
            'month_to_pay' => $validated['months_to_pay'],
            'group' => $validated['group'],
            'academic_year' => $validated['academic_year'],
            'program_id' => $validated['program_id'],
        ]);

        return redirect()->route('accounting.fee.search', [
            'program' => $validated['program_id'],
            'academic_year' => $validated['academic_year'],
        ]);
    }

    public function updateFee(Request $request, $id) {
        // Find the fee or fail
        $fee = Fee::findOrFail($id);

        // Validate the request
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'months_to_pay' => 'nullable|numeric',
            'group' => 'required|string|max:255',
            'academic_year' => 'required|string|max:255',
            'program' => 'required|exists:programs,id',
        ]);

        // Update the fee
        $fee->update([
            'description' => $validated['description'],
            'amount' => $validated['amount'],
            'type' => $validated['type'],
            'month_to_pay' => $validated['months_to_pay'],
            'group' => $validated['group'],
            'academic_year' => $validated['academic_year'],
            'program_id' => $validated['program'],
        ]);

        return redirect()->route('accounting.fee.search', [
            'program' => $validated['program'],
            'academic_year' => $validated['academic_year'],
        ])->with('success', 'Fee updated successfully.');
    }

    public function deleteFee($id) {
        // Find the fee or fail
        $fee = Fee::findOrFail($id);

        // Store program and academic year before deleting
        $program_id = $fee->program_id;
        $academic_year = $fee->academic_year;

        // Delete the fee
        $fee->delete();

        return redirect()->route('accounting.fee.search', [
            'program' => $program_id,
            'academic_year' => $academic_year,
        ])->with('success', 'Fee deleted successfully.');
    }
}
