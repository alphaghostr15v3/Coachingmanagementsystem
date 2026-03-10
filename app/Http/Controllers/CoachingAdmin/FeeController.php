<?php

namespace App\Http\Controllers\CoachingAdmin;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\Student;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fees = Fee::with('student')->latest()->get();
        return view('coaching.fees.index', compact('fees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::all();
        return view('coaching.fees.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:tenant.students,id',
            'amount'     => 'required|numeric|min:0',
            'status'     => 'required|in:paid,unpaid',
            'date'       => 'required|date',
            'cgst_rate'  => 'nullable|numeric',
            'sgst_rate'  => 'nullable|numeric',
            'igst_rate'  => 'nullable|numeric',
            'total_amount' => 'required|numeric',
        ]);

        $cgstRate  = $request->input('cgst_rate', 0) ?? 0;
        $sgstRate  = $request->input('sgst_rate', 0) ?? 0;
        $igstRate  = $request->input('igst_rate', 0) ?? 0;
        $base      = (float) $request->amount;
        $cgstAmt   = round($base * $cgstRate / 100, 2);
        $sgstAmt   = round($base * $sgstRate / 100, 2);
        $igstAmt   = round($base * $igstRate / 100, 2);
        $total     = $request->input('total_amount', $base + $cgstAmt + $sgstAmt + $igstAmt);

        Fee::create([
            'student_id'  => $request->student_id,
            'amount'      => $base,
            'status'      => $request->status,
            'date'        => $request->date,
            'cgst_rate'   => $cgstRate,
            'cgst_amount' => $cgstAmt,
            'sgst_rate'   => $sgstRate,
            'sgst_amount' => $sgstAmt,
            'igst_rate'   => $igstRate,
            'igst_amount' => $igstAmt,
            'total_amount' => $total,
        ]);

        return redirect()->route('coaching.fees.index')->with('success', 'Fee record added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fee $fee)
    {
        return view('coaching.fees.show', compact('fee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fee $fee)
    {
        $students = Student::all();
        return view('coaching.fees.edit', compact('fee', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fee $fee)
    {
        $request->validate([
            'student_id'   => 'required|exists:tenant.students,id',
            'amount'       => 'required|numeric|min:0',
            'status'       => 'required|in:paid,unpaid',
            'date'         => 'required|date',
            'cgst_rate'    => 'nullable|numeric',
            'sgst_rate'    => 'nullable|numeric',
            'igst_rate'    => 'nullable|numeric',
            'total_amount' => 'required|numeric',
        ]);

        $cgstRate  = $request->input('cgst_rate', 0) ?? 0;
        $sgstRate  = $request->input('sgst_rate', 0) ?? 0;
        $igstRate  = $request->input('igst_rate', 0) ?? 0;
        $base      = (float) $request->amount;
        $cgstAmt   = round($base * $cgstRate / 100, 2);
        $sgstAmt   = round($base * $sgstRate / 100, 2);
        $igstAmt   = round($base * $igstRate / 100, 2);
        $total     = $request->input('total_amount', $base + $cgstAmt + $sgstAmt + $igstAmt);

        $fee->update([
            'student_id'  => $request->student_id,
            'amount'      => $base,
            'status'      => $request->status,
            'date'        => $request->date,
            'cgst_rate'   => $cgstRate,
            'cgst_amount' => $cgstAmt,
            'sgst_rate'   => $sgstRate,
            'sgst_amount' => $sgstAmt,
            'igst_rate'   => $igstRate,
            'igst_amount' => $igstAmt,
            'total_amount' => $total,
        ]);

        return redirect()->route('coaching.fees.index')->with('success', 'Fee record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fee $fee)
    {
        $fee->delete();
        return back()->with('success', 'Fee record removed.');
    }

    /**
     * Download invoice as PDF.
     */
    public function downloadInvoice(Fee $fee)
    {
        $fee->load('student');
        $pdf = Pdf::loadView('coaching.fees.invoice_pdf', compact('fee'));
        
        $filename = 'Invoice-' . str_pad($fee->id, 6, '0', STR_PAD_LEFT) . '.pdf';
        return $pdf->download($filename);
    }
}
