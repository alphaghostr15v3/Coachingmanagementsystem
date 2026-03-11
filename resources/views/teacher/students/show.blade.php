@extends('layouts.teacher')

@section('content')
<div class="mb-4 animate__animated animate__fadeIn">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('teacher.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('teacher.students') }}" class="text-decoration-none">Students</a></li>
            <li class="breadcrumb-item active">Student Profile</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="fw-bold mb-0">Student Profile</h2>
        <a href="{{ route('teacher.students') }}" class="btn btn-light border shadow-sm px-4 rounded-pill">
            <i class="fas fa-arrow-left me-2"></i>Back to List
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm text-center animate__animated animate__fadeInLeft h-100">
            <div class="card-body p-4 p-md-5 d-flex flex-column align-items-center justify-content-center">
                <div class="bg-soft-primary text-primary rounded-circle mb-4 d-flex align-items-center justify-content-center shadow-sm" style="width: 120px; height: 120px; font-size: 3rem;">
                    {{ strtoupper(substr($student->name, 0, 1)) }}
                </div>
                <h4 class="fw-bold mb-1">{{ $student->name }}</h4>
                <p class="text-muted mb-4">Student ID: <span class="fw-bold text-dark">#ST{{ str_pad($student->id, 4, '0', STR_PAD_LEFT) }}</span></p>
                
                <div class="d-flex flex-wrap justify-content-center gap-2 w-100">
                    @foreach($student->batches as $batch)
                        <span class="badge bg-soft-info text-info rounded-pill px-3 py-2 border border-info border-opacity-25">
                            {{ $batch->name }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm animate__animated animate__fadeInRight h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4 px-md-5">
                <h5 class="fw-bold mb-0"><i class="fas fa-info-circle me-2 text-primary"></i>Personal Information</h5>
            </div>
            <div class="card-body p-4 p-md-5">
                <div class="row g-4">
                    <div class="col-sm-6">
                        <div class="p-3 bg-light rounded-4">
                            <div class="small text-muted text-uppercase fw-bold mb-1">Email Address</div>
                            <div class="fw-medium text-dark d-flex align-items-center">
                                <i class="fas fa-envelope text-secondary me-2"></i>
                                {{ $student->email ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-6">
                        <div class="p-3 bg-light rounded-4">
                            <div class="small text-muted text-uppercase fw-bold mb-1">Phone Number</div>
                            <div class="fw-medium text-dark d-flex align-items-center">
                                <i class="fas fa-phone-alt text-secondary me-2"></i>
                                {{ $student->phone ?? 'Not Provided' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="p-3 bg-light rounded-4">
                            <div class="small text-muted text-uppercase fw-bold mb-1">Address</div>
                            <div class="fw-medium text-dark d-flex align-items-start">
                                <i class="fas fa-map-marker-alt text-secondary me-2 mt-1"></i>
                                <span>{{ $student->address ?? 'Not Provided' }}</span>
                            </div>
                        </div>
                    </div>
                    
                    @if($student->state)
                    <div class="col-sm-6">
                        <div class="p-3 bg-light rounded-4">
                            <div class="small text-muted text-uppercase fw-bold mb-1">State</div>
                            <div class="fw-medium text-dark d-flex align-items-center">
                                <i class="fas fa-map text-secondary me-2"></i>
                                {{ $student->state }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-primary { background: rgba(79, 70, 229, 0.1); }
    .bg-soft-info { background: rgba(14, 165, 233, 0.1); }
</style>
@endsection
