<?php

namespace App\Http\Controllers\Coaching;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SalarySlip;
use App\Models\Teacher;
use App\Models\TeacherAttendance;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class SalarySlipController extends Controller
{
    public function getAttendanceCount(Request $request)
    {
        $teacherId = $request->teacher_id;
        $monthName = $request->month;
        $year = $request->year;

        if (!$teacherId || !$monthName || !$year) {
            return response()->json(['count' => 0]);
        }

        try {
            $month = Carbon::parse($monthName)->month;
            
            $count = TeacherAttendance::where('teacher_id', $teacherId)
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->where('status', 'present')
                ->count();

            return response()->json(['count' => $count]);
        } catch (\Exception $e) {
            return response()->json(['count' => 0, 'error' => $e->getMessage()]);
        }
    }

    public function index()
    {
        $slips = SalarySlip::with('teacher')->latest()->get();
        $currentCoaching = auth()->user()->coaching ?? \App\Models\Coaching::first();
        return view('coaching.salary_slips.index', compact('slips', 'currentCoaching'));
    }

    public function create()
    {
        $teachers = Teacher::all();
        $currentCoaching = auth()->user()->coaching ?? \App\Models\Coaching::first();
        return view('coaching.salary_slips.create', compact('teachers', 'currentCoaching'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:tenant.teachers,id',
            'month' => 'required|string',
            'year' => 'required|integer',
            'basic_salary' => 'required|numeric|min:0',
            'total_days' => 'nullable|integer|min:0',
            'per_day_pay' => 'nullable|numeric|min:0',
            'earnings' => 'nullable|array',
            'earnings.names.*' => 'string|nullable',
            'earnings.amounts.*' => 'numeric|nullable',
            'deductions' => 'nullable|array',
            'deductions.names.*' => 'string|nullable',
            'deductions.amounts.*' => 'numeric|nullable',
            'payment_date' => 'required|date',
            'payment_status' => 'required|string',
            'remarks' => 'nullable|string'
        ]);

        // Process earnings
        $processedEarnings = [];
        $totalEarnings = 0;
        if (isset($validated['earnings']['names'])) {
            for ($i = 0; $i < count($validated['earnings']['names']); $i++) {
                if (!empty($validated['earnings']['names'][$i]) && isset($validated['earnings']['amounts'][$i])) {
                    $amt = (float)$validated['earnings']['amounts'][$i];
                    $processedEarnings[] = [
                        'name' => $validated['earnings']['names'][$i],
                        'amount' => $amt
                    ];
                    $totalEarnings += $amt;
                }
            }
        }

        // Process deductions
        $processedDeductions = [];
        $totalDeductions = 0;
        if (isset($validated['deductions']['names'])) {
            for ($i = 0; $i < count($validated['deductions']['names']); $i++) {
                if (!empty($validated['deductions']['names'][$i]) && isset($validated['deductions']['amounts'][$i])) {
                    $amt = (float)$validated['deductions']['amounts'][$i];
                    $processedDeductions[] = [
                        'name' => $validated['deductions']['names'][$i],
                        'amount' => $amt
                    ];
                    $totalDeductions += $amt;
                }
            }
        }

        $basic = (float)$validated['basic_salary'];
        $netSalary = $basic + $totalEarnings - $totalDeductions;

        SalarySlip::create([
            'teacher_id' => $validated['teacher_id'],
            'month' => $validated['month'],
            'year' => $validated['year'],
            'basic_salary' => $basic,
            'total_days' => $validated['total_days'] ?? 0,
            'per_day_pay' => $validated['per_day_pay'] ?? 0,
            'earnings' => $processedEarnings,
            'deductions' => $processedDeductions,
            'net_salary' => $netSalary,
            'payment_date' => $validated['payment_date'],
            'payment_status' => $validated['payment_status'],
            'remarks' => $validated['remarks'] ?? null
        ]);

        return redirect()->route('coaching.salary-slips.index')->with('success', 'Salary Slip generated successfully!');
    }

    public function show(SalarySlip $salarySlip)
    {
        $salarySlip->load('teacher');
        $currentCoaching = auth()->user()->coaching ?? \App\Models\Coaching::first();
        return view('coaching.salary_slips.show', compact('salarySlip', 'currentCoaching'));
    }

    public function download(SalarySlip $salarySlip)
    {
        $salarySlip->load('teacher');
        $currentCoaching = auth()->user()->coaching ?? \App\Models\Coaching::first();
        
        $pdf = Pdf::loadView('coaching.salary_slips.pdf', compact('salarySlip', 'currentCoaching'));
        
        $filename = 'Salary_Slip_' . $salarySlip->month . '_' . $salarySlip->year . '_' . str_replace(' ', '_', $salarySlip->teacher->name) . '.pdf';
        
        return $pdf->download($filename);
    }

    public function destroy(SalarySlip $salarySlip)
    {
        $salarySlip->delete();
        return redirect()->route('coaching.salary-slips.index')->with('success', 'Salary Slip deleted successfully!');
    }
}
