@extends('layouts.student')

@section('content')
<div class="mb-4 animate__animated animate__fadeIn">
    <h2 class="fw-bold">My Academic Results</h2>
    <p class="text-muted">Detailed performance marks for all examinations.</p>
</div>

<div class="row g-4 animate__animated animate__fadeInUp">
    @forelse($marks as $mark)
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100 p-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="bg-soft-info p-3 rounded-4 text-info">
                    <i class="fas fa-poll fs-4"></i>
                </div>
                <div class="text-end">
                    <span class="text-secondary smaller d-block">{{ date('d M, Y', strtotime($mark->exam->date ?? now())) }}</span>
                    <span class="badge bg-soft-primary text-primary rounded-pill small">Regular Exam</span>
                </div>
            </div>
            
            <h5 class="fw-bold mb-1">{{ $mark->exam->name ?? 'Examination' }}</h5>
            <p class="text-muted small mb-4">Course: {{ $mark->exam->course->name ?? 'General' }}</p>

            <div class="bg-light p-3 rounded-4 mb-3 text-center">
                <h2 class="fw-bold text-primary mb-0">{{ $mark->marks_obtained }}</h2>
                <div class="text-secondary smaller fw-bold text-uppercase">Score / 100</div>
            </div>

            <div class="progress rounded-pill mb-3" style="height: 10px;">
                <div class="progress-bar bg-info" role="progressbar" style="width: {{ $mark->marks_obtained }}%"></div>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <span class="text-secondary small">Grade: <span class="fw-bold text-dark">{{ $mark->grade }}</span></span>
                <span class="text-{{ $mark->grade_color }} fw-bold small">
                    {{ $mark->marks_obtained >= 33 ? 'QUALIFIED' : 'FAILED' }}
                </span>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <h5 class="text-muted">No marks records available yet.</h5>
    </div>
    @endforelse
</div>

<style>
    .bg-soft-info { background: rgba(14, 165, 233, 0.1); }
    .bg-soft-primary { background: rgba(79, 70, 229, 0.1); }
    .progress-bar { background: linear-gradient(to right, #0ea5e9, #2dd4bf); }
</style>
@endsection
