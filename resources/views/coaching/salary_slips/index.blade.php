@extends('layouts.coaching')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-0 text-gray-800 fw-bold">Salary Slips</h2>
            <p class="text-muted mb-0">Manage and generate teacher salary records</p>
        </div>
        <div>
            <a href="{{ route('coaching.salary-slips.create') }}" class="btn btn-primary shadow-sm rounded-pill px-4">
                <i class="fas fa-plus-circle me-2"></i> Generate New Slip
            </a>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 py-2 bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                Total Slips</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $slips->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-invoice-dollar fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 py-2 bg-gradient-success text-white">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                Total Paid</div>
                            <div class="h5 mb-0 font-weight-bold">₹{{ number_format($slips->where('payment_status', 'Paid')->sum('net_salary'), 2) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-rupee-sign fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Salary Slips Table -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 py-3 d-flex align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Generated Salary Slips</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="salarySlipsTable">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Teacher</th>
                            <th>Period</th>
                            <th>Basic Salary</th>
                            <th>Net Salary</th>
                            <th>Payment Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($slips as $slip)
                        <tr>
                            <td>#{{ str_pad($slip->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                        <i class="fas fa-user-tie"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $slip->teacher->name }}</h6>
                                        <small class="text-muted">{{ $slip->teacher->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill">
                                    {{ $slip->month }} {{ $slip->year }}
                                </span>
                            </td>
                            <td>₹{{ number_format($slip->basic_salary, 2) }}</td>
                            <td class="fw-bold text-success">₹{{ number_format($slip->net_salary, 2) }}</td>
                            <td>{{ $slip->payment_date->format('d M, Y') }}</td>
                            <td>
                                @if($slip->payment_status === 'Paid')
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">Paid</span>
                                @elseif($slip->payment_status === 'Pending')
                                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-2">Pending</span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-2">{{ $slip->payment_status }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('coaching.salary-slips.show', $slip->id) }}" class="btn btn-sm btn-primary rounded-pill px-3 me-2 shadow-sm d-flex align-items-center" style="min-width: 85px; height: 32px;">
                                        <i class="fas fa-eye me-1 small"></i> View
                                    </a>
                                    <a href="{{ route('coaching.salary-slips.download', $slip->id) }}" class="btn btn-sm btn-info text-white rounded-pill px-3 me-2 shadow-sm d-flex align-items-center" style="min-width: 85px; height: 32px;">
                                        <i class="fas fa-file-pdf me-1 small"></i> PDF
                                    </a>
                                    <form action="{{ route('coaching.salary-slips.destroy', $slip->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this salary slip?');" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3 shadow-sm d-flex align-items-center" style="min-width: 95px; height: 32px;">
                                            <i class="fas fa-trash me-1 small"></i> Delete
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
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#salarySlipsTable').DataTable({
            "order": [[ 5, "desc" ]], // Sort by payment date descending
            "pageLength": 25,
            "language": {
                "search": "",
                "searchPlaceholder": "Search slips..."
            }
        });
        $('.dataTables_filter input').addClass('form-control form-control-sm rounded-pill');
    });
</script>
@endpush
