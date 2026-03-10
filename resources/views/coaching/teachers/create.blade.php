@extends('layouts.coaching')

@section('content')
<div class="mb-4 animate__animated animate__fadeIn">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('coaching.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('coaching.teachers.index') }}" class="text-decoration-none">Teachers</a></li>
            <li class="breadcrumb-item active">Add Teacher</li>
        </ol>
    </nav>
    <h2 class="fw-bold">Register New Faculty</h2>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('coaching.teachers.store') }}" method="POST">
                    @csrf
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-bold small text-uppercase text-secondary">Teacher Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control form-control-lg border-0 bg-light rounded-4 @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="e.g. Prof. Robert Fox">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-bold small text-uppercase text-secondary">Work Email</label>
                            <input type="email" name="email" id="email" class="form-control form-control-lg border-0 bg-light rounded-4 @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="teacher@coaching.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-bold small text-uppercase text-secondary">Contact Number</label>
                            <input type="text" name="phone" id="phone" class="form-control form-control-lg border-0 bg-light rounded-4 @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="Enter mobile number">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="subject" class="form-label fw-bold small text-uppercase text-secondary">Subject Specialization</label>
                            <input type="text" name="subject" id="subject" class="form-control form-control-lg border-0 bg-light rounded-4 @error('subject') is-invalid @enderror" value="{{ old('subject') }}" placeholder="e.g. Higher Mathematics">
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-5">
                        <a href="{{ route('coaching.teachers.index') }}" class="btn btn-light px-4 py-2 rounded-4 fw-bold border">Cancel</a>
                        <button type="submit" class="btn btn-primary px-5 py-2 rounded-4 fw-bold shadow">
                            <i class="fas fa-save me-2"></i> Save Faculty Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        background: #fff !important;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        border: 1px solid var(--primary-color) !important;
    }
</style>
@endsection
