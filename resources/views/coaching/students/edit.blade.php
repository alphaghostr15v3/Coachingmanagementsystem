@extends('layouts.coaching')

@section('content')
<div class="mb-4 animate__animated animate__fadeIn">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('coaching.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('coaching.students.index') }}" class="text-decoration-none">Students</a></li>
            <li class="breadcrumb-item active">Edit Student</li>
        </ol>
    </nav>
    <h2 class="fw-bold">Update Student Profile</h2>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('coaching.students.update', $student) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-bold small text-uppercase text-secondary">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control form-control-lg border-0 bg-light rounded-4 @error('name') is-invalid @enderror" value="{{ old('name', $student->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-bold small text-uppercase text-secondary">Email Address</label>
                            <input type="email" name="email" id="email" class="form-control form-control-lg border-0 bg-light rounded-4 @error('email') is-invalid @enderror" value="{{ old('email', $student->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-bold small text-uppercase text-secondary">Phone Number</label>
                            <input type="text" name="phone" id="phone" class="form-control form-control-lg border-0 bg-light rounded-4 @error('phone') is-invalid @enderror" value="{{ old('phone', $student->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-secondary">Enrolled Batches</label>
                            <div class="bg-light rounded-4 p-3 border-0" style="max-height: 150px; overflow-y: auto;">
                                @foreach($batches as $batch)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="batches[]" value="{{ $batch->id }}" id="batch{{ $batch->id }}" 
                                        {{ in_array($batch->id, $selectedBatches) ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="batch{{ $batch->id }}">
                                        {{ $batch->name }} ({{ $batch->course->name ?? 'General' }})
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label for="address" class="form-label fw-bold small text-uppercase text-secondary">Residential Address</label>
                        <textarea name="address" id="address" rows="4" class="form-control border-0 bg-light rounded-4 @error('address') is-invalid @enderror">{{ old('address', $student->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-3">
                        <a href="{{ route('coaching.students.index') }}" class="btn btn-light px-4 py-2 rounded-4 fw-bold border">Back</a>
                        <button type="submit" class="btn btn-primary px-5 py-2 rounded-4 fw-bold shadow">
                            <i class="fas fa-sync-alt me-2"></i> Update Profile
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
