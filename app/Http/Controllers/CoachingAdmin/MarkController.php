<?php

namespace App\Http\Controllers\CoachingAdmin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Mark;
use App\Models\Student;
use App\Models\Batch;
use Illuminate\Http\Request;

class MarkController extends Controller
{
    public function index(Request $request)
    {
        $exams = Exam::all();
        $batches = Batch::all();
        
        $exam_id = $request->exam_id;
        $batch_id = $request->batch_id;
        
        $marks = [];
        if ($exam_id && $batch_id) {
            $students = Student::all(); // Simple for now, ideally filtered by batch
            $marks = Mark::where('exam_id', $exam_id)->get()->keyBy('student_id');
        }

        return view('coaching.marks.index', compact('exams', 'batches', 'marks'));
    }

    public function create(Request $request)
    {
        $exam = Exam::findOrFail($request->exam_id);
        $batch = Batch::findOrFail($request->batch_id);
        
        // Find students in this batch (Assuming student belongs to batch logic exists or we just show all for now)
        $students = Student::all(); 
        
        $existing_marks = Mark::where('exam_id', $exam->id)->get()->keyBy('student_id');

        return view('coaching.marks.create', compact('exam', 'batch', 'students', 'existing_marks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:tenant.exams,id',
            'marks' => 'required|array',
        ]);

        foreach ($request->marks as $student_id => $marks_obtained) {
            Mark::updateOrCreate(
                ['exam_id' => $request->exam_id, 'student_id' => $student_id],
                ['marks_obtained' => $marks_obtained]
            );
        }

        return redirect()->route('coaching.marks.index')->with('success', 'Marks updated successfully.');
    }
}
