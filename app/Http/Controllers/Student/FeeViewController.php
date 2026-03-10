<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Fee;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;

class FeeViewController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        // Since students are in tenant DB, we find the student record by email
        $student = Student::where('email', $user->email)->first();
        
        $fees = $student ? Fee::where('student_id', $student->id)->latest()->get() : [];
        
        return view('student.fees.index', compact('fees'));
    }

    public function downloadReceipt(Fee $fee)
    {
        $user = auth()->user();
        $student = Student::where('email', $user->email)->first();

        // Security check: ensure the fee belongs to the authenticated student
        if (!$student || $fee->student_id !== $student->id) {
            abort(403, 'Unauthorized action.');
        }

        $fee->load('student');
        $pdf = Pdf::loadView('coaching.fees.invoice_pdf', compact('fee'));

        $filename = 'Receipt-' . str_pad($fee->id, 6, '0', STR_PAD_LEFT) . '.pdf';
        return $pdf->download($filename);
    }
}
