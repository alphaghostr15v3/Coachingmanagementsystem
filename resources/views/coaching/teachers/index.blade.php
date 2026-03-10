@extends('layouts.coaching')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 animate__animated animate__fadeIn">
    <div>
        <h2 class="fw-bold mb-1">Teacher Directory</h2>
        <p class="text-muted small">Manage faculty profiles and specializations.</p>
    </div>
    <a href="{{ route('coaching.teachers.create') }}" class="btn btn-primary shadow-sm px-4">
        <i class="fas fa-plus me-2"></i> Add New Teacher
    </a>
</div>

<div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="teachersTable">
                <thead>
                    <tr>
                        <th class="text-secondary small text-uppercase">#</th>
                        <th class="text-secondary small text-uppercase">Teacher Detail</th>
                        <th class="text-secondary small text-uppercase">Specialization</th>
                        <th class="text-secondary small text-uppercase">Contact</th>
                        <th class="text-center text-secondary small text-uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teachers as $teacher)
                    <tr>
                        <td class="text-secondary">{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-soft-info text-info rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <span class="fw-bold">{{ $teacher->name }}</span>
                            </div>
                        </td>
                        <td><span class="badge bg-soft-info text-info border border-info px-3 py-2 rounded-pill">{{ $teacher->subject ?? 'General' }}</span></td>
                        <td>
                            <div class="small fw-medium">{{ $teacher->email ?? 'N/A' }}</div>
                            <div class="small text-muted">{{ $teacher->phone ?? 'N/A' }}</div>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('coaching.teachers.edit', $teacher) }}" class="btn btn-sm btn-outline-warning rounded-3" title="Edit Profile">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('coaching.teachers.destroy', $teacher) }}" method="POST" onsubmit="return confirm('Delete this teacher profile?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="Remove Teacher">
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
    .bg-soft-info { background: rgba(13, 202, 240, 0.1); }
</style>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#teachersTable').DataTable({
            responsive: true,
            language: {
                search: "",
                searchPlaceholder: "Search faculty...",
                paginate: {
                    next: '<i class="fas fa-chevron-right"></i>',
                    previous: '<i class="fas fa-chevron-left"></i>'
                }
            }
        });
    });
</script>
@endpush
