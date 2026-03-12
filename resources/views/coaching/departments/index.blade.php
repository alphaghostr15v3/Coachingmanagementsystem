@extends('layouts.coaching')

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Departments</h2>
            <p class="text-muted small">Organize your faculty into specialized departments.</p>
        </div>
        <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#addDeptModal">
            <i class="fas fa-plus me-2"></i> Create Department
        </button>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">#</th>
                                    <th>Department Name</th>
                                    <th>Description</th>
                                    <th>Faculty Count</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($departments as $dept)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-bold">{{ $dept->name }}</td>
                                    <td>{{ $dept->description ?? 'No description' }}</td>
                                    <td>
                                        <span class="badge bg-soft-info text-info rounded-pill px-3">{{ $dept->teachers->count() }} Members</span>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-warning rounded-3 me-2" onclick="editDept({{ $dept->id }}, '{{ $dept->name }}', '{{ $dept->description }}')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('coaching.departments.destroy', $dept) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this department?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger rounded-3"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">No departments found. Create your first one above.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addDeptModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <form action="{{ route('coaching.departments.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-bold">New Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-secondary">Department Name</label>
                        <input type="text" name="name" class="form-control border-0 bg-light rounded-3" required placeholder="e.g. Science">
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold small text-uppercase text-secondary">Description</label>
                        <textarea name="description" class="form-control border-0 bg-light rounded-3" rows="3" placeholder="Optional description..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow">Save Department</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editDeptModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <form id="editDeptForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-bold">Edit Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-secondary">Department Name</label>
                        <input type="text" name="name" id="edit_name" class="form-control border-0 bg-light rounded-3" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold small text-uppercase text-secondary">Description</label>
                        <textarea name="description" id="edit_description" class="form-control border-0 bg-light rounded-3" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow">Update Department</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function editDept(id, name, desc) {
        $('#editDeptForm').attr('action', `/coaching/departments/${id}`);
        $('#edit_name').val(name);
        $('#edit_description').val(desc);
        new bootstrap.Modal(document.getElementById('editDeptModal')).show();
    }
</script>
@endpush
