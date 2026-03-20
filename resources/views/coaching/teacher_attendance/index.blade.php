@extends('layouts.coaching')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 animate__animated animate__fadeIn">
    <div>
        <h2 class="fw-bold mb-1 text-dark">Teacher Attendance Report</h2>
        <p class="text-muted small">Comprehensive tracking and reporting for teacher attendance history.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('coaching.teacher-attendance.index') }}" class="btn btn-light shadow-sm px-4 rounded-4 border">
            <i class="fas fa-sync-alt me-2"></i> Reset
        </a>
        <a href="{{ route('coaching.teacher-attendance.create', ['date' => $date]) }}" class="btn btn-primary shadow-sm px-4 rounded-4">
            <i class="fas fa-plus me-2"></i> Mark Attendance
        </a>
    </div>
</div>

<!-- Summary Cards -->
<div class="row g-4 mb-4 animate__animated animate__fadeInUp">
    <div class="col-md-2">
        <div class="card border-0 shadow-sm bg-gradient-info text-white h-100">
            <div class="card-body p-3">
                <h6 class="text-white text-opacity-75 small text-uppercase fw-bold mb-1">Total</h6>
                <h3 class="fw-bold mb-0">{{ $totalRecords }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm bg-gradient-success text-white h-100">
            <div class="card-body p-3">
                <h6 class="text-white text-opacity-75 small text-uppercase fw-bold mb-1">Present</h6>
                <h3 class="fw-bold mb-0">{{ $presentCount }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm bg-gradient-danger text-white h-100">
            <div class="card-body p-3">
                <h6 class="text-white text-opacity-75 small text-uppercase fw-bold mb-1">Absent</h6>
                <h3 class="fw-bold mb-0">{{ $absentCount }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm bg-gradient-warning text-white h-100">
            <div class="card-body p-3">
                <h6 class="text-white text-opacity-75 small text-uppercase fw-bold mb-1">Late/Leave</h6>
                <h3 class="fw-bold mb-0">{{ $lateCount + $leaveCount }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-dark text-white h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-white text-opacity-75 small text-uppercase fw-bold mb-1">Attendance Rate</h6>
                    <h3 class="fw-bold mb-0">{{ $attendancePercentage }}%</h3>
                </div>
                <div class="chart-circle" style="width: 45px; height: 45px;">
                    <i class="fas fa-chart-line fa-2x opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="card border-0 shadow-sm mb-4 animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
    <div class="card-body p-4">
        <form method="GET" action="{{ route('coaching.teacher-attendance.index') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label small fw-bold text-uppercase text-muted">Select Teacher</label>
                <select name="teacher_id" class="form-select border-0 bg-light rounded-3 py-2">
                    <option value="">All Teachers</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold text-uppercase text-muted">Month</label>
                <select name="month" class="form-select border-0 bg-light rounded-3 py-2">
                    <option value="">Select Month</option>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ (request('month') ?? (request('teacher_id') ? date('m') : '')) == $i ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold text-uppercase text-muted">Year</label>
                <select name="year" class="form-select border-0 bg-light rounded-3 py-2">
                    @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                        <option value="{{ $i }}" {{ (request('year') ?? date('Y')) == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-bold">
                    <i class="fas fa-filter me-2"></i> Filter
                </button>
            </div>
            @if(!request('teacher_id') && !request('month'))
            <div class="col-12 mt-3 pt-3 border-top">
                <div class="d-flex align-items-center gap-3">
                    <span class="small fw-bold text-uppercase text-muted">Or View Daily Log:</span>
                    <input type="date" name="date" class="form-control border-0 bg-light rounded-3 py-1 px-3 w-auto" value="{{ $date }}" onchange="this.form.submit()">
                </div>
            </div>
            @endif
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="attendanceTable">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary small text-uppercase">Teacher Detail</th>
                        <th class="py-3 text-secondary small text-uppercase">Date</th>
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
                                <div class="avatar-sm bg-soft-primary text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $attendance->teacher->name }}</div>
                                    <div class="small text-muted">{{ $attendance->teacher->subject }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="fw-medium text-dark small">
                                <i class="far fa-calendar-alt me-1 text-muted"></i> {{ date('d M, Y', strtotime($attendance->date)) }}
                            </span>
                        </td>
                        <td>
                            @if($attendance->status == 'present')
                                <span class="badge-soft bg-soft-success text-success px-3 py-2 rounded-pill fw-bold small">
                                    <i class="fas fa-check-circle me-1"></i> Present
                                </span>
                            @elseif($attendance->status == 'absent')
                                <span class="badge-soft bg-soft-danger text-danger px-3 py-2 rounded-pill fw-bold small">
                                    <i class="fas fa-times-circle me-1"></i> Absent
                                </span>
                            @elseif($attendance->status == 'late')
                                <span class="badge-soft bg-soft-warning text-warning px-3 py-2 rounded-pill fw-bold small">
                                    <i class="fas fa-clock me-1"></i> Late
                                </span>
                            @elseif($attendance->status == 'leave')
                                <span class="badge-soft bg-soft-info text-info px-3 py-2 rounded-pill fw-bold small">
                                    <i class="fas fa-envelope me-1"></i> Leave
                                </span>
                            @endif
                        </td>
                        <td class="text-muted small">
                            {{ $attendance->remarks ?? '---' }}
                        </td>
                        <td class="pe-4 text-end">
                            <form action="{{ route('coaching.teacher-attendance.destroy', $attendance) }}" method="POST" class="d-inline">
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
                        <td colspan="5" class="text-center py-5 text-muted">
                            <div class="opacity-50 mb-3">
                                <i class="fas fa-clipboard-list fa-3x"></i>
                            </div>
                            <p class="mb-0">No attendance records found for the selected criteria.</p>
                            <a href="{{ route('coaching.teacher-attendance.create', ['date' => $date]) }}" class="text-primary fw-bold text-decoration-none small mt-2 d-inline-block">Mark Attendance Now</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#attendanceTable').DataTable({
            responsive: true,
            language: {
                search: "",
                searchPlaceholder: "Search attendance...",
                paginate: {
                    next: '<i class="fas fa-chevron-right"></i>',
                    previous: '<i class="fas fa-chevron-left"></i>'
                }
            }
        });
    });
</script>
@endpush

<style>
    .bg-soft-primary { background: rgba(99, 102, 241, 0.1); }
    .bg-soft-success { background: rgba(16, 185, 129, 0.1); }
    .bg-soft-danger { background: rgba(239, 68, 68, 0.1); }
    .bg-soft-warning { background: rgba(245, 158, 11, 0.1); }
    .bg-soft-info { background: rgba(59, 130, 246, 0.1); }
    .bg-gradient-danger { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }
    .badge-soft { border: 1px solid currentColor; }
    .transition { transition: all 0.2s ease-in-out; }
    tr:hover { background-color: rgba(248, 250, 252, 0.8); }
</style>
@endsection
