@extends('layouts.teacher')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center animate__animated animate__fadeIn">
    <div>
        <h2 class="fw-bold">Attendance History</h2>
        <p class="text-muted">Review and manage your students' attendance records.</p>
    </div>
    <a href="{{ route('teacher.batches') }}" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
        <i class="fas fa-plus me-2"></i> Mark New Attendance
    </a>
</div>

<div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary small fw-bold text-uppercase">Student</th>
                        <th class="py-3 text-secondary small fw-bold text-uppercase">Batch</th>
                        <th class="py-3 text-secondary small fw-bold text-uppercase text-center">Date</th>
                        <th class="py-3 text-secondary small fw-bold text-uppercase text-center">Status</th>
                        <th class="pe-4 py-3 text-secondary small fw-bold text-uppercase text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $attendance)
                    <tr>
                        <td class="ps-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-soft-primary p-2 rounded-3 text-primary me-3">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <span class="fw-bold text-dark">{{ $attendance->student->name }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-soft-info text-info rounded-pill px-3">{{ $attendance->batch->name ?? 'N/A' }}</span>
                        </td>
                        <td class="text-center">
                            <span class="text-muted small fw-medium">{{ date('d M, Y', strtotime($attendance->date)) }}</span>
                        </td>
                        <td class="text-center">
                            @if($attendance->status === 'present')
                                <span class="badge bg-soft-success text-success rounded-pill px-3 py-1">
                                    <i class="fas fa-check-circle me-1"></i> Present
                                </span>
                            @else
                                <span class="badge bg-soft-danger text-danger rounded-pill px-3 py-1">
                                    <i class="fas fa-times-circle me-1"></i> Absent
                                </span>
                            @endif
                        </td>
                        <td class="pe-4 text-center">
                            <form action="{{ route('teacher.attendance.destroy', $attendance) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this attendance entry?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="Delete Entry">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-calendar-times fs-1 mb-3 opacity-25"></i>
                                <p class="mb-0">No attendance records found.</p>
                                <a href="{{ route('teacher.batches') }}" class="btn btn-link link-primary p-0">Mark attendance now</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .bg-soft-primary { background: rgba(79, 70, 229, 0.1); }
    .bg-soft-info { background: rgba(14, 165, 233, 0.1); }
    .bg-soft-success { background: rgba(16, 185, 129, 0.1); }
    .bg-soft-danger { background: rgba(239, 68, 68, 0.1); }
</style>
@endsection
