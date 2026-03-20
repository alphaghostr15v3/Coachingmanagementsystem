<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\FacultyAttendance;
use App\Models\SalarySlip;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $faculty = Faculty::where('email', $user->email)->first();
        
        if (!$faculty) {
            return redirect('/')->with('error', 'Faculty profile not found.');
        }

        $attendanceCount = FacultyAttendance::where('faculty_id', $faculty->id)
            ->where('status', 'present')
            ->count();

        $latestSalary = SalarySlip::where('faculty_id', $faculty->id)
            ->latest()
            ->first();

        $notices = \App\Models\Notice::latest()->take(5)->get();

        return view('faculty.dashboard', compact('faculty', 'attendanceCount', 'latestSalary', 'notices'));
    }

    public function attendance(Request $request)
    {
        $user = auth()->user();
        $faculty = Faculty::where('email', $user->email)->first();
        
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));

        if (!$faculty) {
            $attendances = collect();
            $presentCount = 0;
            $absentCount = 0;
            $lateCount = 0;
            $totalAttendance = 0;
        } else {
            $attendances = FacultyAttendance::where('faculty_id', $faculty->id)
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->latest('date')
                ->get();
            
            $monthlyAttendance = $attendances; // Since we already filtered for the current month
                
            $presentCount = $monthlyAttendance->where('status', 'present')->count();
            $absentCount = $monthlyAttendance->where('status', 'absent')->count();
            $lateCount = $monthlyAttendance->where('status', 'late')->count();
            $totalAttendance = $monthlyAttendance->count();
        }

        return view('faculty.attendance.index', compact('attendances', 'presentCount', 'absentCount', 'lateCount', 'totalAttendance', 'month', 'year'));
    }

    public function notices()
    {
        $notices = \App\Models\Notice::latest()->get();
        return view('faculty.notices.index', compact('notices'));
    }

    public function profile()
    {
        $user = auth()->user();
        $faculty = Faculty::where('email', $user->email)->first();
        
        if (!$faculty) {
            return redirect()->route('faculty.dashboard')->with('error', 'Faculty profile not found.');
        }

        return view('faculty.profile', compact('faculty'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $faculty = Faculty::where('email', $user->email)->first();

        if (!$faculty) {
            return redirect()->route('faculty.dashboard')->with('error', 'Faculty profile not found.');
        }

        $request->validate([
            'phone' => 'nullable|string|max:20',
            'qualification' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $facultyData = [
            'phone' => $request->phone,
            'qualification' => $request->qualification,
            'experience' => $request->experience,
        ];

        if ($request->hasFile('profile_image')) {
            // Delete old image
            if ($faculty->profile_image && file_exists(public_path($faculty->profile_image))) {
                @unlink(public_path($faculty->profile_image));
            }

            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/faculties');
            
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            
            $image->move($destinationPath, $imageName);
            $facultyData['profile_image'] = 'uploads/faculties/' . $imageName;
        }

        $faculty->update($facultyData);

        return back()->with('success', 'Profile updated successfully.');
    }
}
