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
        $notices = Notice::latest()->take(5)->get();
        
        return view('teacher.dashboard', compact('batchCount', 'examCount', 'notices'));
    }

    public function batches()
    {
        $teacher = \App\Models\Teacher::where('email', auth()->user()->email)->first();
        $batches = $teacher ? $teacher->batches()->with('course')->get() : [];
        return view('teacher.batches.index', compact('batches'));
    }

    public function exams()
    {
        $exams = Exam::with(['course', 'batch'])->latest()->get();
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
}
