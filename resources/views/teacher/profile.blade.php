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
                    <span class="fw-medium">{{ $teacher->designation->title ?? 'N/A' }}</span>
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
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Profile Information</h5>
                <span class="badge bg-soft-secondary text-secondary px-3 py-2 rounded-pill"><i class="fas fa-lock me-1"></i> Read Only</span>
            </div>
            <div class="card-body p-4">
                <div class="row mb-4">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <label class="form-label text-secondary small text-uppercase fw-bold">Full Name</label>
                        <div class="p-3 bg-light rounded-3 fw-medium">{{ $teacher->name }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-secondary small text-uppercase fw-bold">Phone Number</label>
                        <div class="p-3 bg-light rounded-3 fw-medium">{{ $teacher->phone ?? 'Not Provided' }}</div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-secondary small text-uppercase fw-bold">Email Address</label>
                    <div class="p-3 bg-light rounded-3 fw-medium">{{ $teacher->email }}</div>
                </div>

                <div class="mb-0">
                    <label class="form-label text-secondary small text-uppercase fw-bold">Address</label>
                    <div class="p-3 bg-light rounded-3 fw-medium" style="min-height: 100px;">{{ $teacher->address ?? 'Not Provided' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-primary { background: rgba(var(--bs-primary-rgb), 0.1); }
    .bg-soft-secondary { background: rgba(108, 117, 125, 0.1); }
</style>
@endsection
