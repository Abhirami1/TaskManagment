@extends('layouts.app')
@section('content')
<h3>My Assigned Tasks</h3>

<form method="GET" class="row g-2 mb-3">
    <div class="col-sm-6 col-md-4">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by title...">
    </div>
    <div class="col-auto"><button class="btn btn-outline-primary">Search</button></div>
</form>

<div class="table-responsive">
<table class="table table-bordered table-striped">
    <thead><tr><th>#</th><th>Title</th><th>Status</th><th>Action</th></tr></thead>
    <tbody>
    @forelse($tasks as $task)
        <tr>
            <td>{{ $task->id }}</td>
            <td>{{ $task->title }}</td>
            <td><span class="badge bg-{{ $task->status === 'open' ? 'warning' : 'success' }}">{{ ucfirst($task->status) }}</span></td>
            <td><a href="{{ route('staff.tasks.show', $task) }}" class="btn btn-sm btn-info">View / Update</a></td>
        </tr>
    @empty
        <tr><td colspan="4" class="text-center">No tasks assigned to you.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
{{ $tasks->links('pagination::bootstrap-5') }}
@endsection