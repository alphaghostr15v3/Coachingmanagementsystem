@extends('layouts.teacher')

@section('content')
<div class="mb-4 animate__animated animate__fadeIn">
    <h2 class="fw-bold">My Profile</h2>
    <p class="text-muted">Manage your personal information and profile picture.</p>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-4 animate__animated animate__fadeInLeft">
            <div class="card-body text-center p-5">
                <div class="mb-4">
                    @if($teacher->profile_image)
                        <img src="{{ asset($teacher->profile_image) }}" alt="{{ $teacher->name }}" class="rounded-circle img-thumbnail shadow-sm" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto shadow-sm" style="width: 150px; height: 150px;">
                            <i class="fas fa-user-tie fa-4x text-secondary"></i>
                        </div>
                    @endif
                </div>
                <h4 class="fw-bold mb-1">{{ $teacher->name }}</h4>
                <p class="text-muted mb-3">{{ $teacher->email }}</p>
                <div class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill">Teacher</div>
            </div>
        </div>
        
        <div class="card border-0 shadow-sm animate__animated animate__fadeInLeft" style="animation-delay: 0.1s;">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3 text-uppercase small text-secondary">Professional Info</h6>
                <div class="mb-3">
                    <label class="text-muted small d-block">Department</label>
                    <span class="fw-medium">{{ $teacher->department->name ?? 'N/A' }}</span>
                </div>
                <div class="mb-3">
                    <label class="text-muted small d-block">Designation</label>
                    <span class="fw-medium">{{ $teacher->designation->name ?? 'N/A' }}</span>
                </div>
                <div class="mb-3">
                    <label class="text-muted small d-block">Subject</label>
                    <span class="fw-medium">{{ $teacher->subject ?? 'N/A' }}</span>
                </div>
                <div class="mb-0">
                    <label class="text-muted small d-block">Joining Date</label>
                    <span class="fw-medium">{{ $teacher->joining_date ? date('d M, Y', strtotime($teacher->joining_date)) : 'N/A' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card border-0 shadow-sm animate__animated animate__fadeInRight">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="fw-bold mb-0">Edit Profile Information</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('teacher.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-secondary small text-uppercase fw-bold">Full Name</label>
                            <input type="text" name="name" class="form-control border-0 bg-light p-3" value="{{ old('name', $teacher->name) }}" required>
                            @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary small text-uppercase fw-bold">Phone Number</label>
                            <input type="text" name="phone" class="form-control border-0 bg-light p-3" value="{{ old('phone', $teacher->phone) }}">
                            @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-secondary small text-uppercase fw-bold">Email Address</label>
                        <input type="email" class="form-control border-0 bg-light p-3 text-muted" value="{{ $teacher->email }}" disabled>
                        <small class="text-muted">Email cannot be changed.</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-secondary small text-uppercase fw-bold">Address</label>
                        <textarea name="address" class="form-control border-0 bg-light p-3" rows="3">{{ old('address', $teacher->address) }}</textarea>
                        @error('address') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-secondary small text-uppercase fw-bold">Profile Image</label>
                        <input type="file" name="profile_image" class="form-control border-0 bg-light p-3">
                        <small class="text-muted">Recommended size: 300x300px. Max: 2MB.</small>
                        @error('profile_image') <br><span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mt-5">
                        <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill fw-bold shadow-sm">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-primary { background: rgba(var(--bs-primary-rgb), 0.1); }
    .form-control:focus { background-color: #fff !important; box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.1); }
</style>
@endsection
