<?php

namespace App\Http\Controllers\CoachingAdmin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Batch;
use App\Models\Course;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::latest()->get();
        return view('coaching.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $batches = Batch::all();
        $courses = Course::all();
        return view('coaching.students.create', compact('batches', 'courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:mysql.users,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'course_id' => 'nullable|exists:tenant.courses,id',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $coachingId = auth()->user()->coaching_id;
        if (!$coachingId) {
            $coaching = \App\Models\Coaching::where('email', auth()->user()->email)->first();
            $coachingId = $coaching->id ?? null;
        }

        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('student@123'),
            'role' => 'student',
            'coaching_id' => $coachingId,
        ]);

        $data = $request->except('batches');
        
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/students');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $imageName);
            $data['profile_image'] = 'uploads/students/' . $imageName;
        }

        $student = Student::create($data);
        
        if ($request->has('batches')) {
            $student->batches()->sync($request->batches);
        }

        return redirect()->route('coaching.students.index')->with('success', 'Student added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return view('coaching.students.show', compact('student'));
    }

    /**
     * Display the student ID card.
     */
    public function idCard(Student $student)
    {
        $coaching = auth()->user()->coaching ?? \App\Models\Coaching::where('email', auth()->user()->email)->first();
        $student->load(['course', 'batches']);
        return view('coaching.students.id_card', compact('student', 'coaching'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $batches = Batch::all();
        $courses = Course::all();
        $selectedBatches = $student->batches()->pluck('batches.id')->toArray();
        return view('coaching.students.edit', compact('student', 'batches', 'courses', 'selectedBatches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'course_id' => 'nullable|exists:tenant.courses,id',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('batches');

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/students');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $imageName);
            $data['profile_image'] = 'uploads/students/' . $imageName;

            // Delete old image
            if ($student->profile_image && file_exists(public_path($student->profile_image))) {
                @unlink(public_path($student->profile_image));
            }
        }

        $student->update($data);

        if ($request->has('batches')) {
            $student->batches()->sync($request->batches);
        } else {
            $student->batches()->detach();
        }

        return redirect()->route('coaching.students.index')->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        if ($student->email) {
            \App\Models\User::where('email', $student->email)->delete();
        }
        if ($student->profile_image && file_exists(public_path($student->profile_image))) {
            @unlink(public_path($student->profile_image));
        }
        $student->delete();
        return back()->with('success', 'Student removed successfully.');
    }
}
