<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Mark;
use App\Models\Student;
use App\Models\Batch;
use App\Models\Teacher;
use Illuminate\Http\Request;

class MarkController extends Controller
{
    public function index(Request $request)
    {
        $teacher = Teacher::where('email', auth()->user()->email)->first();
        if (!$teacher) {
            return redirect()->route('teacher.dashboard')->with('error', 'Teacher record not found.');
        }

        $batches = $teacher->batches;
        $batchIds = $batches->pluck('id')->toArray();
        $exams = Exam::whereIn('batch_id', $batchIds)->get();
        
        $exam_id = $request->exam_id;
        $batch_id = $request->batch_id;
        
        $marks = [];
        $selectedExam = null;
        $selectedBatch = null;

        if ($exam_id && $batch_id) {
            $selectedExam = Exam::findOrFail($exam_id);
            $selectedBatch = Batch::findOrFail($batch_id);
            
            // Ensure teacher has access to this batch
            if (!in_array($batch_id, $batchIds)) {
                return back()->with('error', 'Unauthorized access to this batch.');
            }

            $students = $selectedBatch->students;
            $marks = Mark::where('exam_id', $exam_id)->get()->keyBy('student_id');
            
            return view('teacher.marks.index', compact('exams', 'batches', 'marks', 'selectedExam', 'selectedBatch', 'students'));
        }

        return view('teacher.marks.index', compact('exams', 'batches', 'marks'));
    }

    public function create(Request $request)
    {
        $teacher = Teacher::where('email', auth()->user()->email)->first();
        if (!$teacher) {
            return redirect()->route('teacher.dashboard')->with('error', 'Teacher record not found.');
        }

        $batchIds = $teacher->batches()->pluck('id')->toArray();
        
        $exam = Exam::findOrFail($request->exam_id);
        $batch = Batch::findOrFail($request->batch_id);
        
        // Ensure teacher has access to this batch
        if (!in_array($batch->id, $batchIds)) {
            return back()->with('error', 'Unauthorized access to this batch.');
        }

        $students = $batch->students; 
        $existing_marks = Mark::where('exam_id', $exam->id)->get()->keyBy('student_id');

        return view('teacher.marks.create', compact('exam', 'batch', 'students', 'existing_marks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:tenant.exams,id',
            'marks' => 'required|array',
        ]);

        foreach ($request->marks as $student_id => $marks_obtained) {
            // Validate that the student is in the batch associated with the exam
            // (Optional but good for security)
            
            Mark::updateOrCreate(
                ['exam_id' => $request->exam_id, 'student_id' => $student_id],
                ['marks_obtained' => $marks_obtained]
            );
        }

        return redirect()->route('teacher.marks.index', [
            'exam_id' => $request->exam_id,
            'batch_id' => Exam::find($request->exam_id)->batch_id
        ])->with('success', 'Marks updated successfully.');
    }
}
