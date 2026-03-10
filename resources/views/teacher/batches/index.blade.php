@extends('layouts.teacher')

@section('content')
<div class="mb-4 animate__animated animate__fadeIn">
    <h2 class="fw-bold">My Assigned Batches</h2>
    <p class="text-muted">List of all batches you are currently teaching.</p>
</div>

<div class="row g-4 animate__animated animate__fadeInUp">
    @foreach($batches as $batch)
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100 p-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="bg-soft-primary p-3 rounded-4 text-primary">
                    <i class="fas fa-layer-group fs-4"></i>
                </div>
                <span class="badge bg-soft-success text-success rounded-pill px-3 py-2 small">Active</span>
            </div>
            <h5 class="fw-bold mb-1">{{ $batch->name }}</h5>
            <p class="text-primary small fw-bold mb-3">{{ $batch->course->name ?? 'General Course' }}</p>
            
            <div class="d-flex align-items-center text-muted small mb-4">
                <i class="far fa-clock me-2"></i> {{ $batch->timings ?? 'Morning Batch' }}
            </div>

            <div class="d-grid gap-2">
                <a href="{{ route('teacher.attendance.create', ['batch_id' => $batch->id]) }}" class="btn btn-primary rounded-pill fw-bold">
                    <i class="fas fa-calendar-plus me-2"></i> Mark Attendance
                </a>
                <a href="{{ route('teacher.students', ['batch_id' => $batch->id]) }}" class="btn btn-light rounded-pill fw-bold text-secondary border">
                    <i class="fas fa-users me-2"></i> Student List
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>

<style>
    .bg-soft-primary { background: rgba(79, 70, 229, 0.1); }
    .bg-soft-success { background: rgba(16, 185, 129, 0.1); }
</style>
@endsection
