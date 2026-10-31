@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Staff List</h3>
    <a href="{{ route('admin.staff.create') }}" class="btn btn-primary">Add Staff</a>
</div>

<div class="table-responsive">
<table class="table table-bordered table-striped align-middle">
    <thead><tr><th>#</th><th>Name</th><th>Email</th><th>Status</th><th width="220">Actions</th></tr></thead>
    <tbody>
    @forelse($staff as $s)
        <tr>
            <td>{{ $s->id }}</td>
            <td>{{ $s->name }}</td>
            <td>{{ $s->email }}</td>
            <td><span class="badge bg-{{ $s->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($s->status) }}</span></td>
            <td>
                <a href="{{ route('admin.staff.show', $s) }}" class="btn btn-sm btn-info">View</a>
                <a href="{{ route('admin.staff.edit', $s) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('admin.staff.destroy', $s) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Are you sure you want to delete this staff?');">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="5" class="text-center">No staff found.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
{{ $staff->links('pagination::bootstrap-5') }}
@endsection