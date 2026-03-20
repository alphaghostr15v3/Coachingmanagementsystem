@extends('layouts.coaching')

@section('content')
<div class="mb-4 animate__animated animate__fadeIn">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('coaching.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('coaching.teachers.index') }}" class="text-decoration-none">Teachers</a></li>
            <li class="breadcrumb-item active">Edit Teacher</li>
        </ol>
    </nav>
    <h2 class="fw-bold">Modify Teacher Profile</h2>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('coaching.teachers.update', $teacher) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-4 mb-4">
                        <div class="col-md-4 animate__animated animate__fadeInUp" style="animation-delay: 0.1s">
                            <label for="name" class="form-label fw-bold small text-uppercase text-secondary">Teacher Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control form-control-lg border-0 bg-light rounded-4 @error('name') is-invalid @enderror" value="{{ old('name', $teacher->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4 animate__animated animate__fadeInUp" style="animation-delay: 0.2s">
                            <label for="email" class="form-label fw-bold small text-uppercase text-secondary">Work Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="form-control form-control-lg border-0 bg-light rounded-4 @error('email') is-invalid @enderror" value="{{ old('email', $teacher->email) }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4 animate__animated animate__fadeInUp" style="animation-delay: 0.3s">
                            <label for="phone" class="form-label fw-bold small text-uppercase text-secondary">Contact Number</label>
                            <input type="text" name="phone" id="phone" class="form-control form-control-lg border-0 bg-light rounded-4 @error('phone') is-invalid @enderror" value="{{ old('phone', $teacher->phone) }}">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-4 animate__animated animate__fadeInUp" style="animation-delay: 0.4s">
                            <label for="department_id" class="form-label fw-bold small text-uppercase text-secondary">Department</label>
                            <select name="department_id" id="department_id" class="form-select form-select-lg border-0 bg-light rounded-4">
                                <option value="">Select Department</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ old('department_id', $teacher->department_id) == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 animate__animated animate__fadeInUp" style="animation-delay: 0.5s">
                            <label for="designation_id" class="form-label fw-bold small text-uppercase text-secondary">Designation</label>
                            <select name="designation_id" id="designation_id" class="form-select form-select-lg border-0 bg-light rounded-4">
                                <option value="">Select Designation</option>
                                @foreach($designations as $desig)
                                    <option value="{{ $desig->id }}" {{ old('designation_id', $teacher->designation_id) == $desig->id ? 'selected' : '' }}>{{ $desig->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 animate__animated animate__fadeInUp" style="animation-delay: 0.6s">
                            <label for="subject" class="form-label fw-bold small text-uppercase text-secondary">Primary Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control form-control-lg border-0 bg-light rounded-4 @error('subject') is-invalid @enderror" value="{{ old('subject', $teacher->subject) }}">
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label for="qualification" class="form-label fw-bold small text-uppercase text-secondary">Qualification</label>
                            <input type="text" name="qualification" id="qualification" class="form-control form-control-lg border-0 bg-light rounded-4" value="{{ old('qualification', $teacher->qualification) }}">
                        </div>
                        <div class="col-md-6">
                            <label for="experience" class="form-label fw-bold small text-uppercase text-secondary">Experience</label>
                            <input type="text" name="experience" id="experience" class="form-control form-control-lg border-0 bg-light rounded-4" value="{{ old('experience', $teacher->experience) }}">
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-4">
                            <label for="joining_date" class="form-label fw-bold small text-uppercase text-secondary">Joining Date</label>
                            <input type="date" name="joining_date" id="joining_date" class="form-control form-control-lg border-0 bg-light rounded-4" value="{{ old('joining_date', $teacher->joining_date) }}">
                        </div>
                        <div class="col-md-8">
                            <label for="address" class="form-label fw-bold small text-uppercase text-secondary">Residential Address</label>
                            <input type="text" name="address" id="address" class="form-control form-control-lg border-0 bg-light rounded-4 @error('address') is-invalid @enderror" value="{{ old('address', $teacher->address) }}" placeholder="e.g. 123 Education St, Knowledge City">
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="status" class="form-label fw-bold small text-uppercase text-secondary">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select form-select-lg border-0 bg-light rounded-4" required>
                                <option value="Active" {{ old('status', $teacher->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ old('status', $teacher->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-12 animate__animated animate__fadeInUp" style="animation-delay: 1.1s">
                            <label for="profile_image" class="form-label fw-bold small text-uppercase text-secondary">Profile Image</label>
                            @if($teacher->profile_image)
                                <div class="mb-2">
                                    <img src="{{ asset($teacher->profile_image) }}" alt="{{ $teacher->name }}" class="rounded-4 shadow-sm profile-img-hover" style="width: 100px; height: 100px; object-fit: cover;">
                                </div>
                            @endif
                            <input type="file" name="profile_image" id="profile_image" class="form-control border-0 bg-light rounded-4 @error('profile_image') is-invalid @enderror">
                            @error('profile_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-5">
                        <a href="{{ route('coaching.teachers.index') }}" class="btn btn-light px-4 py-2 rounded-4 fw-bold border">Back</a>
                        <button type="submit" class="btn btn-primary px-5 py-2 rounded-4 fw-bold shadow">
                            <i class="fas fa-sync-alt me-2"></i> Update Teacher
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

@push('styles')
<style>
    .profile-img-hover { transition: transform 0.3s ease; }
    .profile-img-hover:hover { transform: scale(1.05); cursor: pointer; }
</style>
@endpush
