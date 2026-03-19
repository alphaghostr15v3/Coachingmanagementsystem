@extends('layouts.faculty')

@section('content')
<div class="mb-4 animate__animated animate__fadeIn">
    <h2 class="fw-bold text-dark">My Profile</h2>
    <p class="text-muted small">Manage your personal information and profile picture.</p>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4 animate__animated animate__fadeInLeft">
            <div class="card-body text-center p-5">
                <div class="mb-4 position-relative d-inline-block">
                    @if($faculty->profile_image)
                        <img src="{{ asset($faculty->profile_image) }}" alt="{{ $faculty->name }}" class="rounded-circle shadow-sm border border-4 border-white profile-img-hover" style="width: 140px; height: 140px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-soft-info text-info d-flex align-items-center justify-content-center mx-auto shadow-sm border border-4 border-white" style="width: 140px; height: 140px;">
                            <i class="fas fa-user-tie fa-4x"></i>
                        </div>
                    @endif
                    <div class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2 shadow-sm border border-2 border-white" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-camera fa-xs"></i>
                    </div>
                </div>
                <h4 class="fw-bold mb-1 text-dark">{{ $faculty->name }}</h4>
                <p class="text-muted small mb-3">{{ $faculty->email }}</p>
                <div class="badge bg-soft-info text-info px-4 py-2 rounded-pill font-weight-bold">
                    {{ $faculty->designation->title ?? 'Faculty Staff' }}
                </div>
            </div>
        </div>
        
        <div class="card border-0 shadow-sm animate__animated animate__fadeInLeft" style="animation-delay: 0.1s;">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4 text-uppercase small text-secondary tracking-wider">Professional Information</h6>
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar-sm bg-light rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                        <i class="fas fa-sitemap text-primary small"></i>
                    </div>
                    <div>
                        <label class="text-muted small d-block mb-0">Department</label>
                        <span class="fw-bold small">{{ $faculty->department->name ?? 'General' }}</span>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar-sm bg-light rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                        <i class="fas fa-calendar-check text-success small"></i>
                    </div>
                    <div>
                        <label class="text-muted small d-block mb-0">Joining Date</label>
                        <span class="fw-bold small">{{ $faculty->joining_date ? date('d M, Y', strtotime($faculty->joining_date)) : 'N/A' }}</span>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="avatar-sm bg-light rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                        <i class="fas fa-toggle-on text-info small"></i>
                    </div>
                    <div>
                        <label class="text-muted small d-block mb-0">Status</label>
                        <span class="badge {{ $faculty->status == 'Active' ? 'bg-soft-success text-success' : 'bg-soft-danger text-danger' }} rounded-pill px-3 py-1 small">
                            {{ $faculty->status }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8 text-dark">
        <div class="card border-0 shadow-sm animate__animated animate__fadeInRight">
            <div class="card-header bg-white py-4 border-0 px-4">
                <h5 class="fw-bold mb-0"><i class="fas fa-edit me-2 text-primary"></i> Edit Profile Details</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('faculty.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-secondary">Phone Number</label>
                            <input type="text" name="phone" class="form-control form-control-lg border-0 bg-light rounded-4 px-3" value="{{ old('phone', $faculty->phone) }}" placeholder="Your contact number">
                            @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-secondary">Email Address (Read-only)</label>
                            <input type="email" class="form-control form-control-lg border-0 bg-light rounded-4 px-3 text-muted" value="{{ $faculty->email }}" disabled>
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-secondary">Qualification</label>
                            <input type="text" name="qualification" class="form-control form-control-lg border-0 bg-light rounded-4 px-3" value="{{ old('qualification', $faculty->qualification) }}" placeholder="e.g. MBA, B.Tech">
                            @error('qualification') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-secondary">Experience</label>
                            <input type="text" name="experience" class="form-control form-control-lg border-0 bg-light rounded-4 px-3" value="{{ old('experience', $faculty->experience) }}" placeholder="e.g. 5 Years">
                            @error('experience') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase text-secondary">Profile Image</label>
                        <div class="d-flex align-items-center p-3 bg-light rounded-4 border border-dashed">
                            <i class="fas fa-cloud-upload-alt fa-2x text-muted me-3"></i>
                            <div class="flex-grow-1">
                                <input type="file" name="profile_image" class="form-control border-0 bg-transparent p-0">
                                <small class="text-muted mt-1 d-block">Recommended: 300x300px PNG/JPG. Max 2MB.</small>
                            </div>
                        </div>
                        @error('profile_image') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mt-5 text-end">
                        <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill fw-bold shadow">
                            <i class="fas fa-check-circle me-2"></i> Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-info { background: rgba(13, 202, 240, 0.1); }
    .bg-soft-success { background: rgba(34, 197, 94, 0.1); }
    .bg-soft-danger { background: rgba(239, 68, 68, 0.1); }
    .profile-img-hover { transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); cursor: pointer; }
    .profile-img-hover:hover { transform: scale(1.08) rotate(2deg); }
    .border-dashed { border-style: dashed !important; border-width: 2px !important; }
    .form-control:focus { background-color: #fff !important; box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1) !important; border-color: #0ea5e9 !important; }
</style>
@endsection
