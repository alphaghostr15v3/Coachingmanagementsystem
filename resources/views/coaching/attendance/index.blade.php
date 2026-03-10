@extends('layouts.coaching')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 animate__animated animate__fadeIn">
    <div>
        <h2 class="fw-bold mb-1">Attendance Log</h2>
        <p class="text-muted small">Monitor student presence and daily tracking history.</p>
    </div>
    <a href="{{ route('coaching.attendance.create') }}" class="btn btn-primary shadow-sm px-4">
        <i class="fas fa-user-check me-2"></i> Mark Attendance
    </a>
</div>

<div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="attendanceTable">
                <thead>
                    <tr>
                        <th class="text-secondary small text-uppercase">#</th>
                        <th class="text-secondary small text-uppercase">Student Detail</th>
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
                                <div class="avatar-xs bg-light rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                    <i class="fas fa-user text-muted"></i>
                                </div>
                                <span class="fw-bold text-dark">{{ $attendance->student->name }}</span>
                            </div>
                        </td>
                        <td><span class="fw-medium text-dark">{{ date('d M, Y', strtotime($attendance->date)) }}</span></td>
                        <td>
                            @if($attendance->status === 'present')
                                <span class="badge bg-soft-success text-success border border-success border-opacity-25 px-4 py-2 rounded-pill fw-bold">
                                    PRESENT
                                </span>
                            @else
                                <span class="badge bg-soft-danger text-danger border border-danger border-opacity-25 px-4 py-2 rounded-pill fw-bold">
                                    ABSENT
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <form action="{{ route('coaching.attendance.destroy', $attendance) }}" method="POST" onsubmit="return confirm('Delete this attendance entry?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="Delete Entry">
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
