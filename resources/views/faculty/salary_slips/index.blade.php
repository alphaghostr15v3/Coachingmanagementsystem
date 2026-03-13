@extends('layouts.faculty')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2 class="h3 mb-0 text-gray-800 fw-bold">My Salary Slips</h2>
        <p class="text-muted mb-0">View and download your monthly salary records</p>
    </div>

    <!-- Salary Slips Table -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 py-3">
            <h6 class="m-0 font-weight-bold text-primary">Your Payslips</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="salarySlipsTable">
                    <thead class="table-light">
                        <tr>
                            <th>Payslip ID</th>
                            <th>Month/Year</th>
                            <th>Net Salary</th>
                            <th>Payment Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($slips as $slip)
                        <tr>
                            <td>#{{ str_pad($slip->id, 6, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                                    {{ $slip->month }} {{ $slip->year }}
                                </span>
                            </td>
                            <td class="fw-bold text-success">₹{{ number_format($slip->net_salary, 2) }}</td>
                            <td>{{ $slip->payment_date->format('d M, Y') }}</td>
                            <td>
                                @if($slip->payment_status === 'Paid')
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">Paid</span>
                                @else
                                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-2">{{ $slip->payment_status }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('faculty.salary-slips.show', $slip->id) }}" class="btn btn-sm btn-primary rounded-pill px-3 me-1">
                                    <i class="fas fa-eye me-1"></i> View
                                </a>
                                <a href="{{ route('faculty.salary-slips.download', $slip->id) }}" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                    <i class="fas fa-file-pdf me-1"></i> PDF
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No salary slips found yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        if($('#salarySlipsTable tbody tr').length > 1) {
            $('#salarySlipsTable').DataTable({
                "order": [[ 3, "desc" ]],
                "pageLength": 10
            });
        }
    });
</script>
@endpush
