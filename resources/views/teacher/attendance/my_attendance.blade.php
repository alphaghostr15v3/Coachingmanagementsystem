@extends('layouts.teacher')

@section('content')
<div class="mb-4 animate__animated animate__fadeIn">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('teacher.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active">My Attendance</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold m-0">My Attendance History</h2>
            <p class="text-muted small mb-0">Track your daily presence and attendance status.</p>
        </div>
        <div class="bg-white px-2 py-2 rounded-4 border shadow-sm">
            <form action="{{ route('teacher.my-attendance') }}" method="GET" class="d-flex gap-2">
                <select name="month" class="form-select form-select-sm border-0 bg-light" onchange="this.form.submit()">
                    @for($m=1; $m<=12; $m++)
                        <option value="{{ sprintf('%02d', $m) }}" {{ $month == sprintf('%02d', $m) ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                        </option>
                    @endfor
                </select>
                <select name="year" class="form-select form-select-sm border-0 bg-light" onchange="this.form.submit()">
                    @for($y=date('Y'); $y>=date('Y')-5; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </form>
        </div>
    </div>
</div>

<div class="row g-4 mb-4 animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white border-start border-primary border-4">
            <div class="card-body p-4 text-center">
                <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 50px; height: 50px;">
                    <i class="fas fa-calendar-alt text-primary fa-lg"></i>
                </div>
                <h3 class="fw-bold mb-1">{{ $totalAttendance }}</h3>
                <p class="text-muted small mb-0 text-uppercase tracking-wider">Total Days</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white border-start border-success border-4">
            <div class="card-body p-4 text-center">
                <div class="rounded-circle bg-success-soft d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 50px; height: 50px;">
                    <i class="fas fa-check-circle text-success fa-lg"></i>
                </div>
                <h3 class="fw-bold mb-1 text-success">{{ $presentCount }}</h3>
                <p class="text-muted small mb-0 text-uppercase tracking-wider">Present</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white border-start border-danger border-4">
            <div class="card-body p-4 text-center">
                <div class="rounded-circle bg-danger-soft d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 50px; height: 50px;">
                    <i class="fas fa-times-circle text-danger fa-lg"></i>
                </div>
                <h3 class="fw-bold mb-1 text-danger">{{ $absentCount }}</h3>
                <p class="text-muted small mb-0 text-uppercase tracking-wider">Absent</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white border-start border-warning border-4">
            <div class="card-body p-4 text-center">
                <div class="rounded-circle bg-warning-soft d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 50px; height: 50px;">
                    <i class="fas fa-clock text-warning fa-lg"></i>
                </div>
                <h3 class="fw-bold mb-1 text-warning">{{ $lateCount }}</h3>
                <p class="text-muted small mb-0 text-uppercase tracking-wider">Late</p>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm animate__animated animate__fadeInUp rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary small text-uppercase">Date</th>
                        <th class="py-3 text-secondary small text-uppercase">Day</th>
                        <th class="py-3 text-secondary small text-uppercase">Status</th>
                        <th class="pe-4 py-3 text-secondary small text-uppercase">Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $attendance)
                    <tr class="transition">
                        <td class="ps-4">
                            <div class="fw-bold text-dark">{{ \Carbon\Carbon::parse($attendance->date)->format('d M, Y') }}</div>
                        </td>
                        <td class="text-muted">
                            {{ \Carbon\Carbon::parse($attendance->date)->format('l') }}
                        </td>
                        <td>
                            @if($attendance->status == 'present')
                                <span class="badge bg-success-soft text-success px-3 py-2 rounded-pill fw-bold">
                                    <i class="fas fa-check-circle me-1"></i> Present
                                </span>
                            @elseif($attendance->status == 'absent')
                                <span class="badge bg-danger-soft text-danger px-3 py-2 rounded-pill fw-bold">
                                    <i class="fas fa-times-circle me-1"></i> Absent
                                </span>
                            @elseif($attendance->status == 'late')
                                <span class="badge bg-warning-soft text-warning px-3 py-2 rounded-pill fw-bold">
                                    <i class="fas fa-clock me-1"></i> Late
                                </span>
                            @elseif($attendance->status == 'leave')
                                <span class="badge bg-info-soft text-info px-3 py-2 rounded-pill fw-bold">
                                    <i class="fas fa-envelope me-1"></i> Leave
                                </span>
                            @endif
                        </td>
                        <td class="pe-4 text-muted small">
                            {{ $attendance->remarks ?? '---' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <div class="opacity-50 mb-3">
                                <i class="fas fa-calendar-minus fa-3x"></i>
                            </div>
                            <p class="mb-0">No attendance records found yet.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .bg-success-soft { background: rgba(16, 185, 129, 0.1); }
    .bg-danger-soft { background: rgba(239, 68, 68, 0.1); }
    .bg-warning-soft { background: rgba(245, 158, 11, 0.1); }
    .bg-info-soft { background: rgba(59, 130, 246, 0.1); }
    .transition { transition: all 0.2s ease-in-out; }
    tr:hover { background-color: rgba(248, 250, 252, 0.8); }
    .badge { border: 1px solid currentColor; }
</style>
@endsection
