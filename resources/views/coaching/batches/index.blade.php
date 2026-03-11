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
                            <div class="small">
                                <div class="mb-1">
                                    <i class="far fa-calendar-alt me-2 text-primary"></i>
                                    <span class="text-dark">
                                        {{ $batch->start_date ? \Carbon\Carbon::parse($batch->start_date)->format('M d, Y') : 'N/A' }} 
                                        @if($batch->end_date)
                                            - {{ \Carbon\Carbon::parse($batch->end_date)->format('M d, Y') }}
                                        @endif
                                    </span>
                                </div>
                                <div class="mb-1">
                                    <i class="far fa-clock me-2 text-warning"></i>
                                    <span class="text-dark">
                                        @if($batch->start_time && $batch->end_time)
                                            {{ \Carbon\Carbon::parse($batch->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($batch->end_time)->format('h:i A') }}
                                        @else
                                            {{ $batch->class_time ? \Carbon\Carbon::parse($batch->class_time)->format('h:i A') : 'N/A' }}
                                        @endif
                                    </span>
                                </div>
                                @if($batch->capacity)
                                <div class="mb-1 text-muted opacity-75">
                                    <i class="fas fa-users me-2"></i>
                                    Capacity: {{ $batch->capacity }}
                                </div>
                                @endif
                                @if($batch->timing)
                                <div class="text-muted opacity-75">
                                    <i class="fas fa-info-circle me-2"></i>
                                    {{ $batch->timing }}
                                </div>
                                @endif
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('coaching.batches.edit', $batch) }}" class="btn btn-sm btn-outline-warning rounded-3" title="Edit Batch">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('coaching.batches.destroy', $batch) }}" method="POST" onsubmit="return confirm('Delete this batch?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="Delete Batch">
                                        <i class="fas fa-trash"></i>
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
