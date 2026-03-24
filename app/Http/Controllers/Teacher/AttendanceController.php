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
    public function myAttendance(Request $request)
    {
        $teacher = Teacher::where('email', auth()->user()->email)->first();
        
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));

        if (!$teacher) {
            $attendances = collect();
            $presentCount = 0;
            $absentCount = 0;
            $lateCount = 0;
            $totalAttendance = 0;
        } else {
            $attendances = TeacherAttendance::where('teacher_id', $teacher->id)
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->latest('date')
                ->get();
                
            $presentCount = $attendances->where('status', 'present')->count();
            $absentCount = $attendances->where('status', 'absent')->count();
            $lateCount = $attendances->where('status', 'late')->count();
            $totalAttendance = $attendances->count();
        }

        return view('teacher.attendance.my_attendance', compact('attendances', 'month', 'year', 'presentCount', 'absentCount', 'lateCount', 'totalAttendance'));
    }

    public function index()
    {
        $attendances = Attendance::with(['student', 'batch.course'])->latest()->take(100)->get();
        return view('teacher.attendance.index', compact('attendances'));
    }

    public function create(Request $request)
    {
        $batch = Batch::with(['students', 'course'])->findOrFail($request->batch_id);
        $students = $batch->students; 
        $date = $request->get('date', date('Y-m-d'));
        
        $existingAttendance = Attendance::where('batch_id', $batch->id)
            ->where('date', $date)
            ->pluck('status', 'student_id');

        return view('teacher.attendance.create', compact('batch', 'students', 'date', 'existingAttendance'));
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
