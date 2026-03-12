@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Coaching Account Details</h2>
    <a href="{{ route('admin.coachings.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">General Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">Coaching Name:</th>
                        <td>{{ $coaching->coaching_name }}</td>
                    </tr>
                    <tr>
                        <th>Address:</th>
                        <td>{{ $coaching->address ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Owner Name:</th>
                        <td>{{ $coaching->owner_name }}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>{{ $coaching->email }}</td>
                    </tr>
                    <tr>
                        <th>Mobile:</th>
                        <td>{{ $coaching->mobile ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            @if($coaching->status === 'active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Subscription Plan:</th>
                        <td>{{ $coaching->subscription_plan ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Created Date:</th>
                        <td>{{ $coaching->created_at->format('d M, Y H:i:s') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white align-items-center d-flex justify-content-between">
                <h5 class="mb-0">Database Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Database Name:</strong> <span class="text-primary">{{ $coaching->database_name }}</span></p>
                <div class="alert alert-info">
                    Every coaching gets its own isolated tenant database. The system automatically creates this database and runs all tenant-specific migrations upon account creation. When deleting an account, the database is seamlessly dropped.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
