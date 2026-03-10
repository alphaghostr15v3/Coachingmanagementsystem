@extends('layouts.coaching')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 animate__animated animate__fadeIn">
    <div>
        <h2 class="fw-bold mb-1">Batch Management</h2>
        <p class="text-muted small">Organize students into batches and manage class timings.</p>
    </div>
    <a href="{{ route('coaching.batches.create') }}" class="btn btn-primary shadow-sm px-4">
        <i class="fas fa-plus me-2"></i> New Batch
    </a>
</div>

<div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="batchesTable">
                <thead>
                    <tr>
                        <th class="text-secondary small text-uppercase">#</th>
                        <th class="text-secondary small text-uppercase">Batch Details</th>
                        <th class="text-secondary small text-uppercase">Course Mapping</th>
                        <th class="text-secondary small text-uppercase">Timing Info</th>
                        <th class="text-center text-secondary small text-uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($batches as $batch)
                    <tr>
                        <td class="text-secondary">{{ $loop->iteration }}</td>
                        <td><span class="fw-bold text-dark">{{ $batch->name }}</span></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-soft-primary text-primary rounded-pill px-3 py-2 border border-primary border-opacity-25">{{ $batch->course->name }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center text-muted small">
                                <i class="far fa-clock me-2 text-warning"></i>
                                {{ $batch->timing ?? 'TBA' }}
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light border dropdown-toggle px-3" type="button" data-bs-toggle="dropdown">
                                    Manage
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                                    <li><a class="dropdown-item py-2" href="{{ route('coaching.batches.edit', $batch) }}"><i class="fas fa-edit text-warning me-2"></i> Edit Batch</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('coaching.batches.destroy', $batch) }}" method="POST" onsubmit="return confirm('Delete this batch?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item py-2 text-danger"><i class="fas fa-trash me-2"></i> Delete</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .bg-soft-primary { background: rgba(99, 102, 241, 0.1); }
</style>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#batchesTable').DataTable({
            responsive: true,
            language: {
                search: "",
                searchPlaceholder: "Search batches...",
                paginate: {
                    next: '<i class="fas fa-chevron-right"></i>',
                    previous: '<i class="fas fa-chevron-left"></i>'
                }
            }
        });
    });
</script>
@endpush
