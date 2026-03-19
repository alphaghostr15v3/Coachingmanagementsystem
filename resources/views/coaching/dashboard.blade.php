@extends('layouts.coaching')

@section('content')
<div class="mb-5 animate__animated animate__fadeIn">
    <h2 class="fw-bold mb-1">Welcome back, Admin!</h2>
    <p class="text-muted">Here's what's happening in your institute today.</p>
</div>

<!-- Metric Cards -->
<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="card border-0 bg-gradient-primary text-white animate__animated animate__zoomIn" style="animation-delay: 0.1s">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 opacity-75 fw-medium text-uppercase small">Total Students</p>
                        <h2 class="mb-0 fw-bold">{{ number_format($totalStudents) }}</h2>
                    </div>
                    <div class="bg-white bg-opacity-25 p-3 rounded-circle">
                        <i class="fas fa-user-graduate fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 bg-gradient-info text-white animate__animated animate__zoomIn" style="animation-delay: 0.2s">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 opacity-75 fw-medium text-uppercase small">Total Teachers</p>
                        <h2 class="mb-0 fw-bold">{{ number_format($totalTeachers) }}</h2>
                    </div>
                    <div class="bg-white bg-opacity-25 p-3 rounded-circle">
                        <i class="fas fa-chalkboard-teacher fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 bg-gradient-success text-white animate__animated animate__zoomIn" style="animation-delay: 0.3s">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 opacity-75 fw-medium text-uppercase small">Active Courses</p>
                        <h2 class="mb-0 fw-bold">{{ number_format($totalCourses) }}</h2>
                    </div>
                    <div class="bg-white bg-opacity-25 p-3 rounded-circle">
                        <i class="fas fa-book fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 bg-gradient-warning text-white animate__animated animate__zoomIn" style="animation-delay: 0.4s">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="opacity-75 mb-1 fw-medium text-uppercase small">Active Batches</p>
                        <h2 class="mb-0 fw-bold">{{ number_format($totalBatches) }}</h2>
                    </div>
                    <div class="bg-white bg-opacity-25 p-3 rounded-circle">
                        <i class="fas fa-layer-group fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Chart -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100 animate__animated animate__fadeInUp">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold m-0"><i class="fas fa-chart-pie me-2 text-primary"></i> Revenue Distribution</h5>
                <span class="badge bg-light text-dark border py-2 px-3">Live Data</span>
            </div>
            <div class="card-body p-4">
                <div style="height: 300px;">
                    <canvas id="revenueChart"></canvas>
                </div>
                <div class="row text-center mt-4">
                    <div class="col-6">
                        <h4 class="fw-bold text-success mb-0">₹{{ number_format($totalRevenue) }}</h4>
                        <small class="text-muted">Collected</small>
                    </div>
                    <div class="col-6">
                        <h4 class="fw-bold text-danger mb-0">₹{{ number_format($unpaidFees) }}</h4>
                        <small class="text-muted">Pending</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100 animate__animated animate__fadeInUp" style="animation-delay: 0.2s">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold m-0"><i class="fas fa-bolt me-2 text-warning"></i> Quick Actions</h5>
            </div>
            <div class="card-body p-4">
                <div class="d-grid gap-3">
                    <a href="{{ route('coaching.students.create') }}" class="action-btn d-flex align-items-center p-3 text-decoration-none rounded-4 bg-light border transition animate__animated animate__fadeInRight" style="animation-delay: 0.4s">
                        <div class="icon-box bg-primary text-white rounded-3 me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold text-dark">Register Student</h6>
                            <small class="text-muted">Enroll a new student to a course</small>
                        </div>
                    </a>
                    
                    <a href="{{ route('coaching.fees.create') }}" class="action-btn d-flex align-items-center p-3 text-decoration-none rounded-4 bg-light border transition animate__animated animate__fadeInRight" style="animation-delay: 0.5s">
                        <div class="icon-box bg-success text-white rounded-3 me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold text-dark">Collect Fee</h6>
                            <small class="text-muted">Submit a new payment record</small>
                        </div>
                    </a>
                    
                    <a href="{{ route('coaching.attendance.create') }}" class="action-btn d-flex align-items-center p-3 text-decoration-none rounded-4 bg-light border transition animate__animated animate__fadeInRight" style="animation-delay: 0.6s">
                        <div class="icon-box bg-info text-white rounded-3 me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold text-dark">Mark Attendance</h6>
                            <small class="text-muted">Update student record for today</small>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .transition { transition: all 0.3s; }
    .action-btn:hover {
        background: #fff !important;
        transform: scale(1.02);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        border-color: var(--primary-color) !important;
    }
</style>
@endsection

@push('scripts')
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Collected Revenue', 'Pending Fees'],
            datasets: [{
                data: [{{ $totalRevenue }}, {{ $unpaidFees }}],
                backgroundColor: [
                    '#10b981',
                    '#ef4444'
                ],
                hoverOffset: 15,
                borderWidth: 0,
                borderRadius: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
@endpush
