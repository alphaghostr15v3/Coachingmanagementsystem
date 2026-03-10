<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\Mark;
use App\Models\Attendance;
use App\Models\Notice;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        // Since students are in tenant DB, we find the student record by email
        $student = \App\Models\Student::where('email', $user->email)->first();
        
        $marks = $student ? Mark::where('student_id', $student->id)->latest()->take(5)->get() : [];
        $notices = Notice::latest()->take(5)->get();
        
        return view('student.dashboard', compact('marks', 'notices', 'student'));
    }

    public function attendance()
    {
        $user = auth()->user();
        $student = \App\Models\Student::where('email', $user->email)->first();
        $attendance = $student ? Attendance::where('student_id', $student->id)->latest()->get() : [];
        return view('student.attendance.index', compact('attendance'));
    }

    public function marks()
    {
        $user = auth()->user();
        $student = \App\Models\Student::where('email', $user->email)->first();
        $marks = $student ? Mark::with('exam')->where('student_id', $student->id)->latest()->get() : [];
        return view('student.marks.index', compact('marks'));
    }

    public function notices()
    {
        $notices = Notice::latest()->get();
        return view('student.notices.index', compact('notices'));
    }
}
