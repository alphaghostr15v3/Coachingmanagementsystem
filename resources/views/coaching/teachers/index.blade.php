@extends('layouts.coaching')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 animate__animated animate__fadeIn">
    <div>
        <h2 class="fw-bold mb-1">Faculty Directory</h2>
        <p class="text-muted small">Manage faculty profiles, departments, and designations.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('coaching.departments.index') }}" class="btn btn-outline-primary rounded-pill px-4 shadow-sm">
            <i class="fas fa-sitemap me-2"></i> Departments
        </a>
        <a href="{{ route('coaching.designations.index') }}" class="btn btn-outline-primary rounded-pill px-4 shadow-sm">
            <i class="fas fa-id-badge me-2"></i> Designations
        </a>
        <a href="{{ route('coaching.teachers.create') }}" class="btn btn-primary rounded-pill shadow-sm px-4">
            <i class="fas fa-plus me-2"></i> Add Faculty Member
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="teachersTable">
                <thead>
                    <tr>
                        <th class="text-secondary small text-uppercase">#</th>
                        <th class="text-secondary small text-uppercase">Faculty Detail</th>
                        <th class="text-secondary small text-uppercase">Role & Dept</th>
                        <th class="text-secondary small text-uppercase">Staff Type</th>
                        <th class="text-secondary small text-uppercase">Status</th>
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
                                <div>
                                    <span class="fw-bold d-block">{{ $teacher->name }}</span>
                                    <small class="text-muted">{{ $teacher->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold small">{{ $teacher->designation->title ?? 'Faculty' }}</div>
                            <div class="small text-info">{{ $teacher->department->name ?? $teacher->subject ?? 'General' }}</div>
                        </td>
                        <td>
                            <span class="badge {{ $teacher->staff_type == 'Teaching' ? 'bg-soft-primary text-primary' : 'bg-soft-secondary text-secondary' }} border px-3 py-1 rounded-pill small">
                                {{ $teacher->staff_type }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $teacher->status == 'Active' ? 'bg-soft-success text-success' : 'bg-soft-danger text-danger' }} border px-3 py-1 rounded-pill small">
                                {{ $teacher->status }}
                            </span>
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
