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
        $faculties = Faculty::all();
        
        $query = FacultyAttendance::with('faculty');

        if ($request->filled('faculty_id')) {
            $query->where('faculty_id', $request->faculty_id);
        }

        if ($request->filled('month')) {
            $query->whereMonth('date', $request->month);
        } else {
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

        if ($request->has('date') && !$request->filled('faculty_id') && !$request->filled('month')) {
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

        return view('coaching.faculty_attendance.index', compact(
            'attendances', 
            'date', 
            'faculties', 
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
