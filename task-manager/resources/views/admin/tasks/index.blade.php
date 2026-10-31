@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Task List</h3>
    <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary">Create Task</a>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-sm-6 col-md-4">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by title...">
    </div>
    <div class="col-auto">
        <button class="btn btn-outline-primary">Search</button>
        <a href="{{ route('admin.tasks.index') }}" class="btn btn-outline-secondary">Reset</a>
    </div>
</form>

<div class="table-responsive">
<table class="table table-bordered table-striped align-middle">
    <thead><tr><th>#</th><th>Title</th><th>Assigned To</th><th>Status</th><th width="220">Actions</th></tr></thead>
    <tbody>
    @forelse($tasks as $task)
        <tr>
            <td>{{ $task->id }}</td>
            <td>{{ $task->title }}</td>
            <td>{{ $task->assignee?->name ?? '-' }}</td>
            <td><span class="badge bg-{{ $task->status === 'open' ? 'warning' : 'success' }}">{{ ucfirst($task->status) }}</span></td>
            <td>
                <a href="{{ route('admin.tasks.show', $task) }}" class="btn btn-sm btn-info">View</a>
                <a href="{{ route('admin.tasks.edit', $task) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('admin.tasks.destroy', $task) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Delete this task?');">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="5" class="text-center">No tasks found.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
{{ $tasks->links('pagination::bootstrap-5') }}
@endsection