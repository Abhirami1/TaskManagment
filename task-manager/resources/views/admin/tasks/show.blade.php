@extends('layouts.app')
@section('content')
<h3>Task Details</h3>
<table class="table table-bordered">
    <tr><th width="200">Title</th><td>{{ $task->title }}</td></tr>
    <tr><th>Description</th><td>{{ $task->description ?? '-' }}</td></tr>
    <tr><th>Status</th><td>{{ ucfirst($task->status) }}</td></tr>
    <tr><th>Assigned To</th><td>{{ $task->assignee?->name ?? '-' }}</td></tr>
    <tr><th>Created By</th><td>{{ $task->creator?->name }}</td></tr>
    <tr><th>Created At</th><td>{{ $task->created_at->format('d M Y, h:i A') }}</td></tr>
</table>
<a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary">Back</a>
@endsection