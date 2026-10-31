@extends('layouts.app')
@section('content')
<h3>Task Details</h3>
<table class="table table-bordered">
    <tr><th width="200">Title</th><td>{{ $task->title }}</td></tr>
    <tr><th>Description</th><td>{{ $task->description ?? '-' }}</td></tr>
    <tr><th>Current Status</th><td>{{ ucfirst($task->status) }}</td></tr>
</table>

<form method="POST" action="{{ route('staff.tasks.update', $task) }}" class="row g-2 align-items-end">
    @csrf @method('PUT')
    <div class="col-sm-4">
        <label class="form-label">Update Status</label>
        <select name="status" class="form-select @error('status') is-invalid @enderror">
            <option value="open" @selected($task->status === 'open')>Open</option>
            <option value="completed" @selected($task->status === 'completed')>Completed</option>
        </select>
        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-auto">
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('staff.dashboard') }}" class="btn btn-secondary">Back</a>
    </div>
</form>
@endsection