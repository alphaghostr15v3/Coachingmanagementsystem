@extends('layouts.teacher')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center animate__animated animate__fadeIn" style="position: relative; z-index: 1051;">
    <div>
        <h2 class="fw-bold">My Students</h2>
        <p class="text-muted text-truncate mb-0">
            @if($selectedBatch)
                Students in batch: <span class="text-primary fw-bold">{{ $selectedBatch->name }}</span>
            @else
                All students across your assigned batches.
            @endif
        </p>
    </div>
    <div class="dropdown">
        <button class="btn btn-white border rounded-pill px-4 fw-bold dropdown-toggle shadow-sm text-dark bg-white" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-filter me-2 text-primary"></i> 
            @if($selectedBatch)
                Batch: {{ $selectedBatch->name }}
            @else
                Filter by Batch
            @endif
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 mt-2 bg-white" style="z-index: 1060; min-width: 200px;">
            <li><a class="dropdown-item py-2 {{ !$selectedBatch ? 'active fw-bold' : '' }}" href="{{ route('teacher.students') }}">All Batches</a></li>
            <li><hr class="dropdown-divider opacity-50"></li>
            @foreach($batches as $batch)
                <li>
                    <a class="dropdown-item py-2 {{ $selectedBatch && $selectedBatch->id == $batch->id ? 'active fw-bold' : '' }}" 
                       href="{{ route('teacher.students', ['batch_id' => $batch->id]) }}">
                        {{ $batch->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>

<div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary small fw-bold text-uppercase">Student Details</th>
                        <th class="py-3 text-secondary small fw-bold text-uppercase">Email / Phone</th>
                        <th class="py-3 text-secondary small fw-bold text-uppercase">Assigned Batches</th>
                        <th class="pe-4 py-3 text-secondary small fw-bold text-uppercase text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                    <tr>
                        <td class="ps-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-soft-primary rounded-circle text-primary me-3 flex-shrink-0 overflow-hidden" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(79, 70, 229, 0.2);">
                                    @if($student->profile_image)
                                        <img src="{{ asset($student->profile_image) }}" alt="{{ $student->name }}" class="img-fluid h-100 w-100 object-fit-cover">
                                    @else
                                        <i class="fas fa-user-graduate"></i>
                                    @endif
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark">{{ $student->name }}</h6>
                                    <span class="text-muted smaller">ID: #ST{{ str_pad($student->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="small text-dark mb-1"><i class="far fa-envelope me-2 text-muted"></i>{{ $student->email }}</span>
                                <span class="small text-muted"><i class="fas fa-phone-alt me-2 text-muted"></i>{{ $student->phone ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-1">
                                @foreach($student->batches as $studentBatch)
                                    <span class="badge bg-soft-info text-info rounded-pill px-2 py-1 smaller">
                                        {{ $studentBatch->name }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="pe-4 text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('teacher.attendance.create', ['batch_id' => $selectedBatch->id ?? $student->batches->first()->id ?? 0]) }}" 
                                   class="btn btn-sm btn-outline-primary rounded-3" title="Mark Attendance">
                                    <i class="fas fa-calendar-check"></i>
                                </a>
                                <a href="{{ route('teacher.students.show', $student) }}" class="btn btn-sm btn-outline-secondary rounded-3" title="Student Profile">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-users-slash fs-1 mb-3 opacity-25"></i>
                                <p class="mb-0">No students found @if($selectedBatch) in this batch @endif.</p>
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
    .smaller { font-size: 0.75rem; }
    .last-child-no-border:last-child { border-bottom: 0 !important; }
</style>
@endsection
