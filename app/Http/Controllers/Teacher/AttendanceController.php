<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\TeacherAttendance;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function myAttendance()
    {
        $teacher = Teacher::where('email', auth()->user()->email)->first();
        
        if (!$teacher) {
            $attendances = collect();
        } else {
            $attendances = TeacherAttendance::where('teacher_id', $teacher->id)
                ->latest('date')
                ->get();
        }

        return view('teacher.attendance.my_attendance', compact('attendances'));
    }

    public function index()
    {
        $attendances = Attendance::with(['student', 'batch'])->latest()->take(100)->get();
        return view('teacher.attendance.index', compact('attendances'));
    }

    public function create(Request $request)
    {
        $batch = Batch::with('students')->findOrFail($request->batch_id);
        $students = $batch->students; 
        return view('teacher.attendance.create', compact('batch', 'students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'batch_id' => 'required',
            'date' => 'required|date',
            'status' => 'required|array',
        ]);

        foreach ($request->status as $student_id => $status) {
            Attendance::updateOrCreate(
                ['batch_id' => $request->batch_id, 'student_id' => $student_id, 'date' => $request->date],
                ['status' => $status]
            );
        }

        return redirect()->route('teacher.attendance.index')->with('success', 'Attendance marked successfully.');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return back()->with('success', 'Attendance record deleted.');
    }
}
