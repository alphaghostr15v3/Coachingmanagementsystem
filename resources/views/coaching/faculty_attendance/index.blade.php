@extends('layouts.coaching')

@section('content')
<div class="mb-4 animate__animated animate__fadeIn">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('coaching.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active">Faculty Attendance</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h2 class="fw-bold m-0">Faculty Attendance History</h2>
            <p class="text-muted small mb-0">Manage and track daily attendance records for all faculty members.</p>
        </div>
        <div class="d-flex gap-2">
            <form action="{{ route('coaching.faculty-attendance.index') }}" method="GET" class="d-flex gap-2">
                <input type="date" name="date" class="form-control border-0 shadow-sm rounded-4" value="{{ $date }}" onchange="this.form.submit()">
            </form>
            <a href="{{ route('coaching.faculty-attendance.create', ['date' => $date]) }}" class="btn btn-primary rounded-4 fw-bold shadow-sm px-4">
                <i class="fas fa-plus-circle me-2"></i> Mark Attendance
            </a>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm animate__animated animate__fadeInUp rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary small text-uppercase">Faculty</th>
                        <th class="py-3 text-secondary small text-uppercase">Status</th>
                        <th class="py-3 text-secondary small text-uppercase">Remarks</th>
                        <th class="pe-4 py-3 text-secondary small text-uppercase text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $attendance)
                    <tr class="transition">
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-soft-info text-info rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $attendance->faculty->name }}</div>
                                    <div class="small text-muted">{{ $attendance->faculty->designation->title ?? 'Staff' }}</div>
                                </div>
                            </div>
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
                        <td class="text-muted small">
                            {{ $attendance->remarks ?? '---' }}
                        </td>
                        <td class="pe-4 text-end">
                            <form action="{{ route('coaching.faculty-attendance.destroy', $attendance) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link text-danger p-0" onclick="return confirm('Are you sure you want to delete this record?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <div class="opacity-50 mb-3">
                                <i class="fas fa-clipboard-list fa-3x"></i>
                            </div>
                            <p class="mb-0">No attendance records found for {{ Carbon\Carbon::parse($date)->format('d M, Y') }}.</p>
                            <a href="{{ route('coaching.faculty-attendance.create', ['date' => $date]) }}" class="text-primary fw-bold text-decoration-none small mt-2 d-inline-block">Mark Attendance Now</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .bg-soft-info { background: rgba(13, 202, 240, 0.1); }
    .bg-success-soft { background: rgba(16, 185, 129, 0.1); }
    .bg-danger-soft { background: rgba(239, 68, 68, 0.1); }
    .bg-warning-soft { background: rgba(245, 158, 11, 0.1); }
    .bg-info-soft { background: rgba(59, 130, 246, 0.1); }
    .transition { transition: all 0.2s ease-in-out; }
    tr:hover { background-color: rgba(248, 250, 252, 0.8); }
    .badge { border: 1px solid currentColor; }
</style>
@endsection
