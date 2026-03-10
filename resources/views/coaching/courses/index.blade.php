@extends('layouts.coaching')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 animate__animated animate__fadeIn">
    <div>
        <h2 class="fw-bold mb-1">Course Catalog</h2>
        <p class="text-muted small">Manage available courses and their respective fees.</p>
    </div>
    <a href="{{ route('coaching.courses.create') }}" class="btn btn-primary shadow-sm px-4">
        <i class="fas fa-plus me-2"></i> New Course
    </a>
</div>

<div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="coursesTable">
                <thead>
                    <tr>
                        <th class="text-secondary small text-uppercase">#</th>
                        <th class="text-secondary small text-uppercase">Course Name</th>
                        <th class="text-secondary small text-uppercase">Description</th>
                        <th class="text-secondary small text-uppercase">Fee (Amount)</th>
                        <th class="text-center text-secondary small text-uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courses as $course)
                    <tr>
                        <td class="text-secondary">{{ $loop->iteration }}</td>
                        <td><span class="fw-bold text-dark">{{ $course->name }}</span></td>
                        <td><span class="small text-muted">{{ Str::limit($course->description ?? 'No description available.', 50) }}</span></td>
                        <td><span class="fw-bold text-success fs-5">₹{{ number_format($course->amount, 2) }}</span></td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light border dropdown-toggle px-3" type="button" data-bs-toggle="dropdown">
                                    Manage
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                                    <li><a class="dropdown-item py-2" href="{{ route('coaching.courses.edit', $course) }}"><i class="fas fa-edit text-warning me-2"></i> Edit Course</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('coaching.courses.destroy', $course) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item py-2 text-danger"><i class="fas fa-trash me-2"></i> Delete</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#coursesTable').DataTable({
            responsive: true,
            language: {
                search: "",
                searchPlaceholder: "Search courses...",
                paginate: {
                    next: '<i class="fas fa-chevron-right"></i>',
                    previous: '<i class="fas fa-chevron-left"></i>'
                }
            }
        });
    });
</script>
@endpush
