<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Exam;
use App\Models\Notice;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $teacher = \App\Models\Teacher::where('email', auth()->user()->email)->first();
        
        $batchCount = $teacher ? $teacher->batches()->count() : 0;
        $batchIds = $teacher ? $teacher->batches()->pluck('id')->toArray() : [];
        $examCount = Exam::whereIn('batch_id', $batchIds)->count();
        $salarySlipCount = $teacher ? \App\Models\SalarySlip::where('teacher_id', $teacher->id)->count() : 0;
        $attendanceCount = $teacher ? $teacher->attendances()->whereIn('status', ['present', 'late', 'half_day'])->count() : 0;
        $notices = Notice::latest()->take(5)->get();
        
        return view('teacher.dashboard', compact('batchCount', 'examCount', 'salarySlipCount', 'attendanceCount', 'notices'));
    }

    public function batches()
    {
        $teacher = \App\Models\Teacher::where('email', auth()->user()->email)->first();
        $batches = $teacher ? $teacher->batches()->with('course')->get() : [];
        return view('teacher.batches.index', compact('batches'));
    }

    public function exams()
    {
        $teacher = \App\Models\Teacher::where('email', auth()->user()->email)->first();
        $batchIds = $teacher ? $teacher->batches()->pluck('id')->toArray() : [];
        
        $exams = Exam::whereIn('batch_id', $batchIds)
            ->with(['course', 'batch'])
            ->latest()
            ->get();
            
        return view('teacher.exams.index', compact('exams'));
    }

    public function notices()
    {
        $notices = Notice::latest()->get();
        return view('teacher.notices.index', compact('notices'));
    }

    public function students(Request $request)
    {
        $teacher = \App\Models\Teacher::where('email', auth()->user()->email)->first();
        
        if (!$teacher) {
            return view('teacher.students.index', ['students' => [], 'batches' => [], 'selectedBatch' => null]);
        }

        $batches = $teacher->batches;
        $batchIds = $batches->pluck('id')->toArray();

        $selectedBatchId = $request->batch_id;
        
        $query = \App\Models\Student::whereHas('batches', function($q) use ($batchIds, $selectedBatchId) {
            $q->whereIn('batches.id', $batchIds);
            if ($selectedBatchId) {
                $q->where('batches.id', $selectedBatchId);
            }
        });

        $students = $query->with('batches')->get();
        $selectedBatch = $selectedBatchId ? \App\Models\Batch::find($selectedBatchId) : null;

        return view('teacher.students.index', compact('students', 'batches', 'selectedBatch'));
    }

    public function showStudent(\App\Models\Student $student)
    {
        $teacher = \App\Models\Teacher::where('email', auth()->user()->email)->first();
        if (!$teacher) {
            abort(403);
        }

        // Verify that the student belongs to one of the teacher's batches
        $batchIds = $teacher->batches->pluck('id')->toArray();
        $isAssigned = $student->batches()->whereIn('batches.id', $batchIds)->exists();

        if (!$isAssigned) {
            abort(403);
        }

        return view('teacher.students.show', compact('student'));
    }

    public function profile()
    {
        $teacher = \App\Models\Teacher::where('email', auth()->user()->email)->first();
        return view('teacher.profile', compact('teacher'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $teacher = \App\Models\Teacher::where('email', $user->email)->first();

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
            $destinationPath = public_path('uploads/teachers');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $image->move($destinationPath, $imageName);
            $data['profile_image'] = 'uploads/teachers/' . $imageName;
            
            // Delete old image if exists
            if ($teacher->profile_image && file_exists(public_path($teacher->profile_image))) {
                @unlink(public_path($teacher->profile_image));
            }
        }

        $teacher->update($data);
        
        // Also update user name if changed
        $user->update(['name' => $request->name]);

        return back()->with('success', 'Profile updated successfully.');
    }
}
