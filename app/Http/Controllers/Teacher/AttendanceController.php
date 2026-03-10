<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
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

        return redirect()->route('teacher.dashboard')->with('success', 'Attendance marked successfully.');
    }
}
