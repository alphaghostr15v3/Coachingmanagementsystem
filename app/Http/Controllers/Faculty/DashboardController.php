<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\FacultyAttendance;
use App\Models\SalarySlip;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $faculty = Faculty::where('email', $user->email)->first();
        
        if (!$faculty) {
            return redirect('/')->with('error', 'Faculty profile not found.');
        }

        $attendanceCount = FacultyAttendance::where('faculty_id', $faculty->id)
            ->whereMonth('date', now()->month)
            ->where('status', 'present')
            ->count();

        $latestSalary = SalarySlip::where('teacher_id', $faculty->id) // Note: Need to check if salary slips use teacher_id or generic ID
            ->latest()
            ->first();

        return view('faculty.dashboard', compact('faculty', 'attendanceCount', 'latestSalary'));
    }

    public function attendance()
    {
        $user = auth()->user();
        $faculty = Faculty::where('email', $user->email)->first();
        
        if (!$faculty) {
            $attendances = collect();
        } else {
            $attendances = FacultyAttendance::where('faculty_id', $faculty->id)
                ->latest('date')
                ->get();
        }

        return view('faculty.attendance.index', compact('attendances'));
    }

    public function notices()
    {
        $notices = \App\Models\Notice::latest()->get();
        return view('faculty.notices.index', compact('notices'));
    }
}
