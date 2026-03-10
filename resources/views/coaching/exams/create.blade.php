@extends('layouts.coaching')

@section('content')
<div class="mb-4 animate__animated animate__fadeIn">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('coaching.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('coaching.exams.index') }}" class="text-decoration-none">Exams</a></li>
            <li class="breadcrumb-item active">Schedule</li>
        </ol>
    </nav>
    <h2 class="fw-bold">Schedule New Examination</h2>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('coaching.exams.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="form-label fw-bold small text-uppercase text-secondary">Exam Title <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control form-control-lg border-0 bg-light rounded-4 @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="e.g. Monthly Unit Test - Physics">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label for="course_id" class="form-label fw-bold small text-uppercase text-secondary">Course <span class="text-danger">*</span></label>
                            <select name="course_id" id="course_id" class="form-select form-select-lg border-0 bg-light rounded-4 @error('course_id') is-invalid @enderror" required>
                                <option value="">Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                            @error('course_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="batch_id" class="form-label fw-bold small text-uppercase text-secondary">Batch (Optional)</label>
                            <select name="batch_id" id="batch_id" class="form-select form-select-lg border-0 bg-light rounded-4">
                                <option value="">All Batches</option>
                                @foreach($batches as $batch)
                                    <option value="{{ $batch->id }}">{{ $batch->name }} ({{ $batch->course->name ?? '' }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label for="date" class="form-label fw-bold small text-uppercase text-secondary">Examination Date <span class="text-danger">*</span></label>
                        <input type="date" name="date" id="date" class="form-control form-control-lg border-0 bg-light rounded-4 @error('date') is-invalid @enderror" value="{{ old('date', date('Y-m-d')) }}" required>
                        @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                        <a href="{{ route('coaching.exams.index') }}" class="btn btn-light px-4 py-2 rounded-4 fw-bold border">Cancel</a>
                        <button type="submit" class="btn btn-primary px-5 py-2 rounded-4 fw-bold shadow">
                            <i class="fas fa-calendar-plus me-2"></i> Schedule Exam
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
