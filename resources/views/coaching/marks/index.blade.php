@extends('layouts.coaching')

@section('content')
<div class="mb-4 animate__animated animate__fadeIn">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('coaching.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active">Marks Management</li>
        </ol>
    </nav>
    <h2 class="fw-bold">Student Performance Marks</h2>
</div>

<div class="card border-0 shadow-sm mb-4 animate__animated animate__fadeIn">
    <div class="card-body p-4">
        <form action="{{ route('coaching.marks.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label small fw-bold text-uppercase text-secondary">Select Exam</label>
                <select name="exam_id" class="form-select border-0 bg-light rounded-3" required>
                    <option value="">Choose Exam...</option>
                    @foreach($exams as $exam)
                        <option value="{{ $exam->id }}" {{ request('exam_id') == $exam->id ? 'selected' : '' }}>{{ $exam->name }} ({{ date('d M', strtotime($exam->date)) }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label small fw-bold text-uppercase text-secondary">Select Batch</label>
                <select name="batch_id" class="form-select border-0 bg-light rounded-3" required>
                    <option value="">Choose Batch...</option>
                    @foreach($batches as $batch)
                        <option value="{{ $batch->id }}" {{ request('batch_id') == $batch->id ? 'selected' : '' }}>{{ $batch->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100 rounded-3">
                    <i class="fas fa-filter me-2"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

@if(request('exam_id') && request('batch_id'))
<div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
    <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold m-0">Student List</h5>
        <a href="{{ route('marks.create', ['exam_id' => request('exam_id'), 'batch_id' => request('batch_id')]) }}" class="btn btn-sm btn-success px-3 rounded-pill">
            <i class="fas fa-plus me-1"></i> Update/Enter Marks
        </a>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th width="80" class="text-secondary small text-uppercase">#</th>
                        <th class="text-secondary small text-uppercase">Student Name</th>
                        <th class="text-center text-secondary small text-uppercase">Marks Obtained / 100</th>
                        <th class="text-center text-secondary small text-uppercase">Status</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Logic to loop through students and their marks --}}
                    @php 
                        $students = \App\Models\Student::all(); // Simplified for preview
                    @endphp
                    @foreach($students as $student)
                    <tr>
                        <td class="text-secondary">{{ $loop->iteration }}</td>
                        <td><span class="fw-bold">{{ $student->name }}</span></td>
                        <td class="text-center">
                            <span class="fs-5 fw-bold text-primary">{{ $marks[$student->id]->marks_obtained ?? '-' }}</span>
                        </td>
                        <td class="text-center">
                            @if(isset($marks[$student->id]))
                                <span class="badge bg-soft-success text-success px-3 py-2 rounded-pill small">Graded</span>
                            @else
                                <span class="badge bg-soft-warning text-warning px-3 py-2 rounded-pill small">Pending</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

<style>
    .bg-soft-success { background: rgba(16, 185, 129, 0.1); }
    .bg-soft-warning { background: rgba(245, 158, 11, 0.1); }
</style>
@endsection
