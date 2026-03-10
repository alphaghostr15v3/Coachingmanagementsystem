@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 animate__animated animate__fadeIn">
    <div>
        <h2 class="fw-bold mb-1">User Roles & Management</h2>
        <p class="text-muted small mb-0">Manage system-level administrators and their access roles.</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-gradient px-4">
        <i class="fas fa-user-plus me-2"></i> Create New User
    </a>
</div>

<div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle custom-table" id="usersTable">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0 rounded-start">User Info</th>
                        <th class="border-0">Email</th>
                        <th class="border-0">Role</th>
                        <th class="border-0">Created At</th>
                        <th class="border-0 text-end rounded-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-soft-indigo text-indigo rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $user->name }}</div>
                                    @if($user->id === auth()->id())
                                        <span class="badge bg-soft-success text-success small">You</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->role === 'super_admin')
                                <span class="badge bg-indigo text-white px-3 py-2 rounded-pill small">Super Admin</span>
                            @else
                                <span class="badge bg-soft-indigo text-indigo px-3 py-2 rounded-pill small">Coaching Admin</span>
                            @endif
                        </td>
                        <td class="text-muted small">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-warning rounded-3" title="Edit User">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('{{ $user->role === 'coaching_admin' ? 'WARNING: Deleting this Coaching Admin will also PERMANENTLY DELETE their Institute and Database. Proceed?' : 'Are you sure you want to delete this user?' }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="Delete User">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
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
    .bg-soft-success { background: rgba(16, 185, 129, 0.1); }
    .text-success { color: #10b981; }
    .custom-table th { font-weight: 600; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px; padding: 15px 20px; }
    .custom-table td { padding: 20px; border-bottom: 1px solid rgba(0,0,0,0.02); }
    .badge { font-weight: 600; letter-spacing: 0.3px; }
</style>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#usersTable').DataTable({
            responsive: true,
            pageLength: 10,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search users..."
            }
        });
    });
</script>
@endpush
