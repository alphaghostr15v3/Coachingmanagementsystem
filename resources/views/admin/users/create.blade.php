@extends('layouts.admin')

@section('content')
<div class="mb-4 animate__animated animate__fadeIn">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-indigo">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-decoration-none text-indigo">Users</a></li>
            <li class="breadcrumb-item active">Create User</li>
        </ol>
    </nav>
    <h2 class="fw-bold">Create System User</h2>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="name" class="form-label fw-bold small text-uppercase text-secondary">Full Name</label>
                        <input type="text" name="name" id="name" class="form-control form-control-lg border-0 bg-light rounded-4 @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="e.g. Rahul Sharma">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label fw-bold small text-uppercase text-secondary">Email Address</label>
                        <input type="email" name="email" id="email" class="form-control form-control-lg border-0 bg-light rounded-4 @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="rahul@example.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label for="password" class="form-label fw-bold small text-uppercase text-secondary">Password</label>
                            <input type="password" name="password" id="password" class="form-control form-control-lg border-0 bg-light rounded-4 @error('password') is-invalid @enderror" required placeholder="••••••••">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label fw-bold small text-uppercase text-secondary">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-lg border-0 bg-light rounded-4" required placeholder="••••••••">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="role" class="form-label fw-bold small text-uppercase text-secondary">Administrative Role</label>
                        <select name="role" id="role" class="form-select form-select-lg border-0 bg-light rounded-4 @error('role') is-invalid @enderror" required onchange="toggleInstituteFields()">
                            <option value="coaching_admin" {{ old('role') == 'coaching_admin' ? 'selected' : '' }}>Coaching Admin (Institute Level)</option>
                            <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>Super Admin (System Level)</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div id="coaching_details" class="animate__animated animate__fadeIn" style="display: block;">
                        <h5 class="fw-bold mb-3 text-indigo"><i class="fas fa-university me-2"></i> Institute Details</h5>
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label for="coaching_name" class="form-label fw-bold small text-uppercase text-secondary">Institute Name <span class="text-danger">*</span></label>
                                <input type="text" name="coaching_name" id="coaching_name" class="form-control form-control-lg border-0 bg-light rounded-4 @error('coaching_name') is-invalid @enderror" value="{{ old('coaching_name') }}" placeholder="e.g. Excellence Academy">
                                @error('coaching_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="mobile" class="form-label fw-bold small text-uppercase text-secondary">Contact Number</label>
                                <input type="text" name="mobile" id="mobile" class="form-control form-control-lg border-0 bg-light rounded-4 @error('mobile') is-invalid @enderror" value="{{ old('mobile') }}" placeholder="e.g. +91 9876543210">
                                @error('mobile')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <script>
                        function toggleInstituteFields() {
                            const role = document.getElementById('role').value;
                            const coachingSection = document.getElementById('coaching_details');
                            const coachingName = document.getElementById('coaching_name');
                            
                            if (role === 'coaching_admin') {
                                coachingSection.style.display = 'block';
                                coachingName.required = true;
                            } else {
                                coachingSection.style.display = 'none';
                                coachingName.required = false;
                            }
                        }

                        // Initialize on load
                        document.addEventListener('DOMContentLoaded', toggleInstituteFields);
                    </script>

                    <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-light px-4 py-3 rounded-4 fw-bold border-0 shadow-sm text-secondary">Cancel</a>
                        <button type="submit" class="btn btn-gradient px-5 py-3 rounded-4 fw-bold shadow-lg">
                            <i class="fas fa-save me-2"></i> Create User Account
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
</style>
@endsection
