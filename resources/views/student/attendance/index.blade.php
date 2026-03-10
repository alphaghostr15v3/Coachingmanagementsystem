@extends('layouts.student')

@section('content')
<div class="mb-4 animate__animated animate__fadeIn">
    <h2 class="fw-bold">My Attendance Record</h2>
    <p class="text-muted">View your daily presence status.</p>
</div>

<div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr class="text-secondary small text-uppercase">
                        <th>Date</th>
                        <th>Day</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendance as $record)
                    <tr>
                        <td class="fw-bold">{{ date('d M, Y', strtotime($record->date)) }}</td>
                        <td class="text-muted">{{ date('l', strtotime($record->date)) }}</td>
                        <td class="text-center">
                            @if($record->status === 'present')
                                <span class="badge bg-soft-success text-success px-3 py-2 rounded-pill">Present</span>
                            @else
                                <span class="badge bg-soft-danger text-danger px-3 py-2 rounded-pill">Absent</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-5 text-muted">No attendance records found yet.</td>
                    </tr>
                    @endforelse
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
