@extends('layouts.teacher')

@section('content')
<div class="dashboard-wrapper animate__animated animate__fadeIn">
    <!-- Welcome Header Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="welcome-card card border-0 position-relative overflow-hidden p-4 p-md-5">
                <div class="position-relative z-index-1 d-md-flex align-items-center justify-content-between">
                    <div class="welcome-text">
                        <h1 class="display-5 fw-bold text-white mb-2">
                            Good {{ now()->hour < 12 ? 'Morning' : (now()->hour < 17 ? 'Afternoon' : 'Evening') }}, {{ explode(' ', auth()->user()->name)[0] }}!
                        </h1>
                        <p class="lead text-white opacity-75 mb-0">
                            <i class="fas fa-calendar-day me-2"></i> {{ now()->format('F j, Y') }} | <i class="fas fa-clock ms-3 me-2"></i> <span id="dashboard-clock">{{ now()->format('h:i A') }}</span>
                        </p>
                        <div class="mt-4">
                            <span class="badge bg-white text-primary px-3 py-2 rounded-pill fw-bold shadow-sm">
                                <i class="fas fa-check-circle me-1"></i> System Active
                            </span>
                        </div>
                    </div>
                    <div class="welcome-actions mt-4 mt-md-0 d-none d-lg-block">
                        @php
                            $sidebarTeacher = \App\Models\Teacher::where('email', auth()->user()->email)->first();
                        @endphp
                        @if($sidebarTeacher && $sidebarTeacher->profile_image)
                            <img src="{{ asset($sidebarTeacher->profile_image) }}" alt="{{ $sidebarTeacher->name }}" class="welcome-avatar rounded-circle shadow-lg border border-3 border-white p-1" style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="welcome-avatar-placeholder bg-white text-primary rounded-circle shadow-lg d-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                                <i class="fas fa-user-tie fa-3x"></i>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- Abstract Design Elements -->
                <div class="abstract-shape-1"></div>
                <div class="abstract-shape-2"></div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card card h-100 border-0 shadow-sm p-4 overflow-hidden" style="border-right: 5px solid #4f46e5 !important;">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-secondary small fw-bold text-uppercase mb-1 ls-1">My Batches</p>
                        <h2 class="fw-bold mb-0 text-dark">{{ $batchCount }}</h2>
                    </div>
                    <div class="stat-icon bg-soft-primary text-primary">
                        <i class="fas fa-layer-group"></i>
                    </div>
                </div>
                <div class="mt-4 pt-2 border-top">
                    <a href="{{ route('teacher.batches') }}" class="text-primary text-decoration-none small fw-bold">
                        View Schedule <i class="fas fa-arrow-right ms-1 transition-icon"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card card h-100 border-0 shadow-sm p-4 overflow-hidden" style="border-right: 5px solid #0ea5e9 !important;">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-secondary small fw-bold text-uppercase mb-1 ls-1">Exams Held</p>
                        <h2 class="fw-bold mb-0 text-dark">{{ $examCount }}</h2>
                    </div>
                    <div class="stat-icon bg-soft-info text-info">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                </div>
                <div class="mt-4 pt-2 border-top">
                    <a href="{{ route('teacher.exams') }}" class="text-info text-decoration-none small fw-bold">
                        Grade Exams <i class="fas fa-arrow-right ms-1 transition-icon"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card card h-100 border-0 shadow-sm p-4 overflow-hidden" style="border-right: 5px solid #10b981 !important;">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-secondary small fw-bold text-uppercase mb-1 ls-1">Earnings</p>
                        <h2 class="fw-bold mb-0 text-dark">{{ $salarySlipCount }} <span class="fs-6 fw-normal text-muted">Slips</span></h2>
                    </div>
                    <div class="stat-icon bg-soft-success text-success">
                        <i class="fas fa-wallet"></i>
                    </div>
                </div>
                <div class="mt-4 pt-2 border-top">
                    <a href="{{ route('teacher.salary-slips.index') }}" class="text-success text-decoration-none small fw-bold">
                        Payout History <i class="fas fa-arrow-right ms-1 transition-icon"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card card h-100 border-0 shadow-sm p-4 overflow-hidden" style="border-right: 5px solid #f59e0b !important;">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-secondary small fw-bold text-uppercase mb-1 ls-1">Active Days</p>
                        <h2 class="fw-bold mb-0 text-dark">{{ $attendanceCount }}</h2>
                    </div>
                    <div class="stat-icon bg-soft-warning text-warning">
                        <i class="fas fa-user-check"></i>
                    </div>
                </div>
                <div class="mt-4 pt-2 border-top">
                    <a href="{{ route('teacher.attendance.index') }}" class="text-warning text-decoration-none small fw-bold">
                        Mark Today <i class="fas fa-arrow-right ms-1 transition-icon"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <!-- Announcements Section -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100 overflow-hidden">
                <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold m-0"><i class="fas fa-bullhorn text-warning me-2"></i> Recent Announcements</h5>
                    <a href="{{ route('teacher.notices') }}" class="btn btn-sm btn-light rounded-pill px-3 fw-bold">View All</a>
                </div>
                <div class="card-body p-4">
                    @forelse($notices as $notice)
                    <div class="announcement-item d-flex mb-4 pb-4 border-bottom last-child-no-border">
                        <div class="flex-shrink-0 bg-soft-warning p-3 rounded-4 me-3 text-warning">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-md-flex justify-content-between align-items-start mb-1">
                                <h6 class="fw-bold mb-0">{{ $notice->title }}</h6>
                                <span class="text-secondary smaller opacity-75">{{ $notice->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-muted small mb-0">{{ Str::limit($notice->description, 120) }}</p>
                            @if(strlen($notice->description) > 120)
                            <a href="#" class="text-primary smaller fw-bold mt-1 d-inline-block text-decoration-none">Read More</a>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <img src="https://img.icons8.com/bubbles/100/null/megaphone.png" class="mb-3" style="opacity: 0.5;">
                        <h6 class="text-muted">No news for now. Check back later!</h6>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Quick Actions Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100 overflow-hidden bg-white">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold m-0"><i class="fas fa-rocket text-primary me-2"></i> Quick Actions</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-grid gap-3">
                        <a href="{{ route('teacher.attendance.index') }}" class="btn action-btn text-start p-3 rounded-4 border-0 shadow-sm d-flex align-items-center">
                            <div class="action-icon bg-soft-primary text-primary me-3">
                                <i class="fas fa-user-clock"></i>
                            </div>
                            <div>
                                <span class="d-block fw-bold">Mark Attendance</span>
                                <small class="text-muted">For your active batches</small>
                            </div>
                            <i class="fas fa-chevron-right ms-auto text-muted small"></i>
                        </a>

                        <a href="{{ route('teacher.exams') }}" class="btn action-btn text-start p-3 rounded-4 border-0 shadow-sm d-flex align-items-center">
                            <div class="action-icon bg-soft-info text-info me-3">
                                <i class="fas fa-file-signature"></i>
                            </div>
                            <div>
                                <span class="d-block fw-bold">Schedule Exam</span>
                                <small class="text-muted">Organize new assessments</small>
                            </div>
                            <i class="fas fa-chevron-right ms-auto text-muted small"></i>
                        </a>

                        <a href="{{ route('teacher.profile') }}" class="btn action-btn text-start p-3 rounded-4 border-0 shadow-sm d-flex align-items-center">
                            <div class="action-icon bg-soft-success text-success me-3">
                                <i class="fas fa-user-cog"></i>
                            </div>
                            <div>
                                <span class="d-block fw-bold">Profile Settings</span>
                                <small class="text-muted">Update your information</small>
                            </div>
                            <i class="fas fa-chevron-right ms-auto text-muted small"></i>
                        </a>

                        <div class="card bg-soft-primary border-0 p-3 mt-3 rounded-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white p-3 rounded-circle me-3">
                                    <i class="fas fa-headset"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Need help?</h6>
                                    <small class="text-primary-dull sub-text">Contact development team</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        --primary-soft: rgba(79, 70, 229, 0.1);
        --info-soft: rgba(14, 165, 233, 0.1);
        --success-soft: rgba(16, 185, 129, 0.1);
        --warning-soft: rgba(245, 158, 11, 0.1);
    }

    .ls-1 { letter-spacing: 0.5px; }
    .smaller { font-size: 0.75rem; }
    .text-primary-dull { color: rgba(79, 70, 229, 0.8); }

    .welcome-card {
        background: var(--primary-gradient);
        border-radius: 30px !important;
        box-shadow: 0 20px 40px -10px rgba(79, 70, 229, 0.4) !important;
    }

    .welcome-avatar {
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .welcome-card:hover .welcome-avatar {
        transform: scale(1.1) rotate(5deg);
    }

    .abstract-shape-1 {
        position: absolute;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        top: -150px;
        right: -100px;
        z-index: 0;
    }

    .abstract-shape-2 {
        position: absolute;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        bottom: -100px;
        left: -50px;
        z-index: 0;
    }

    .stat-card {
        border-radius: 20px !important;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.1) !important;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 1.25rem;
    }

    .bg-soft-primary { background: var(--primary-soft); }
    .bg-soft-info { background: var(--info-soft); }
    .bg-soft-success { background: var(--success-soft); }
    .bg-soft-warning { background: var(--warning-soft); }

    .transition-icon { transition: transform 0.2s ease; }
    .stat-card:hover .transition-icon { transform: translateX(5px); }

    .action-btn {
        background: #f8fafc;
        transition: all 0.2s ease;
    }

    .action-btn:hover {
        background: #fff;
        transform: translateX(5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05) !important;
    }

    .action-icon {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
    }

    .last-child-no-border:last-child {
        border-bottom: 0 !important;
        margin-bottom: 0 !important;
        padding-bottom: 0 !important;
    }

    .announcement-item {
        transition: opacity 0.2s ease;
    }

    .announcement-item:hover {
        opacity: 0.8;
    }

    @media (max-width: 768px) {
        .welcome-card {
            border-radius: 20px !important;
            padding: 1.5rem !important;
        }
        .display-5 { font-size: 2rem; }
    }
</style>

@push('scripts')
<script>
    function updateClock() {
        const now = new Date();
        const clock = document.getElementById('dashboard-clock');
        if (clock) {
            clock.textContent = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
        }
    }
    setInterval(updateClock, 60000);
</script>
@endpush
@endsection
