<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\AcademicTerm;
use App\Models\StudentFee;
use App\Models\Enlistment;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;

class CashierController extends Controller
{
    public function showCashier()
    {
        return view('accounting.cashier');
    }

    public function searchStudents(Request $request)
    {
        $search = $request->input('search', '');
        
        if (empty($search)) {
            return response()->json(['data' => []]);
        }
        
        $students = Student::with(['department', 'program', 'level'])
            ->where(function ($query) use ($search) {
                $query->where('student_number', 'like', '%' . $search . '%')
                    ->orWhere('lrn', 'like', '%' . $search . '%')
                    ->orWhere('first_name', 'like', '%' . $search . '%')
                    ->orWhere('middle_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orWhere('sex', 'like', '%' . $search . '%')
                    ->orWhere('citizenship', 'like', '%' . $search . '%')
                    ->orWhere('religion', 'like', '%' . $search . '%')
                    ->orWhere('place_of_birth', 'like', '%' . $search . '%')
                    ->orWhere('civil_status', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%')
                    ->orWhereHas('department', function ($q) use ($search) {
                        $q->where('code', 'like', '%' . $search . '%')
                          ->orWhere('description', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('program', function ($q) use ($search) {
                        $q->where('code', 'like', '%' . $search . '%')
                          ->orWhere('description', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('level', function ($q) use ($search) {
                        $q->where('code', 'like', '%' . $search . '%')
                          ->orWhere('description', 'like', '%' . $search . '%');
                    });
            })
            ->orderBy('student_number')
            ->get();
        
        return response()->json(['data' => $students]);
    }

    public function showPayment($id)
    {
        $student = Student::with(['department', 'program', 'level', 'contact'])->findOrFail($id);

        // Get all academic terms for this student's department
        $academicTerms = AcademicTerm::where('department_id', $student->department_id)
            ->orderBy('created_at')
            ->get();

        return view('accounting.payment', compact('student', 'academicTerms'));
    }

    public function getStudentFees($studentId, $academicTermId)
    {
        $studentFees = StudentFee::with(['fee'])
            ->where('student_id', $studentId)
            ->where('academic_term_id', $academicTermId)
            ->get();

        $grouped = [
            'major' => [],
            'other' => [],
            'additional' => [],
        ];

        foreach ($studentFees as $sf) {
            $fee = $sf->fee;
            if (!$fee) continue;

            $item = [
                'student_fee_id' => $sf->id,
                'fee_id' => $fee->id,
                'description' => $fee->description,
                'amount' => $fee->amount,
                'type' => $fee->type,
                'month_to_pay' => $fee->months_to_pay,
            ];

            if ($fee->group === 'major') {
                $grouped['major'][] = $item;
            } elseif ($fee->group === 'other') {
                $grouped['other'][] = $item;
            } elseif ($fee->group === 'additional') {
                $grouped['additional'][] = $item;
            }
        }

        return response()->json(['success' => true, 'data' => $grouped]);
    }

    public function getEnlistments($studentId, $academicTermId)
    {
        $enlistments = Enlistment::with(['subjectOffering.subject'])
            ->where('student_id', $studentId)
            ->where('academic_term_id', $academicTermId)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $enlistments->map(function ($enlistment) {
                return [
                    'id' => $enlistment->id,
                    'code' => $enlistment->subjectOffering->code ?? '-',
                    'description' => $enlistment->subjectOffering->description ?? '-',
                    'unit' => $enlistment->subjectOffering->subject->unit ?? 0,
                ];
            }),
        ]);
    }

    // ── Transaction Methods ──────────────────────────────────────
    public function getTransactions($studentId, $academicTermId)
    {
        $transactions = Transaction::where('student_id', $studentId)
            ->where('academic_term_id', $academicTermId)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['success' => true, 'data' => $transactions]);
    }

    public function createTransaction(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'academic_term_id' => 'required|exists:academic_terms,id',
            'or_number' => 'nullable|string|max:100',
            'type' => 'required|string|max:100',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        // Add cashier_id from authenticated user
        $validated['cashier_id'] = auth()->id();

        $transaction = Transaction::create($validated);

        return response()->json(['success' => true, 'data' => $transaction], 201);
    }

    public function deleteTransaction($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return response()->json(['success' => true, 'message' => 'Transaction deleted']);
    }

    public function getNextOrNumber()
    {
        $cashierId = auth()->id();
        $count = Transaction::where('cashier_id', $cashierId)->count();
        $nextOrNumber = $count + 1;
        
        return response()->json(['success' => true, 'or_number' => $nextOrNumber]);
    }

    // ── PDF Generation Methods ──────────────────────────────────────
    public function printDailyTransactions(Request $request)
    {
        $date = $request->query('date', date('Y-m-d'));
        $cashierId = auth()->id();
        $cashierName = auth()->user()->name;

        $transactions = Transaction::with(['student', 'academicTerm', 'cashier'])
            ->whereDate('date', $date)
            ->where('cashier_id', $cashierId)
            ->orderBy('created_at')
            ->get();

        $totalAmount = $transactions->sum('amount');

        $pdf = Pdf::loadView('pdf.daily_transactions', compact('transactions', 'date', 'cashierName', 'totalAmount'))
            ->setPaper('a4', 'portrait');
        
        return $pdf->stream('daily_transactions_' . $date . '.pdf');
    }

    public function printSalesInvoice($id)
    {
        $transaction = Transaction::with(['student', 'academicTerm', 'cashier'])->findOrFail($id);
        $cashierName = $transaction->cashier->name ?? 'N/A';

        $pdf = Pdf::loadView('pdf.sales_invoice', compact('transaction', 'cashierName'))
            ->setPaper([0, 0, 288, 432], 'portrait'); // 4x6 inches (72 points per inch)
        
        return $pdf->stream('sales_invoice_' . $transaction->or_number . '.pdf');
    }
}
