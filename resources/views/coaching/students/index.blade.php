@extends('layouts.coaching')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 animate__animated animate__fadeIn">
    <div>
        <h2 class="fw-bold mb-1">Student Management</h2>
        <p class="text-muted small">View and manage all registered students in your institute.</p>
    </div>
    <a href="{{ route('coaching.students.create') }}" class="btn btn-primary shadow-sm px-4">
        <i class="fas fa-plus me-2"></i> Add New Student
    </a>
</div>

<div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="studentsTable">
                <thead>
                    <tr>
                        <th class="text-secondary small text-uppercase">#</th>
                        <th class="text-secondary small text-uppercase">Student Detail</th>
                        <th class="text-secondary small text-uppercase">Course</th>
                        <th class="text-secondary small text-uppercase">Contact Info</th>
                        <th class="text-secondary small text-uppercase">Address</th>
                        <th class="text-center text-secondary small text-uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    <tr class="animate__animated animate__fadeInUp" style="animation-delay: {{ $loop->iteration * 0.05 }}s">
                        <td class="text-secondary">{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($student->profile_image)
                                    <img src="{{ asset($student->profile_image) }}" alt="{{ $student->name }}" class="rounded-circle shadow-sm me-3 profile-img-hover" style="width: 40px; height: 40px; object-fit: cover;">
                                @else
                                    <div class="avatar-sm bg-soft-primary text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        {{ substr($student->name, 0, 1) }}
                                    </div>
                                @endif
                                <span class="fw-bold">{{ $student->name }}</span>
                            </div>
                        </td>
                        <td>
                            @if($student->course)
                                <span class="badge bg-soft-info text-info">{{ $student->course->name }}</span>
                            @else
                                <span class="text-muted small">Not Assigned</span>
                            @endif
                        </td>
                        <td>
                            <div class="small fw-medium">{{ $student->email ?? 'no-email@example.com' }}</div>
                            <div class="small text-muted">{{ $student->phone ?? 'N/A' }}</div>
                        </td>
                        <td><span class="small text-muted">{{ Str::limit($student->address ?? 'N/A', 30) }}</span></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('coaching.students.edit', $student) }}" class="btn btn-sm btn-outline-warning rounded-3" title="Edit Profile">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('coaching.students.destroy', $student) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this student?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="Delete Student">
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
    .profile-img-hover { transition: transform 0.3s ease; }
    .profile-img-hover:hover { transform: scale(1.1); }
    #studentsTable_wrapper .dataTables_filter input {
        border-radius: 10px;
        padding: 8px 15px;
        border: 1px solid #e2e8f0;
        margin-left: 10px;
    }
</style>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#studentsTable').DataTable({
            responsive: true,
            language: {
                search: "",
                searchPlaceholder: "Search students...",
                paginate: {
                    next: '<i class="fas fa-chevron-right"></i>',
                    previous: '<i class="fas fa-chevron-left"></i>'
                }
            }
        });
    });
</script>
@endpush
