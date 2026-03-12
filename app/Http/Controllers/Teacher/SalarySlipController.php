<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalarySlip;
use App\Models\Teacher;
use Barryvdh\DomPDF\Facade\Pdf;

class SalarySlipController extends Controller
{
    public function index()
    {
        $teacher = Teacher::where('email', auth()->user()->email)->first();
        
        if (!$teacher) {
            $slips = collect();
        } else {
            $slips = SalarySlip::where('teacher_id', $teacher->id)
                ->latest()
                ->get();
        }
            
        $currentCoaching = auth()->user()->coaching ?? \App\Models\Coaching::first();
        
        return view('teacher.salary_slips.index', compact('slips', 'currentCoaching'));
    }

    public function show(SalarySlip $salarySlip)
    {
        $teacher = Teacher::where('email', auth()->user()->email)->first();

        // Security check: ensure the slip belongs to this teacher
        if (!$teacher || $salarySlip->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized action.');
        }

        $currentCoaching = auth()->user()->coaching ?? \App\Models\Coaching::first();
        return view('teacher.salary_slips.show', compact('salarySlip', 'currentCoaching'));
    }

    public function download(SalarySlip $salarySlip)
    {
        $teacher = Teacher::where('email', auth()->user()->email)->first();

        // Security check: ensure the slip belongs to this teacher
        if (!$teacher || $salarySlip->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized action.');
        }

        $currentCoaching = auth()->user()->coaching ?? \App\Models\Coaching::first();
        
        // We reuse the same PDF template as Admin
        $pdf = Pdf::loadView('coaching.salary_slips.pdf', compact('salarySlip', 'currentCoaching'));
        
        $filename = 'Salary_Slip_' . $salarySlip->month . '_' . $salarySlip->year . '.pdf';
        
        return $pdf->download($filename);
    }
}
