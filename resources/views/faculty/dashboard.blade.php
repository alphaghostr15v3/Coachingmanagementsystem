@extends('layouts.faculty')

@section('content')
<div class="mb-4 animate__animated animate__fadeIn">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h2 class="fw-bold m-0 text-dark">Welcome back, {{ $faculty->name }}!</h2>
            <p class="text-muted small mb-0">Here's a quick overview of your profile and records.</p>
        </div>
        <div class="bg-white px-4 py-3 rounded-4 border shadow-sm d-flex align-items-center">
            <i class="fas fa-calendar-alt text-info fs-4 me-3"></i>
            <div>
                <div class="small text-muted text-uppercase fw-bold" style="font-size: 0.65rem;">Today is</div>
                <div class="fw-bold h6 mb-0 text-dark">{{ now()->format('d M, Y') }}</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Profile Card -->
    <div class="col-lg-4 animate__animated animate__fadeInLeft" style="animation-delay: 0.1s">
        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
            <div class="bg-info p-4 text-center">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px;">
                    <i class="fas fa-user-tie fa-3x text-info"></i>
                </div>
                <h5 class="fw-bold text-white mb-1">{{ $faculty->name }}</h5>
                <p class="text-white opacity-75 small mb-0">{{ $faculty->designation->title ?? 'Staff Member' }}</p>
            </div>
            <div class="card-body p-4 bg-white">
                <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                    <span class="text-muted small">Department</span>
                    <span class="fw-semibold small text-dark">{{ $faculty->department->name ?? 'General' }}</span>
                </div>
                <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                    <span class="text-muted small">Email</span>
                    <span class="fw-semibold small text-dark">{{ $faculty->email }}</span>
                </div>
                <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                    <span class="text-muted small">Phone</span>
                    <span class="fw-semibold small text-dark">{{ $faculty->phone ?? '---' }}</span>
                </div>
                <div class="d-flex justify-content-between border-bottom pb-2">
                    <span class="text-muted small">Status</span>
                    <span class="badge bg-success-soft text-success px-3 py-1 rounded-pill small fw-bold">
                        <i class="fas fa-check-circle me-1"></i> {{ $faculty->status }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats and Latest Record -->
    <div class="col-lg-8">
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100 transition animate__animated animate__fadeInDown" style="animation-delay: 0.2s">
                    <div class="d-flex align-items-center">
                        <div class="bg-info-soft text-info rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <i class="fas fa-calendar-check fs-4"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Present This Month</div>
                            <div class="fw-bold h4 mb-0 text-dark">{{ $attendanceCount }} Days</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100 transition animate__animated animate__fadeInDown" style="animation-delay: 0.3s">
                    <div class="d-flex align-items-center">
                        <div class="bg-success-soft text-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <i class="fas fa-calendar-plus fs-4"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Joining Date</div>
                            <div class="fw-bold h4 mb-0 text-dark">{{ $faculty->joining_date ? Carbon\Carbon::parse($faculty->joining_date)->format('M Y') : '---' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 bg-white animate__animated animate__fadeInUp" style="animation-delay: 0.4s">
            <div class="card-header bg-transparent border-0 p-4 pb-0">
                <h5 class="fw-bold m-0 text-dark"><i class="fas fa-file-invoice-dollar me-2 text-info"></i> Latest Salary Update</h5>
            </div>
            <div class="card-body p-4">
                @if($latestSalary)
                    <div class="alert alert-light border-0 rounded-4 p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Month of {{ $latestSalary->month }} {{ $latestSalary->year }}</div>
                            <div class="fw-bold h3 text-primary mb-1">₹{{ number_format($latestSalary->net_salary, 2) }}</div>
                            <span class="badge {{ $latestSalary->payment_status == 'paid' ? 'bg-success' : 'bg-warning' }} rounded-pill px-3">
                                {{ strtoupper($latestSalary->payment_status) }}
                            </span>
                        </div>
                        <a href="#" class="btn btn-info text-white rounded-pill px-4 shadow-sm">
                            <i class="fas fa-download me-2"></i> Download Slip
                        </a>
                    </div>
                @else
                    <div class="text-center py-5">
                        <img src="https://illustrations.popsy.co/blue/empty-wallet.svg" alt="Empty" style="height: 120px;" class="mb-3 opacity-50">
                        <p class="text-muted">No salary slips found yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .bg-info-soft { background: rgba(14, 165, 233, 0.1); }
    .bg-success-soft { background: rgba(16, 185, 129, 0.1); }
    .transition:hover { transform: translateY(-3px); transition: all 0.3s ease; }
    .badge { border: 1px solid currentColor; }
</style>
@endsection
