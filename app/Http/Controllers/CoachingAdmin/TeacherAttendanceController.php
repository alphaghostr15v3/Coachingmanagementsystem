<?php

namespace App\Http\Controllers\CoachingAdmin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\TeacherAttendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TeacherAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->get('date', Carbon::today()->toDateString());
        $attendances = TeacherAttendance::with('teacher')->where('date', $date)->get();
        
        return view('coaching.teacher_attendance.index', compact('attendances', 'date'));
    }

    public function create(Request $request)
    {
        $date = $request->get('date', Carbon::today()->toDateString());
        $teachers = Teacher::all();
        
        // Get existing attendance for this date to pre-fill
        $existingAttendance = TeacherAttendance::where('date', $date)
            ->pluck('status', 'teacher_id')
            ->toArray();

        return view('coaching.teacher_attendance.mark', compact('teachers', 'date', 'existingAttendance'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'required|in:present,absent,late,leave',
            'remarks' => 'nullable|array',
        ]);

        foreach ($request->attendance as $teacherId => $status) {
            TeacherAttendance::updateOrCreate(
                ['teacher_id' => $teacherId, 'date' => $request->date],
                [
                    'status' => $status,
                    'remarks' => $request->remarks[$teacherId] ?? null
                ]
            );
        }

        return redirect()->route('coaching.teacher-attendance.index', ['date' => $request->date])
            ->with('success', 'Teacher attendance marked successfully.');
    }

    public function destroy(TeacherAttendance $teacherAttendance)
    {
        $teacherAttendance->delete();
        return back()->with('success', 'Attendance record deleted.');
    }
}
