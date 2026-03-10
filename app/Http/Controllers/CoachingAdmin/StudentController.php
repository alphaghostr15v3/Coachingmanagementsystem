<?php

namespace App\Http\Controllers\CoachingAdmin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Batch;
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
        return view('coaching.students.create', compact('batches'));
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
        ]);

        $coachingId = auth()->user()->coaching_id;
        if (!$coachingId) {
            $coaching = \App\Models\Coaching::where('email', auth()->user()->email)->first();
            $coachingId = $coaching->id ?? null;
        }

        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('password123'),
            'role' => 'student',
            'coaching_id' => $coachingId,
        ]);

        $student = Student::create($request->all());
        
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
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $batches = Batch::all();
        $selectedBatches = $student->batches()->pluck('batches.id')->toArray();
        return view('coaching.students.edit', compact('student', 'batches', 'selectedBatches'));
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
        ]);

        $student->update($request->all());

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
        $student->delete();
        return back()->with('success', 'Student removed successfully.');
    }
}
