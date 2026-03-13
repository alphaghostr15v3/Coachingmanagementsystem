<?php

namespace App\Http\Controllers\CoachingAdmin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\FacultyAttendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FacultyAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->get('date', Carbon::today()->toDateString());
        $attendances = FacultyAttendance::with('faculty')->where('date', $date)->get();
        
        return view('coaching.faculty_attendance.index', compact('attendances', 'date'));
    }

    public function create(Request $request)
    {
        $date = $request->get('date', Carbon::today()->toDateString());
        $faculties = Faculty::all();
        
        // Get existing attendance for this date to pre-fill
        $existingAttendance = FacultyAttendance::where('date', $date)
            ->pluck('status', 'faculty_id')
            ->toArray();

        return view('coaching.faculty_attendance.mark', compact('faculties', 'date', 'existingAttendance'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'required|in:present,absent,late,leave',
            'remarks' => 'nullable|array',
        ]);

        foreach ($request->attendance as $facultyId => $status) {
            FacultyAttendance::updateOrCreate(
                ['faculty_id' => $facultyId, 'date' => $request->date],
                [
                    'status' => $status,
                    'remarks' => $request->remarks[$facultyId] ?? null
                ]
            );
        }

        return redirect()->route('coaching.faculty-attendance.index', ['date' => $request->date])
            ->with('success', 'Faculty attendance marked successfully.');
    }

    public function destroy(FacultyAttendance $facultyAttendance)
    {
        $facultyAttendance->delete();
        return back()->with('success', 'Attendance record deleted.');
    }
}
