@extends('layouts.coaching')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 animate__animated animate__fadeIn">
    <div>
        <h2 class="fw-bold mb-1">Fees & Revenue</h2>
        <p class="text-muted small">Track student payments and monitor financial records.</p>
    </div>
    <a href="{{ route('coaching.fees.create') }}" class="btn btn-primary shadow-sm px-4">
        <i class="fas fa-cash-register me-2"></i> Collect Fee
    </a>
</div>

<div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="feesTable">
                <thead>
                    <tr>
                        <th class="text-secondary small text-uppercase">#</th>
                        <th class="text-secondary small text-uppercase">Student</th>
                        <th class="text-secondary small text-uppercase">Total Amount</th>
                        <th class="text-secondary small text-uppercase">Status</th>
                        <th class="text-secondary small text-uppercase">Payment Date</th>
                        <th class="text-center text-secondary small text-uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fees as $fee)
                    <tr>
                        <td class="text-secondary">{{ $loop->iteration }}</td>
                        <td><span class="fw-bold text-dark">{{ $fee->student->name }}</span></td>
                        <td>
                            <span class="fw-bold fs-5 text-dark">₹{{ number_format($fee->total_amount, 2) }}</span>
                            <div class="text-muted small" style="font-size: 0.75rem;">Base: ₹{{ number_format($fee->amount, 2) }}</div>
                        </td>
                        <td>
                            @if($fee->status === 'paid')
                                <span class="badge bg-soft-success text-success border border-success border-opacity-25 px-3 py-2 rounded-pill">
                                    <i class="fas fa-check-circle me-1"></i> Full Paid
                                </span>
                            @else
                                <span class="badge bg-soft-danger text-danger border border-danger border-opacity-25 px-3 py-2 rounded-pill">
                                    <i class="fas fa-times-circle me-1"></i> Pending
                                </span>
                            @endif
                        </td>
                        <td><span class="text-muted small fw-medium">{{ date('d M, Y', strtotime($fee->date)) }}</span></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('coaching.fees.show', $fee) }}" class="btn btn-sm btn-outline-primary rounded-3" title="View Invoice">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('coaching.fees.download', $fee) }}" class="btn btn-sm btn-outline-danger rounded-3" title="Download PDF">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                                <a href="{{ route('coaching.fees.edit', $fee) }}" class="btn btn-sm btn-outline-warning rounded-3" title="Update Record">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('coaching.fees.destroy', $fee) }}" method="POST" onsubmit="return confirm('Delete this record?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="Remove Record">
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
    .bg-soft-success { background: rgba(16, 185, 129, 0.1); }
    .bg-soft-danger { background: rgba(239, 68, 68, 0.1); }
</style>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#feesTable').DataTable({
            responsive: true,
            language: {
                search: "",
                searchPlaceholder: "Search financial records...",
                paginate: {
                    next: '<i class="fas fa-chevron-right"></i>',
                    previous: '<i class="fas fa-chevron-left"></i>'
                }
            }
        });
    });
</script>
@endpush
