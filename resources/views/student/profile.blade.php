@extends('layouts.student')

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
                    @if($student->profile_image)
                        <img src="{{ asset($student->profile_image) }}" alt="{{ $student->name }}" class="rounded-circle img-thumbnail shadow-sm" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto shadow-sm" style="width: 150px; height: 150px;">
                            <i class="fas fa-user fa-4x text-secondary"></i>
                        </div>
                    @endif
                </div>
                <h4 class="fw-bold mb-1">{{ $student->name }}</h4>
                <p class="text-muted mb-3">{{ $student->email }}</p>
                <div class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill">Student</div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card border-0 shadow-sm animate__animated animate__fadeInRight">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="fw-bold mb-0">Edit Profile Information</h5>
            </div>
            <div class="card-body p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-secondary small text-uppercase fw-bold">Full Name</label>
                            <input type="text" name="name" class="form-control border-0 bg-light p-3" value="{{ old('name', $student->name) }}" required>
                            @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary small text-uppercase fw-bold">Phone Number</label>
                            <input type="text" name="phone" class="form-control border-0 bg-light p-3" value="{{ old('phone', $student->phone) }}">
                            @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-secondary small text-uppercase fw-bold">Email Address</label>
                        <input type="email" class="form-control border-0 bg-light p-3 text-muted" value="{{ $student->email }}" disabled>
                        <small class="text-muted">Email cannot be changed.</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-secondary small text-uppercase fw-bold">Address</label>
                        <textarea name="address" class="form-control border-0 bg-light p-3" rows="3">{{ old('address', $student->address) }}</textarea>
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
