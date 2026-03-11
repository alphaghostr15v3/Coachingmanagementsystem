<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalarySlip;
use Barryvdh\DomPDF\Facade\Pdf;

class SalarySlipController extends Controller
{
    public function index()
    {
        $slips = SalarySlip::where('teacher_id', auth()->id())
            ->latest()
            ->get();
            
        $currentCoaching = auth()->user()->coaching ?? \App\Models\Coaching::first();
        
        return view('teacher.salary_slips.index', compact('slips', 'currentCoaching'));
    }

    public function show(SalarySlip $salarySlip)
    {
        // Security check: ensure the slip belongs to this teacher
        if ($salarySlip->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $currentCoaching = auth()->user()->coaching ?? \App\Models\Coaching::first();
        return view('teacher.salary_slips.show', compact('salarySlip', 'currentCoaching'));
    }

    public function download(SalarySlip $salarySlip)
    {
        // Security check: ensure the slip belongs to this teacher
        if ($salarySlip->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $currentCoaching = auth()->user()->coaching ?? \App\Models\Coaching::first();
        
        // We reuse the same PDF template as Admin
        $pdf = Pdf::loadView('coaching.salary_slips.pdf', compact('salarySlip', 'currentCoaching'));
        
        $filename = 'Salary_Slip_' . $salarySlip->month . '_' . $salarySlip->year . '.pdf';
        
        return $pdf->download($filename);
    }
}
