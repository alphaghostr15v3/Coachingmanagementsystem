@extends('layouts.coaching')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 animate__animated animate__fadeIn">
    <div>
        <h2 class="fw-bold mb-1">Faculty Directory</h2>
        <p class="text-muted small">Manage non-teaching staff, departments, and designations.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('coaching.departments.index') }}" class="btn btn-outline-primary rounded-pill px-4 shadow-sm">
            <i class="fas fa-sitemap me-2"></i> Departments
        </a>
        <a href="{{ route('coaching.designations.index') }}" class="btn btn-outline-primary rounded-pill px-4 shadow-sm">
            <i class="fas fa-id-badge me-2"></i> Designations
        </a>
        <a href="{{ route('coaching.faculties.create') }}" class="btn btn-primary rounded-pill shadow-sm px-4">
            <i class="fas fa-plus me-2"></i> Add Faculty Member
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="facultiesTable">
                <thead>
                    <tr>
                        <th class="text-secondary small text-uppercase">#</th>
                        <th class="text-secondary small text-uppercase">Faculty Detail</th>
                        <th class="text-secondary small text-uppercase">Role & Dept</th>
                        <th class="text-secondary small text-uppercase">Status</th>
                        <th class="text-center text-secondary small text-uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($faculties as $faculty)
                    <tr>
                        <td class="text-secondary">{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-soft-info text-info rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div>
                                    <span class="fw-bold d-block">{{ $faculty->name }}</span>
                                    <small class="text-muted">{{ $faculty->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold small">{{ $faculty->designation->title ?? 'Staff' }}</div>
                            <div class="small text-info">{{ $faculty->department->name ?? 'General' }}</div>
                        </td>
                        <td>
                            <span class="badge {{ $faculty->status == 'Active' ? 'bg-soft-success text-success' : 'bg-soft-danger text-danger' }} border px-3 py-1 rounded-pill small">
                                {{ $faculty->status }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('coaching.faculties.edit', $faculty) }}" class="btn btn-sm btn-outline-warning rounded-3" title="Edit Profile">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('coaching.faculties.destroy', $faculty) }}" method="POST" onsubmit="return confirm('Delete this faculty profile?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="Remove Faculty">
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
        $('#facultiesTable').DataTable({
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
