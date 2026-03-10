@extends('layouts.coaching')

@section('content')
<div class="mb-4 animate__animated animate__fadeIn">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('coaching.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('coaching.courses.index') }}" class="text-decoration-none">Courses</a></li>
            <li class="breadcrumb-item active">Edit Course</li>
        </ol>
    </nav>
    <h2 class="fw-bold">Update Course Details</h2>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('coaching.courses.update', $course) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="name" class="form-label fw-bold small text-uppercase text-secondary">Course Title <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control form-control-lg border-0 bg-light rounded-4 @error('name') is-invalid @enderror" value="{{ old('name', $course->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label for="amount" class="form-label fw-bold small text-uppercase text-secondary">Course Fee (₹) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text border-0 bg-light rounded-start-4">₹</span>
                                <input type="number" step="0.01" name="amount" id="amount" class="form-control form-control-lg border-0 bg-light rounded-end-4 @error('amount') is-invalid @enderror" value="{{ old('amount', $course->amount) }}" required>
                            </div>
                            @error('amount')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-5">
                        <label for="description" class="form-label fw-bold small text-uppercase text-secondary">Course Syllabus/Description</label>
                        <textarea name="description" id="description" rows="5" class="form-control border-0 bg-light rounded-4 @error('description') is-invalid @enderror">{{ old('description', $course->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-3">
                        <a href="{{ route('coaching.courses.index') }}" class="btn btn-light px-4 py-2 rounded-4 fw-bold border">Back</a>
                        <button type="submit" class="btn btn-primary px-5 py-2 rounded-4 fw-bold shadow">
                            <i class="fas fa-sync-alt me-2"></i> Update Course
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
