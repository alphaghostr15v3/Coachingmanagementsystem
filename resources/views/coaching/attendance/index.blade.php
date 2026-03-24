@extends('layouts.coaching')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 animate__animated animate__fadeIn">
    <div>
        <h2 class="fw-bold mb-1 text-dark">Student Attendance Report</h2>
        <p class="text-muted small">Comprehensive tracking and reporting for student attendance across batches.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('coaching.attendance.index') }}" class="btn btn-light shadow-sm px-4 rounded-4 border">
            <i class="fas fa-sync-alt me-2"></i> Reset
        </a>
        <a href="{{ route('coaching.attendance.create') }}" class="btn btn-primary shadow-sm px-4 rounded-4">
            <i class="fas fa-plus me-2"></i> Mark Attendance
        </a>
    </div>
</div>

<!-- Summary Cards -->
<div class="row g-4 mb-4 animate__animated animate__fadeInUp">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-gradient-info text-white h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="avatar-sm bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                        <i class="fas fa-clipboard-list fs-4"></i>
                    </div>
                </div>
                <h6 class="text-white text-opacity-75 small text-uppercase fw-bold mb-1">Total Records</h6>
                <h2 class="display-6 fw-bold mb-0">{{ $totalDays }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-gradient-success text-white h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="avatar-sm bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                        <i class="fas fa-check-circle fs-4"></i>
                    </div>
                </div>
                <h6 class="text-white text-opacity-75 small text-uppercase fw-bold mb-1">Present Days</h6>
                <h2 class="display-6 fw-bold mb-0">{{ $presentCount }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-gradient-danger text-white h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="avatar-sm bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                        <i class="fas fa-times-circle fs-4"></i>
                    </div>
                </div>
                <h6 class="text-white text-opacity-75 small text-uppercase fw-bold mb-1">Absent Days</h6>
                <h2 class="display-6 fw-bold mb-0">{{ $absentCount }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-gradient-warning text-white h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="avatar-sm bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                        <i class="fas fa-percentage fs-4"></i>
                    </div>
                </div>
                <h6 class="text-white text-opacity-75 small text-uppercase fw-bold mb-1">Attendance Rate</h6>
                <h2 class="display-6 fw-bold mb-0">{{ $attendancePercentage }}%</h2>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="card border-0 shadow-sm mb-4 animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
    <div class="card-body p-4">
        <form method="GET" action="{{ route('coaching.attendance.index') }}" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-bold text-uppercase text-muted">Filter by Course</label>
                <select name="course_id" class="form-select border-0 bg-light rounded-3 py-2">
                    <option value="">All Courses</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold text-uppercase text-muted">Filter by Batch</label>
                <select name="batch_id" class="form-select border-0 bg-light rounded-3 py-2">
                    <option value="">All Batches</option>
                    @foreach($batches as $batch)
                        <option value="{{ $batch->id }}" {{ request('batch_id') == $batch->id ? 'selected' : '' }}>{{ $batch->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold text-uppercase text-muted">Student</label>
                <select name="student_id" class="form-select border-0 bg-light rounded-3 py-2">
                    <option value="">All Students</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>{{ $student->name }} ({{ $student->email }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold text-uppercase text-muted">Month</label>
                <select name="month" class="form-select border-0 bg-light rounded-3 py-2">
                    <option value="">Select Month</option>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ (request('month') ?? date('m')) == $i ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
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
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="attendanceTable">
                <thead>
                    <tr>
                        <th class="text-secondary small text-uppercase">#</th>
                        <th class="text-secondary small text-uppercase">Student Detail</th>
                        <th class="text-secondary small text-uppercase">Batch</th>
                        <th class="text-secondary small text-uppercase">Marking Date</th>
                        <th class="text-secondary small text-uppercase">Current Status</th>
                        <th class="text-center text-secondary small text-uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendances as $attendance)
                    <tr>
                        <td class="text-secondary">{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($attendance->student->profile_image)
                                    <img src="{{ asset($attendance->student->profile_image) }}" alt="Profile" class="rounded-circle me-3" style="width: 40px; height: 40px; object-fit: cover;">
                                @else
                                    <div class="avatar-xs bg-soft-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; font-size: 0.9rem;">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                @endif
                                <div>
                                    <span class="fw-bold text-dark d-block">{{ $attendance->student->name }}</span>
                                    <span class="text-muted small">{{ $attendance->student->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill small">
                                <i class="fas fa-layer-group me-1 text-primary"></i> {{ $attendance->batch->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td>
                            <span class="fw-medium text-dark">
                                <i class="far fa-calendar-alt me-1 text-muted"></i> {{ date('d M, Y', strtotime($attendance->date)) }}
                            </span>
                        </td>
                        <td>
                            @if($attendance->status === 'present')
                                <span class="badge-soft bg-soft-success text-success px-3 py-2 rounded-pill fw-bold small">
                                    <i class="fas fa-check-circle me-1"></i> PRESENT
                                </span>
                            @else
                                <span class="badge-soft bg-soft-danger text-danger px-3 py-2 rounded-pill fw-bold small">
                                    <i class="fas fa-times-circle me-1"></i> ABSENT
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <form action="{{ route('coaching.attendance.destroy', $attendance) }}" method="POST" onsubmit="return confirm('Delete this attendance entry?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger border-0 rounded-circle" title="Delete Entry" style="width: 32px; height: 32px;">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .bg-soft-success { background: rgba(16, 185, 129, 0.1); }
    .bg-soft-danger { background: rgba(239, 68, 68, 0.1); }
    .bg-soft-primary { background: rgba(99, 102, 241, 0.1); }
    .bg-soft-info { background: rgba(59, 130, 246, 0.1); }
    .bg-soft-warning { background: rgba(245, 158, 11, 0.1); }
    .bg-gradient-danger { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }
    .badge-soft { border-radius: 8px; }
</style>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#attendanceTable').DataTable({
            responsive: true,
            language: {
                search: "",
                searchPlaceholder: "Search attendance logs...",
                paginate: {
                    next: '<i class="fas fa-chevron-right"></i>',
                    previous: '<i class="fas fa-chevron-left"></i>'
                }
            }
        });
    });
</script>
@endpush
