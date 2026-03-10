@extends('layouts.coaching')

@section('content')
<div class="mb-4 animate__animated animate__fadeIn">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('coaching.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('coaching.batches.index') }}" class="text-decoration-none">Batches</a></li>
            <li class="breadcrumb-item active">Edit Batch</li>
        </ol>
    </nav>
    <h2 class="fw-bold">Modify Batch Settings</h2>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('coaching.batches.update', $batch) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label for="course_id" class="form-label fw-bold small text-uppercase text-secondary">Associated Course <span class="text-danger">*</span></label>
                            <select name="course_id" id="course_id" class="form-select form-select-lg border-0 bg-light rounded-4 @error('course_id') is-invalid @enderror" required>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ old('course_id', $batch->course_id) == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                                @endforeach
                            </select>
                            @error('course_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="teacher_id" class="form-label fw-bold small text-uppercase text-secondary">Assigned Teacher</label>
                            <select name="teacher_id" id="teacher_id" class="form-select form-select-lg border-0 bg-light rounded-4 @error('teacher_id') is-invalid @enderror">
                                <option value="">Select Teacher</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ old('teacher_id', $batch->teacher_id) == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }} ({{ $teacher->subject ?? 'General' }})</option>
                                @endforeach
                            </select>
                            @error('teacher_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="name" class="form-label fw-bold small text-uppercase text-secondary">Batch Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control form-control-lg border-0 bg-light rounded-4 @error('name') is-invalid @enderror" value="{{ old('name', $batch->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="timing" class="form-label fw-bold small text-uppercase text-secondary">Class Timing / Schedule</label>
                        <input type="text" name="timing" id="timing" class="form-control form-control-lg border-0 bg-light rounded-4 @error('timing') is-invalid @enderror" value="{{ old('timing', $batch->timing) }}">
                        @error('timing')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-3">
                        <a href="{{ route('coaching.batches.index') }}" class="btn btn-light px-4 py-2 rounded-4 fw-bold border">Back</a>
                        <button type="submit" class="btn btn-primary px-5 py-2 rounded-4 fw-bold shadow">
                            <i class="fas fa-sync-alt me-2"></i> Update Batch
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
