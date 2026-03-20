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
        
        $marks = $student ? Mark::with('exam.course')->where('student_id', $student->id)->latest()->take(5)->get() : [];
        $notices = Notice::latest()->take(5)->get();
        
        // Calculate attendance for current month
        $attendancePercentage = 0;
        $totalPresentDays = 0;
        if ($student) {
            $currentMonth = date('m');
            $currentYear = date('Y');
            
            $totalAttendance = Attendance::where('student_id', $student->id)
                ->whereMonth('date', $currentMonth)
                ->whereYear('date', $currentYear)
                ->count();
            
            if ($totalAttendance > 0) {
                $presentCount = Attendance::where('student_id', $student->id)
                    ->whereMonth('date', $currentMonth)
                    ->whereYear('date', $currentYear)
                    ->whereIn('status', ['present', 'late', 'half_day'])
                    ->count();
                
                $attendancePercentage = round(($presentCount / $totalAttendance) * 100);
            }
            
            $totalPresentDays = Attendance::where('student_id', $student->id)
                ->whereIn('status', ['present', 'late', 'half_day'])
                ->count();
        }
        
        return view('student.dashboard', compact('marks', 'notices', 'student', 'attendancePercentage', 'totalPresentDays'));
    }

    public function attendance(Request $request)
    {
        $user = auth()->user();
        $student = \App\Models\Student::where('email', $user->email)->first();
        
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));

        $attendance = $student ? Attendance::where('student_id', $student->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->latest()
            ->get() : [];

        $attendancePercentage = 0;
        $presentCount = 0;
        $totalDays = count($attendance);
        
        if ($totalDays > 0) {
            $presentCount = $attendance->whereIn('status', ['present', 'late', 'half_day'])->count();
            $attendancePercentage = round(($presentCount / $totalDays) * 100);
        }

        return view('student.attendance.index', compact('attendance', 'month', 'year', 'attendancePercentage', 'presentCount', 'totalDays'));
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

    public function profile()
    {
        $user = auth()->user();
        $student = \App\Models\Student::where('email', $user->email)->first();
        return view('student.profile', compact('student'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $student = \App\Models\Student::where('email', $user->email)->first();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'phone', 'address']);

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            
            // Ensure the directory exists
            $destinationPath = public_path('uploads/students');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $image->move($destinationPath, $imageName);
            $data['profile_image'] = 'uploads/students/' . $imageName;
            
            // Delete old image if exists
            if ($student->profile_image && file_exists(public_path($student->profile_image))) {
                @unlink(public_path($student->profile_image));
            }
        }

        $student->update($data);
        
        // Also update user name if changed
        $user->update(['name' => $request->name]);

        return back()->with('success', 'Profile updated successfully.');
    }
}
