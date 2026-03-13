<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalarySlip;
use App\Models\Faculty;
use Barryvdh\DomPDF\Facade\Pdf;

class SalarySlipController extends Controller
{
    public function index()
    {
        $faculty = Faculty::where('email', auth()->user()->email)->first();
        
        if (!$faculty) {
            $slips = collect();
        } else {
            $slips = SalarySlip::where('faculty_id', $faculty->id)
                ->with(['faculty', 'teacher'])
                ->latest()
                ->get();
        }
            
        $currentCoaching = auth()->user()->coaching ?? \App\Models\Coaching::first();
        
        return view('faculty.salary_slips.index', compact('slips', 'currentCoaching'));
    }

    public function show(SalarySlip $salarySlip)
    {
        $faculty = Faculty::where('email', auth()->user()->email)->first();

        // Security check: ensure the slip belongs to this faculty member
        if (!$faculty || $salarySlip->faculty_id !== $faculty->id) {
            abort(403, 'Unauthorized action.');
        }

        $salarySlip->load(['teacher', 'faculty']);
        $currentCoaching = auth()->user()->coaching ?? \App\Models\Coaching::first();
        return view('faculty.salary_slips.show', compact('salarySlip', 'currentCoaching'));
    }

    public function download(SalarySlip $salarySlip)
    {
        $faculty = Faculty::where('email', auth()->user()->email)->first();

        // Security check: ensure the slip belongs to this faculty member
        if (!$faculty || $salarySlip->faculty_id !== $faculty->id) {
            abort(403, 'Unauthorized action.');
        }

        $salarySlip->load(['teacher', 'faculty']);
        $currentCoaching = auth()->user()->coaching ?? \App\Models\Coaching::first();
        
        // We reuse the same PDF template as Admin
        $pdf = Pdf::loadView('coaching.salary_slips.pdf', compact('salarySlip', 'currentCoaching'));
        
        $name = $salarySlip->faculty ? $salarySlip->faculty->name : 'Employee';
        $filename = 'Salary_Slip_' . $salarySlip->month . '_' . $salarySlip->year . '_' . str_replace(' ', '_', $name) . '.pdf';
        
        return $pdf->download($filename);
    }
}
