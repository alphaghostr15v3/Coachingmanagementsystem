@extends('layouts.teacher')

@section('content')
<div class="mb-4 animate__animated animate__fadeIn">
    <h2 class="fw-bold">Exam Results & Marks</h2>
    <p class="text-muted">View student performance for your assigned exams.</p>
</div>

<div class="card border-0 shadow-sm mb-4 animate__animated animate__fadeIn">
    <div class="card-body p-4">
        <form action="{{ route('teacher.marks.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label small fw-bold text-uppercase text-secondary">Select Exam</label>
                <select name="exam_id" class="form-select border-0 bg-light rounded-3 shadow-none fw-bold" required>
                    <option value="">Choose Exam...</option>
                    @foreach($exams as $exam)
                        <option value="{{ $exam->id }}" {{ request('exam_id') == $exam->id ? 'selected' : '' }}>
                            {{ $exam->name }} ({{ date('d M', strtotime($exam->date)) }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label small fw-bold text-uppercase text-secondary">Select Batch</label>
                <select name="batch_id" class="form-select border-0 bg-light rounded-3 shadow-none fw-bold" required>
                    <option value="">Choose Batch...</option>
                    @foreach($batches as $batch)
                        <option value="{{ $batch->id }}" {{ request('batch_id') == $batch->id ? 'selected' : '' }}>
                            {{ $batch->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold shadow-sm py-2">
                    <i class="fas fa-filter me-2"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

@if(request('exam_id') && request('batch_id'))
<div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
    <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="fw-bold m-0">{{ $selectedExam->name }}</h5>
            <span class="text-muted small">Batch: {{ $selectedBatch->name }}</span>
        </div>
        <a href="{{ route('teacher.marks.create', ['exam_id' => request('exam_id'), 'batch_id' => request('batch_id')]) }}" class="btn btn-success px-4 rounded-pill fw-bold shadow-sm">
            <i class="fas fa-plus me-2"></i> Update/Enter Marks
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th width="80" class="ps-4 py-3 text-secondary small text-uppercase">#</th>
                        <th class="py-3 text-secondary small text-uppercase">Student Name</th>
                        <th class="py-3 text-secondary small text-uppercase text-center">Marks Obtained</th>
                        <th class="pe-4 py-3 text-secondary small text-uppercase text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                    <tr>
                        <td class="ps-4 py-3 text-secondary">{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-soft-primary p-2 rounded-circle text-primary me-2 shadow-none" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <span class="fw-bold text-dark">{{ $student->name }}</span>
                            </div>
                        </td>
                        <td class="text-center">
                            @if(isset($marks[$student->id]))
                                <span class="fs-5 fw-bold text-primary">{{ $marks[$student->id]->marks_obtained }}</span> <small class="text-muted">/ 100</small>
                            @else
                                <span class="text-muted fw-bold">-</span>
                            @endif
                        </td>
                        <td class="pe-4 text-center">
                            @if(isset($marks[$student->id]))
                                <span class="badge bg-soft-success text-success px-3 py-2 rounded-pill small fw-bold">
                                    <i class="fas fa-check-circle me-1"></i> Graded
                                </span>
                            @else
                                <span class="badge bg-soft-warning text-warning px-3 py-2 rounded-pill small fw-bold">
                                    <i class="fas fa-clock me-1"></i> Pending
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">No students found in this batch.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

<style>
    .bg-soft-primary { background: rgba(79, 70, 229, 0.1); }
    .bg-soft-success { background: rgba(16, 185, 129, 0.1); }
    .bg-soft-warning { background: rgba(245, 158, 11, 0.1); }
</style>
@endsection
