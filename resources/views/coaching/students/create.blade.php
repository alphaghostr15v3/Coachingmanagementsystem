@extends('layouts.coaching')

@section('content')
<div class="mb-4 animate__animated animate__fadeIn">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('coaching.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('coaching.students.index') }}" class="text-decoration-none">Students</a></li>
            <li class="breadcrumb-item active">Add Student</li>
        </ol>
    </nav>
    <h2 class="fw-bold">Register New Student</h2>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('coaching.students.store') }}" method="POST">
                    @csrf
                    <div class="row g-4 mb-4">
                        <div class="col-md-4">
                            <label for="name" class="form-label fw-bold small text-uppercase text-secondary">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control form-control-lg border-0 bg-light rounded-4 @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="e.g. John Doe">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="course_id" class="form-label fw-bold small text-uppercase text-secondary">Select Course</label>
                            <select name="course_id" id="course_id" class="form-select form-select-lg border-0 bg-light rounded-4 @error('course_id') is-invalid @enderror">
                                <option value="">Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                                @endforeach
                            </select>
                            @error('course_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="email" class="form-label fw-bold small text-uppercase text-secondary">Email Address</label>
                            <input type="email" name="email" id="email" class="form-control form-control-lg border-0 bg-light rounded-4 @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="example@email.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-bold small text-uppercase text-secondary">Phone Number</label>
                            <input type="text" name="phone" id="phone" class="form-control form-control-lg border-0 bg-light rounded-4 @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="Enter 10-digit number">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-secondary">Assign Batches</label>
                            <div class="bg-light rounded-4 p-3 border-0" style="max-height: 150px; overflow-y: auto;">
                                @foreach($batches as $batch)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="batches[]" value="{{ $batch->id }}" id="batch{{ $batch->id }}">
                                    <label class="form-check-label small" for="batch{{ $batch->id }}">
                                        {{ $batch->name }} ({{ $batch->course->name ?? 'General' }})
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="row g-4 mb-5">
                        <div class="col-md-8">
                            <label for="address" class="form-label fw-bold small text-uppercase text-secondary">Residential Address</label>
                            <textarea name="address" id="address" rows="4" class="form-control border-0 bg-light rounded-4 @error('address') is-invalid @enderror" placeholder="Enter complete address">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="state" class="form-label fw-bold small text-uppercase text-secondary">
                                State <span class="text-muted fw-normal" style="font-size:0.7rem">(for GST)</span>
                            </label>
                            <select name="state" id="state" class="form-select form-select-lg border-0 bg-light rounded-4 @error('state') is-invalid @enderror">
                                <option value="">Select State</option>
                                @foreach(['Andhra Pradesh','Arunachal Pradesh','Assam','Bihar','Chhattisgarh','Goa','Gujarat','Haryana','Himachal Pradesh','Jharkhand','Karnataka','Kerala','Madhya Pradesh','Maharashtra','Manipur','Meghalaya','Mizoram','Nagaland','Odisha','Punjab','Rajasthan','Sikkim','Tamil Nadu','Telangana','Tripura','Uttar Pradesh','Uttarakhand','West Bengal','Andaman and Nicobar Islands','Chandigarh','Dadra and Nagar Haveli and Daman and Diu','Delhi','Jammu and Kashmir','Ladakh','Lakshadweep','Puducherry'] as $st)
                                    <option value="{{ $st }}" {{ old('state') == $st ? 'selected' : '' }}>{{ $st }}</option>
                                @endforeach
                            </select>
                            @error('state')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3">
                        <a href="{{ route('coaching.students.index') }}" class="btn btn-light px-4 py-2 rounded-4 fw-bold border">Cancel</a>
                        <button type="submit" class="btn btn-primary px-5 py-2 rounded-4 fw-bold shadow">
                            <i class="fas fa-save me-2"></i> Register Student
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm bg-gradient-primary text-white animate__animated animate__fadeInRight">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3"><i class="fas fa-info-circle me-2"></i> Registration Tip</h5>
                <p class="small opacity-75">
                    Ensure the email and phone number are correct to facilitate automated notifications for fees and attendance.
                </p>
                <hr class="bg-white">
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-key me-2"></i>
                    <span class="small">Default password: <strong>student@123</strong></span>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-check-circle me-2"></i>
                    <span class="small">Unique Student ID will be generated</span>
                </div>
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-2"></i>
                    <span class="small">Course mapping available after save</span>
                </div>
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
