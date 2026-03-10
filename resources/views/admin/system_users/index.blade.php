@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 animate__animated animate__fadeIn">
    <div>
        <h2 class="fw-bold mb-1">Global System Users</h2>
        <p class="text-muted small mb-0">Cross-institute management of Students and Teachers.</p>
    </div>
    <a href="{{ route('admin.system-users.create') }}" class="btn btn-gradient px-4">
        <i class="fas fa-plus-circle me-2"></i> Register New User
    </a>
</div>

<div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle custom-table" id="systemUsersTable">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0 rounded-start">User Info</th>
                        <th class="border-0">Institute</th>
                        <th class="border-0">Role</th>
                        <th class="border-0">Status</th>
                        <th class="border-0 text-end rounded-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm {{ $user->role === 'student' ? 'bg-soft-sky text-sky' : 'bg-soft-indigo text-indigo' }} rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    <i class="fas {{ $user->role === 'student' ? 'fa-user-graduate' : 'fa-chalkboard-teacher' }}"></i>
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $user->name }}</div>
                                    <div class="text-muted small">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="fw-medium text-dark">{{ $user->coaching->coaching_name ?? 'N/A' }}</span>
                        </td>
                        <td>
                            @if($user->role === 'student')
                                <span class="badge bg-soft-sky text-sky px-3 py-2 rounded-pill small">Student</span>
                            @else
                                <span class="badge bg-soft-indigo text-indigo px-3 py-2 rounded-pill small">Teacher</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-success-subtle text-success px-2 py-1 small"><i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i> Active</span>
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.system-users.edit', $user) }}" class="btn btn-sm btn-outline-warning rounded-3" title="Edit User">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.system-users.destroy', $user) }}" method="POST" onsubmit="return confirm('Deleting this user will also remove them from their institute database. Proceed?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="Delete User">
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
    .bg-soft-indigo { background: rgba(79, 70, 229, 0.1); }
    .text-indigo { color: #4f46e5; }
    .bg-soft-sky { background: rgba(14, 165, 233, 0.1); }
    .text-sky { color: #0ea5e9; }
    .custom-table th { font-weight: 600; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px; padding: 15px 20px; }
    .custom-table td { padding: 20px; border-bottom: 1px solid rgba(0,0,0,0.02); }
    
    /* Fix for dropdown menus being cut off by table-responsive */
    .table-responsive {
        overflow: visible !important;
    }
</style>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#systemUsersTable').DataTable({
            responsive: true,
            pageLength: 10,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Quick search users..."
            }
        });
    });
</script>
@endpush
