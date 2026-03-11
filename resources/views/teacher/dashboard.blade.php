@extends('layouts.teacher')

@section('content')
<div class="row g-4 animate__animated animate__fadeIn">
    <div class="col-12">
        <div class="card border-0 bg-gradient-primary text-white p-4 shadow-lg rounded-4 overflow-hidden position-relative">
            <div class="position-relative z-index-1">
                <h2 class="fw-bold mb-1">Welcome back, {{ auth()->user()->name }}!</h2>
                <p class="opacity-75 mb-0">Here's what's happening in your classes today.</p>
            </div>
            <i class="fas fa-chalkboard-teacher position-absolute end-0 bottom-0 opacity-25 m-n3" style="font-size: 150px;"></i>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 p-4">
            <div class="d-flex align-items-center mb-3">
                <div class="bg-soft-primary p-3 rounded-4 text-primary me-3">
                    <i class="fas fa-layer-group fs-4"></i>
                </div>
                <div>
                    <h6 class="text-secondary small fw-bold text-uppercase mb-0">Assigned Batches</h6>
                    <h3 class="fw-bold mb-0">{{ $batchCount }}</h3>
                </div>
            </div>
            <a href="{{ route('teacher.batches') }}" class="btn btn-light btn-sm rounded-pill w-100 mt-2 fw-bold text-primary border-0">View All</a>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 p-4">
            <div class="d-flex align-items-center mb-3">
                <div class="bg-soft-info p-3 rounded-4 text-info me-3">
                    <i class="fas fa-file-invoice fs-4"></i>
                </div>
                <div>
                    <h6 class="text-secondary small fw-bold text-uppercase mb-0">Exams Conducted</h6>
                    <h3 class="fw-bold mb-0">{{ $examCount }}</h3>
                </div>
            </div>
            <a href="{{ route('teacher.exams') }}" class="btn btn-light btn-sm rounded-pill w-100 mt-2 fw-bold text-info border-0">View Schedule</a>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 p-4">
            <div class="d-flex align-items-center mb-3">
                <div class="bg-soft-success p-3 rounded-4 text-success me-3">
                    <i class="fas fa-file-invoice-dollar fs-4"></i>
                </div>
                <div>
                    <h6 class="text-secondary small fw-bold text-uppercase mb-0">Salary Slips</h6>
                    <h3 class="fw-bold mb-0">{{ $salarySlipCount }}</h3>
                </div>
            </div>
            <a href="{{ route('teacher.salary-slips.index') }}" class="btn btn-light btn-sm rounded-pill w-100 mt-2 fw-bold text-success border-0">View Slips</a>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 p-4">
            <div class="d-flex align-items-center mb-3">
                <div class="bg-soft-warning p-3 rounded-4 text-warning me-3">
                    <i class="fas fa-calendar-check fs-4"></i>
                </div>
                <div>
                    <h6 class="text-secondary small fw-bold text-uppercase mb-0">Today's Attendance</h6>
                    <h3 class="fw-bold mb-0">Marked</h3>
                </div>
            </div>
            <a href="{{ route('teacher.attendance.index') }}" class="btn btn-light btn-sm rounded-pill w-100 mt-2 fw-bold text-warning border-0">Update Now</a>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h5 class="fw-bold m-0">Recent Announcements</h5>
            </div>
            <div class="card-body p-4">
                @foreach($notices as $notice)
                <div class="d-flex mb-4 pb-4 border-bottom last-child-no-border">
                    <div class="flex-shrink-0 bg-light p-3 rounded-4 me-3 text-warning">
                        <i class="fas fa-bullhorn fs-5"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">{{ $notice->title }}</h6>
                        <p class="text-muted small mb-0">{{ Str::limit($notice->description, 100) }}</p>
                        <span class="text-secondary smaller mt-1 d-block">{{ $notice->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-primary { background: rgba(79, 70, 229, 0.1); }
    .bg-soft-info { background: rgba(14, 165, 233, 0.1); }
    .bg-soft-success { background: rgba(16, 185, 129, 0.1); }
    .last-child-no-border:last-child { border-bottom: 0 !important; margin-bottom: 0 !important; padding-bottom: 0 !important; }
    .bg-gradient-primary { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); }
</style>
@endsection
