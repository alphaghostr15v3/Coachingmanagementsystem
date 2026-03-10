@extends('layouts.admin')

@section('content')
<div class="mb-5 animate__animated animate__fadeIn">
    <h2 class="fw-bold mb-1">System Overview</h2>
    <p class="text-muted">Global analytics across all registered coaching institutes.</p>
</div>

<!-- Global Metrics -->
<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="card border-0 bg-indigo text-white animate__animated animate__zoomIn">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 opacity-75 fw-medium text-uppercase small">Total Coachings</p>
                        <h2 class="mb-0 fw-bold">{{ $totalCoachings }}</h2>
                    </div>
                    <div class="bg-white bg-opacity-20 p-3 rounded-circle">
                        <i class="fas fa-university fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 bg-emerald text-white animate__animated animate__zoomIn" style="animation-delay: 0.1s">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 opacity-75 fw-medium text-uppercase small">Active Institutes</p>
                        <h2 class="mb-0 fw-bold">{{ $activeCoachings }}</h2>
                    </div>
                    <div class="bg-white bg-opacity-20 p-3 rounded-circle">
                        <i class="fas fa-check-double fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 bg-rose text-white animate__animated animate__zoomIn" style="animation-delay: 0.2s">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 opacity-75 fw-medium text-uppercase small">Expired Access</p>
                        <h2 class="mb-0 fw-bold">{{ $expiredCoachings }}</h2>
                    </div>
                    <div class="bg-white bg-opacity-20 p-3 rounded-circle">
                        <i class="fas fa-clock fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 bg-amber text-white animate__animated animate__zoomIn" style="animation-delay: 0.3s">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 opacity-75 fw-medium text-uppercase small">Total Ecosystem Students</p>
                        <h2 class="mb-0 fw-bold">{{ number_format($totalStudents) }}</h2>
                    </div>
                    <div class="bg-white bg-opacity-20 p-3 rounded-circle">
                        <i class="fas fa-users fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Global Revenue Chart -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100 animate__animated animate__fadeInUp">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold m-0"><i class="fas fa-chart-bar me-2 text-indigo"></i> Platform Revenue Growth</h5>
                <div class="text-end">
                    <h3 class="fw-bold m-0">₹{{ number_format($totalRevenue, 2) }}</h3>
                    <small class="text-muted">Total Gross Volume</small>
                </div>
            </div>
            <div class="card-body p-4">
                <div style="height: 350px;">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- System Status -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100 animate__animated animate__fadeInUp" style="animation-delay: 0.2s">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold m-0"><i class="fas fa-server me-2 text-primary"></i> System Health</h5>
            </div>
            <div class="card-body p-4">
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="small fw-bold">Database Connections</span>
                        <span class="badge bg-success badge-premium">Stable</span>
                    </div>
                    <div class="progress rounded-pill" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: 100%"></div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="small fw-bold">Storage Usage (SaaS Bases)</span>
                        <span class="small text-muted">1.2 GB / 50 GB</span>
                    </div>
                    <div class="progress rounded-pill" style="height: 8px;">
                        <div class="progress-bar bg-primary" style="width: 15%"></div>
                    </div>
                </div>

                <hr>
                
                <h6 class="fw-bold mb-3 small text-uppercase text-secondary">Quick Navigation</h6>
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.coachings.create') }}" class="btn btn-light text-start py-3 rounded-4 border-0 shadow-sm fw-bold">
                        <i class="fas fa-plus-circle me-2 text-primary"></i> Register New Coaching
                    </a>
                    <a href="{{ route('admin.coachings.index') }}" class="btn btn-light text-start py-3 rounded-4 border-0 shadow-sm fw-bold">
                        <i class="fas fa-list me-2 text-primary"></i> View All Accounts
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Monthly Growth (₹)',
                data: [45000, 59000, 80000, 110000, 95000, 130000],
                backgroundColor: 'rgba(79, 70, 229, 0.8)',
                borderRadius: 12,
                barThickness: 40
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { display: false },
                    border: { display: false }
                },
                x: {
                    grid: { display: false },
                    border: { display: false }
                }
            }
        }
    });
</script>
@endpush
