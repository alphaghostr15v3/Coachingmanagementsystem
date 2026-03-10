@extends('layouts.teacher')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center animate__animated animate__fadeIn">
    <div>
        <h2 class="fw-bold">Exam Schedule</h2>
        <p class="text-muted">Manage exams and schedules for your assigned batches.</p>
    </div>
</div>

<div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary small fw-bold text-uppercase">Exam Name</th>
                        <th class="py-3 text-secondary small fw-bold text-uppercase">Course</th>
                        <th class="py-3 text-secondary small fw-bold text-uppercase">Batch</th>
                        <th class="py-3 text-secondary small fw-bold text-uppercase text-center">Date</th>
                        <th class="pe-4 py-3 text-secondary small fw-bold text-uppercase text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($exams as $exam)
                    <tr>
                        <td class="ps-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-soft-primary p-2 rounded-3 text-primary me-3 text-center" style="width: 40px;">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <span class="fw-bold text-dark">{{ $exam->name }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="text-muted small fw-medium">{{ $exam->course->name ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <span class="badge bg-soft-info text-info rounded-pill px-3">{{ $exam->batch->name ?? 'N/A' }}</span>
                        </td>
                        <td class="text-center">
                            <span class="text-muted small fw-medium">{{ date('d M, Y', strtotime($exam->date)) }}</span>
                        </td>
                        <td class="pe-4 text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('teacher.marks.index', ['exam_id' => $exam->id, 'batch_id' => $exam->batch_id]) }}" class="btn btn-sm btn-outline-primary rounded-3" title="View Results">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('teacher.marks.create', ['exam_id' => $exam->id, 'batch_id' => $exam->batch_id]) }}" class="btn btn-sm btn-outline-secondary rounded-3" title="Manage Marks">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-calendar-times fs-1 mb-3 opacity-25"></i>
                                <p class="mb-0">No exams scheduled for your batches.</p>
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
</style>
@endsection
