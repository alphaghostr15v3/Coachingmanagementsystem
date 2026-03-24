<?php

namespace App\Http\Controllers\CoachingAdmin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\Course;
use App\Models\Batch;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $courses = Course::all();
        $batches = Batch::all();
        $students = Student::all();

        $query = Attendance::with(['student', 'batch']);

        if ($request->filled('course_id')) {
            $query->whereHas('student', function($q) use ($request) {
                $q->where('course_id', $request->course_id);
            });
        }

        if ($request->filled('batch_id')) {
            $query->where('batch_id', $request->batch_id);
        }

        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->filled('month')) {
            $query->whereMonth('date', $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('date', $request->year);
        }

        $attendances = $query->latest('date')->get();

        // Calculate statistics
        $totalDays = $attendances->count();
        $presentCount = $attendances->where('status', 'present')->count();
        $absentCount = $attendances->where('status', 'absent')->count();
        $attendancePercentage = $totalDays > 0 ? round(($presentCount / $totalDays) * 100, 2) : 0;

        return view('coaching.attendance.index', compact(
            'attendances', 
            'courses', 
            'batches', 
            'students',
            'presentCount', 
            'absentCount', 
            'totalDays', 
            'attendancePercentage'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $batches = Batch::with(['course', 'teacher'])->get();
        $batch = null;
        $students = collect();
        $date = $request->get('date', date('Y-m-d'));
        $existingAttendance = collect();

        if ($request->filled('batch_id')) {
            $batch = Batch::with('students')->find($request->batch_id);
            if ($batch) {
                $students = $batch->students;
                $existingAttendance = Attendance::where('batch_id', $batch->id)
                    ->where('date', $date)
                    ->pluck('status', 'student_id');
            }
        }

        return view('coaching.attendance.create', compact('batches', 'batch', 'students', 'date', 'existingAttendance'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'batch_id' => 'required|exists:tenant.batches,id',
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'required|in:present,absent',
        ]);

        foreach ($request->attendance as $studentId => $status) {
            Attendance::updateOrCreate(
                ['student_id' => $studentId, 'batch_id' => $request->batch_id, 'date' => $request->date],
                ['status' => $status]
            );
        }

        return redirect()->route('coaching.attendance.index')->with('success', 'Attendance marked successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        return view('coaching.attendance.show', compact('attendance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        return view('coaching.attendance.edit', compact('attendance'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'status' => 'required|in:present,absent',
        ]);

        $attendance->update($request->only('status'));

        return redirect()->route('coaching.attendance.index')->with('success', 'Attendance updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return back()->with('success', 'Attendance record deleted.');
    }
}
