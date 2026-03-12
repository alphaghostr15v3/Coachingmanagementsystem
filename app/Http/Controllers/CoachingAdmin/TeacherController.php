<?php

namespace App\Http\Controllers\CoachingAdmin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::with(['department', 'designation'])->latest()->get();
        return view('coaching.teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = \App\Models\Department::all();
        $designations = \App\Models\Designation::all();
        return view('coaching.teachers.create', compact('departments', 'designations'));
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
            'subject' => 'nullable|string|max:255',
            'department_id' => 'nullable|exists:tenant.departments,id',
            'designation_id' => 'nullable|exists:tenant.designations,id',
            'qualification' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
            'joining_date' => 'nullable|date',
            'staff_type' => 'required|string|in:Teaching,Non-Teaching',
            'status' => 'required|string|in:Active,Inactive',
        ]);

        $coachingId = auth()->user()->coaching_id;
        if (!$coachingId) {
            $coaching = \App\Models\Coaching::where('email', auth()->user()->email)->first();
            $coachingId = $coaching->id ?? null;
        }

        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('teacher@123'),
            'role' => 'teacher',
            'coaching_id' => $coachingId,
        ]);

        Teacher::create($request->all());

        return redirect()->route('coaching.teachers.index')->with('success', 'Teacher added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        return view('coaching.teachers.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        $departments = \App\Models\Department::all();
        $designations = \App\Models\Designation::all();
        return view('coaching.teachers.edit', compact('teacher', 'departments', 'designations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'department_id' => 'nullable|exists:tenant.departments,id',
            'designation_id' => 'nullable|exists:tenant.designations,id',
            'qualification' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
            'joining_date' => 'nullable|date',
            'staff_type' => 'required|string|in:Teaching,Non-Teaching',
            'status' => 'required|string|in:Active,Inactive',
        ]);

        $teacher->update($request->all());

        return redirect()->route('coaching.teachers.index')->with('success', 'Teacher updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        if ($teacher->email) {
            \App\Models\User::where('email', $teacher->email)->delete();
        }
        $teacher->delete();
        return back()->with('success', 'Teacher removed successfully.');
    }
}
