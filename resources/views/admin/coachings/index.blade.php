@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 animate__animated animate__fadeIn">
    <div>
        <h2 class="fw-bold mb-1">Coaching Institutes</h2>
        <p class="text-muted small">Manage and monitor all SaaS tenant accounts.</p>
    </div>
    <a href="{{ route('admin.coachings.create') }}" class="btn btn-gradient px-4">
        <i class="fas fa-plus me-2"></i> Register New Institute
    </a>
</div>

<div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="coachingsTable">
                <thead>
                    <tr>
                        <th class="text-secondary small text-uppercase">#</th>
                        <th class="text-secondary small text-uppercase">Institute Detail</th>
                        <th class="text-secondary small text-uppercase">Owner / Contact</th>
                        <th class="text-secondary small text-uppercase">Database</th>
                        <th class="text-secondary small text-uppercase">Billing Status</th>
                        <th class="text-center text-secondary small text-uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($coachings as $coaching)
                    <tr>
                        <td class="text-secondary">{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-light text-indigo rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; font-size: 1.2rem;">
                                    <i class="fas fa-school"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $coaching->coaching_name }}</div>
                                    <div class="text-muted small">
                                        <span class="badge bg-soft-indigo text-indigo border border-indigo border-opacity-10 px-2 text-uppercase" style="font-size: 0.65rem;">{{ $coaching->subscription_plan }}</span>
                                        <span class="ms-1"><i class="far fa-calendar-alt me-1"></i>Expires: {{ $coaching->expiry_date ? \Carbon\Carbon::parse($coaching->expiry_date)->format('d M, Y') : 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-medium small">{{ $coaching->owner_name }}</div>
                            <div class="text-muted small">{{ $coaching->mobile }}</div>
                        </td>
                        <td><code class="bg-light px-2 py-1 rounded text-primary small">{{ $coaching->database_name }}</code></td>
                        <td>
                            @if($coaching->status === 'active')
                                <span class="badge bg-soft-success text-success border border-success border-opacity-25 px-3 py-2 rounded-pill fw-bold">ACTIVE</span>
                            @else
                                <span class="badge bg-soft-danger text-danger border border-danger border-opacity-25 px-3 py-2 rounded-pill fw-bold">INACTIVE</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.coachings.edit', $coaching) }}" class="btn btn-sm btn-outline-warning rounded-3" title="Edit Account">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                @if($coaching->status === 'active')
                                <form action="{{ route('admin.coachings.deactivate', $coaching) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-secondary rounded-3" title="Suspend Access">
                                        <i class="fas fa-pause-circle"></i>
                                    </button>
                                </form>
                                @else
                                <form action="{{ route('admin.coachings.activate', $coaching) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-success rounded-3" title="Reactivate">
                                        <i class="fas fa-play-circle"></i>
                                    </button>
                                </form>
                                @endif
                                
                                <form action="{{ route('admin.coachings.destroy', $coaching) }}" method="POST" onsubmit="return confirm('WARNING: This will permanently DELETE the institute and its isolated DATABASE. Proceed?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="Terminate Account">
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

<style>
    .bg-soft-success { background: rgba(16, 185, 129, 0.1); }
    .bg-soft-danger { background: rgba(244, 63, 94, 0.1); }
</style>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#coachingsTable').DataTable({
            responsive: true,
            language: {
                search: "",
                searchPlaceholder: "Search institutes...",
                paginate: {
                    next: '<i class="fas fa-chevron-right"></i>',
                    previous: '<i class="fas fa-chevron-left"></i>'
                }
            }
        });
    });
</script>
@endpush
