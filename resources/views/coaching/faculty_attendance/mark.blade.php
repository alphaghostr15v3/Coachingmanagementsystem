@extends('layouts.coaching')

@section('content')
<div class="mb-4 animate__animated animate__fadeIn">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('coaching.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('coaching.faculty-attendance.index', ['date' => $date]) }}" class="text-decoration-none">Faculty Attendance</a></li>
            <li class="breadcrumb-item active">Mark Attendance</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold m-0">Mark Faculty Attendance</h2>
            <p class="text-muted small mb-0">Record attendance for {{ Carbon\Carbon::parse($date)->format('l, d F Y') }}</p>
        </div>
        <div class="bg-white px-4 py-3 rounded-4 border shadow-sm d-flex align-items-center">
            <i class="fas fa-calendar-alt text-info fs-4 me-3"></i>
            <div>
                <div class="small text-muted text-uppercase fw-bold" style="font-size: 0.65rem;">Attendance Date</div>
                <div class="fw-bold h6 mb-0">{{ Carbon\Carbon::parse($date)->format('d M, Y') }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm animate__animated animate__fadeInUp rounded-4 overflow-hidden">
    <div class="card-body p-4 p-md-5">
        <form action="{{ route('coaching.faculty-attendance.store') }}" method="POST">
            @csrf
            <input type="hidden" name="date" value="{{ $date }}">
            
            <div class="alert alert-info border-0 shadow-sm rounded-4 py-3 mb-5 d-flex align-items-center">
                <i class="fas fa-info-circle fs-4 me-3"></i>
                <div class="small fw-medium">Tip: Select the attendance status for each faculty member. You can also add brief remarks for late or leave status.</div>
            </div>

            <div class="table-responsive mb-5">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th width="50" class="ps-4 py-3 text-secondary small text-uppercase">#</th>
                            <th class="py-3 text-secondary small text-uppercase">Faculty Detail</th>
                            <th class="py-3 text-secondary small text-uppercase">Attendance Status</th>
                            <th width="250" class="pe-4 py-3 text-secondary small text-uppercase">Remarks (Optional)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($faculties as $faculty)
                        <tr class="transition">
                            <td class="ps-4 text-secondary small">{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-xs bg-soft-info text-info rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                        <i class="fas fa-user-tie"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $faculty->name }}</div>
                                        <div class="small text-muted">{{ $faculty->designation->title ?? 'Staff' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @php $status = $existingAttendance[$faculty->id] ?? 'present'; @endphp
                                <div class="btn-group border rounded-4 bg-light p-1 w-100" role="group">
                                    <input type="radio" class="btn-check" name="attendance[{{ $faculty->id }}]" id="present_{{ $faculty->id }}" value="present" {{ $status == 'present' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-success border-0 rounded-4 fw-bold py-2 small" for="present_{{ $faculty->id }}">P</label>

                                    <input type="radio" class="btn-check" name="attendance[{{ $faculty->id }}]" id="absent_{{ $faculty->id }}" value="absent" {{ $status == 'absent' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-danger border-0 rounded-4 fw-bold py-2 small" for="absent_{{ $faculty->id }}">A</label>

                                    <input type="radio" class="btn-check" name="attendance[{{ $faculty->id }}]" id="late_{{ $faculty->id }}" value="late" {{ $status == 'late' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-warning border-0 rounded-4 fw-bold py-2 small" for="late_{{ $faculty->id }}">L</label>

                                    <input type="radio" class="btn-check" name="attendance[{{ $faculty->id }}]" id="leave_{{ $faculty->id }}" value="leave" {{ $status == 'leave' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-info border-0 rounded-4 fw-bold py-2 small" for="leave_{{ $faculty->id }}">LV</label>
                                </div>
                            </td>
                            <td class="pe-4">
                                <input type="text" name="remarks[{{ $faculty->id }}]" class="form-control form-control-sm border-0 bg-light rounded-4 px-3" placeholder="Add remark..." value="">
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="fas fa-user-slash fs-1 d-block mb-3 opacity-25"></i>
                                No faculty found. Please <a href="{{ route('coaching.faculties.create') }}">onboard faculty</a> first.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($faculties->count() > 0)
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('coaching.faculty-attendance.index', ['date' => $date]) }}" class="btn btn-light rounded-4 px-4 fw-bold">
                   <i class="fas fa-arrow-left me-2"></i> Back
                </a>
                <button type="submit" class="btn btn-primary px-5 py-3 rounded-4 fw-bold shadow-lg">
                    <i class="fas fa-save me-2"></i> Save Attendance Sheet
                </button>
            </div>
            @endif
        </form>
    </div>
</div>

<style>
    .btn-check:checked + .btn-outline-success { background-color: #10b981 !important; color: #fff !important; }
    .btn-check:checked + .btn-outline-danger { background-color: #ef4444 !important; color: #fff !important; }
    .btn-check:checked + .btn-outline-warning { background-color: #f59e0b !important; color: #fff !important; }
    .btn-check:checked + .btn-outline-info { background-color: #3b82f6 !important; color: #fff !important; }
    .bg-soft-info { background: rgba(13, 202, 240, 0.1); }
    .transition { transition: all 0.2s ease-in-out; }
    tr:hover { background-color: rgba(248, 250, 252, 0.8); }
    .btn-group .btn { flex: 1; text-transform: uppercase; letter-spacing: 0.5px; }
</style>
@endsection
