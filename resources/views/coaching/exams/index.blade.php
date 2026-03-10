@extends('layouts.coaching')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 animate__animated animate__fadeIn">
    <div>
        <h2 class="fw-bold mb-1">Exam Schedule</h2>
        <p class="text-muted small">Manage upcoming and historical examinations.</p>
    </div>
    <a href="{{ route('coaching.exams.create') }}" class="btn btn-primary px-4">
        <i class="fas fa-plus me-2"></i> Schedule New Exam
    </a>
</div>

<div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="examsTable">
                <thead>
                    <tr>
                        <th class="text-secondary small text-uppercase">#</th>
                        <th class="text-secondary small text-uppercase">Exam Name</th>
                        <th class="text-secondary small text-uppercase">Course / Batch</th>
                        <th class="text-secondary small text-uppercase">Exam Date</th>
                        <th class="text-center text-secondary small text-uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($exams as $exam)
                    <tr>
                        <td class="text-secondary">{{ $loop->iteration }}</td>
                        <td><span class="fw-bold text-dark">{{ $exam->name }}</span></td>
                        <td>
                            <div class="fw-medium small text-primary">{{ $exam->course->name ?? 'N/A' }}</div>
                            <div class="text-muted small">Batch: {{ $exam->batch->name ?? 'All Batches' }}</div>
                        </td>
                        <td>
                            <div class="bg-light px-3 py-2 rounded-3 d-inline-block">
                                <i class="far fa-calendar-alt text-secondary me-2"></i>
                                <span class="fw-bold small">{{ date('d M, Y', strtotime($exam->date)) }}</span>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('coaching.marks.create', ['exam_id' => $exam->id, 'batch_id' => $exam->batch_id ?? 0]) }}" class="btn btn-sm btn-outline-success rounded-3" title="Enter Marks">
                                    <i class="fas fa-poll"></i>
                                </a>
                                <a href="{{ route('coaching.exams.edit', $exam) }}" class="btn btn-sm btn-outline-primary rounded-3">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('coaching.exams.destroy', $exam) }}" method="POST" onsubmit="return confirm('Delete this exam?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-3">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#examsTable').DataTable({
            responsive: true,
            language: {
                search: "",
                searchPlaceholder: "Search exams..."
            }
        });
    });
</script>
@endpush
