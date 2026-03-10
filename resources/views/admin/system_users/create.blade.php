@extends('layouts.admin')

@section('content')
<div class="mb-4 animate__animated animate__fadeIn">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-indigo">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.system-users.index') }}" class="text-decoration-none text-indigo">System Users</a></li>
            <li class="breadcrumb-item active">New Registration</li>
        </ol>
    </nav>
    <h2 class="fw-bold">Global User Registration</h2>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('admin.system-users.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="coaching_id" class="form-label fw-bold small text-uppercase text-secondary">Target Institute (Coaching) <span class="text-danger">*</span></label>
                        <select name="coaching_id" id="coaching_id" class="form-select form-select-lg border-0 bg-light rounded-4 @error('coaching_id') is-invalid @enderror" required>
                            <option value="">Select Institute...</option>
                            @foreach($coachings as $coaching)
                                <option value="{{ $coaching->id }}" {{ old('coaching_id') == $coaching->id ? 'selected' : '' }}>{{ $coaching->coaching_name }}</option>
                            @endforeach
                        </select>
                        @error('coaching_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="role" class="form-label fw-bold small text-uppercase text-secondary">Administrative Role <span class="text-danger">*</span></label>
                        <div class="d-flex gap-4">
                            <div class="form-check custom-option w-50">
                                <input class="form-check-input d-none" type="radio" name="role" id="role_student" value="student" {{ old('role', 'student') == 'student' ? 'checked' : '' }} onchange="toggleFields()">
                                <label class="form-check-label px-4 py-3 rounded-4 border w-100 text-center cursor-pointer" for="role_student">
                                    <i class="fas fa-user-graduate d-block mb-2 fs-4"></i>
                                    <span class="fw-bold">Student</span>
                                </label>
                            </div>
                            <div class="form-check custom-option w-50">
                                <input class="form-check-input d-none" type="radio" name="role" id="role_teacher" value="teacher" {{ old('role') == 'teacher' ? 'checked' : '' }} onchange="toggleFields()">
                                <label class="form-check-label px-4 py-3 rounded-4 border w-100 text-center cursor-pointer" for="role_teacher">
                                    <i class="fas fa-chalkboard-teacher d-block mb-2 fs-4"></i>
                                    <span class="fw-bold">Teacher</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-bold small text-uppercase text-secondary">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control form-control-lg border-0 bg-light rounded-4 @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="e.g. Aman Gupta">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-bold small text-uppercase text-secondary">Phone Number</label>
                            <input type="text" name="phone" id="phone" class="form-control form-control-lg border-0 bg-light rounded-4 @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="e.g. +91 9876543210">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label fw-bold small text-uppercase text-secondary">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control form-control-lg border-0 bg-light rounded-4 @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="aman@example.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div id="student_fields" class="mb-4">
                        <label for="address" class="form-label fw-bold small text-uppercase text-secondary">Home Address</label>
                        <textarea name="address" id="address" rows="2" class="form-control form-control-lg border-0 bg-light rounded-4 @error('address') is-invalid @enderror" placeholder="Enter complete address">{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div id="teacher_fields" class="mb-4" style="display: none;">
                        <label for="subject" class="form-label fw-bold small text-uppercase text-secondary">Expertise / Subject</label>
                        <input type="text" name="subject" id="subject" class="form-control form-control-lg border-0 bg-light rounded-4 @error('subject') is-invalid @enderror" value="{{ old('subject') }}" placeholder="e.g. Mathematics, Physics">
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <label for="password" class="form-label fw-bold small text-uppercase text-secondary">Temporary Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" id="password" class="form-control form-control-lg border-0 bg-light rounded-4 @error('password') is-invalid @enderror" required placeholder="••••••••">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label fw-bold small text-uppercase text-secondary">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-lg border-0 bg-light rounded-4" required placeholder="••••••••">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                        <a href="{{ route('admin.system-users.index') }}" class="btn btn-light px-4 py-3 rounded-4 fw-bold border-0 shadow-sm text-secondary">Cancel</a>
                        <button type="submit" class="btn btn-gradient px-5 py-3 rounded-4 fw-bold shadow-lg">
                            <i class="fas fa-user-plus me-2"></i> Deploy User Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .text-indigo { color: #4f46e5; }
    .form-control:focus, .form-select:focus {
        background: #fff !important;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
    }
    .custom-option input:checked + label {
        border-color: #4f46e5 !important;
        background: rgba(79, 70, 229, 0.05);
        color: #4f46e5;
    }
    .cursor-pointer { cursor: pointer; }
</style>

<script>
    function toggleFields() {
        const role = document.querySelector('input[name="role"]:checked').value;
        const studentFields = document.getElementById('student_fields');
        const teacherFields = document.getElementById('teacher_fields');

        if (role === 'student') {
            studentFields.style.display = 'block';
            teacherFields.style.display = 'none';
        } else {
            studentFields.style.display = 'none';
            teacherFields.style.display = 'block';
        }
    }

    // Initialize on load
    document.addEventListener('DOMContentLoaded', toggleFields);
</script>
@endsection

