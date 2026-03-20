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
        $teachers = Teacher::all();
        
        $query = TeacherAttendance::with('teacher');

        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        if ($request->filled('month')) {
            $query->whereMonth('date', $request->month);
        } else {
            // Default to current month if no specific date is requested
            if (!$request->has('date')) {
                $query->whereMonth('date', Carbon::today()->month);
            }
        }

        if ($request->filled('year')) {
            $query->whereYear('date', $request->year);
        } else {
            if (!$request->has('date')) {
                $query->whereYear('date', Carbon::today()->year);
            }
        }

        if ($request->has('date') && !$request->filled('teacher_id') && !$request->filled('month')) {
            $date = $request->get('date', Carbon::today()->toDateString());
            $query->where('date', $date);
        } else {
            $date = $request->get('date', Carbon::today()->toDateString());
        }

        $attendances = $query->latest('date')->get();

        // Calculate statistics
        $totalRecords = $attendances->count();
        $presentCount = $attendances->where('status', 'present')->count();
        $absentCount = $attendances->where('status', 'absent')->count();
        $lateCount = $attendances->where('status', 'late')->count();
        $leaveCount = $attendances->where('status', 'leave')->count();
        $attendancePercentage = $totalRecords > 0 ? round(($presentCount / $totalRecords) * 100, 2) : 0;

        return view('coaching.teacher_attendance.index', compact(
            'attendances', 
            'date', 
            'teachers', 
            'totalRecords', 
            'presentCount', 
            'absentCount', 
            'lateCount', 
            'leaveCount', 
            'attendancePercentage'
        ));
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
