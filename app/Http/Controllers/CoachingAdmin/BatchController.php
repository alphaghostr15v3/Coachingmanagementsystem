<?php

namespace App\Http\Controllers\CoachingAdmin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $batches = Batch::with(['course', 'teacher'])->latest()->get();
        return view('coaching.batches.index', compact('batches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        $teachers = Teacher::all();
        return view('coaching.batches.create', compact('courses', 'teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:tenant.courses,id',
            'teacher_id' => 'nullable|exists:tenant.teachers,id',
            'name' => 'required|string|max:255',
            'timing' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'class_time' => 'nullable',
        ]);

        Batch::create($request->all());

        return redirect()->route('coaching.batches.index')->with('success', 'Batch created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Batch $batch)
    {
        return view('coaching.batches.show', compact('batch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Batch $batch)
    {
        $courses = Course::all();
        $teachers = Teacher::all();
        return view('coaching.batches.edit', compact('batch', 'courses', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Batch $batch)
    {
        $request->validate([
            'course_id' => 'required|exists:tenant.courses,id',
            'teacher_id' => 'nullable|exists:tenant.teachers,id',
            'name' => 'required|string|max:255',
            'timing' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'class_time' => 'nullable',
        ]);

        $batch->update($request->all());

        return redirect()->route('coaching.batches.index')->with('success', 'Batch updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Batch $batch)
    {
        $batch->delete();
        return back()->with('success', 'Batch deleted successfully.');
    }
}
