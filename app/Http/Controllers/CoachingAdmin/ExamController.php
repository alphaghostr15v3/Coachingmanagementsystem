<?php

namespace App\Http\Controllers\CoachingAdmin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Course;
use App\Models\Batch;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::with(['course', 'batch'])->latest()->get();
        return view('coaching.exams.index', compact('exams'));
    }

    public function create()
    {
        $courses = Course::all();
        $batches = Batch::all();
        return view('coaching.exams.create', compact('courses', 'batches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:tenant.courses,id',
            'batch_id' => 'nullable|exists:tenant.batches,id',
            'name' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        Exam::create($request->all());

        return redirect()->route('coaching.exams.index')->with('success', 'Exam scheduled successfully.');
    }

    public function edit(Exam $exam)
    {
        $courses = Course::all();
        $batches = Batch::all();
        return view('coaching.exams.edit', compact('exam', 'courses', 'batches'));
    }

    public function update(Request $request, Exam $exam)
    {
        $request->validate([
            'course_id' => 'required|exists:tenant.courses,id',
            'batch_id' => 'nullable|exists:tenant.batches,id',
            'name' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        $exam->update($request->all());

        return redirect()->route('coaching.exams.index')->with('success', 'Exam updated successfully.');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return back()->with('success', 'Exam deleted successfully.');
    }
}
