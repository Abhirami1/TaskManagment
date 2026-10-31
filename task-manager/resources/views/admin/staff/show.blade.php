@extends('layouts.app')
@section('content')
<h3>Staff Details</h3>
<table class="table table-bordered w-auto">
    <tr><th>Name</th><td>{{ $staff->name }}</td></tr>
    <tr><th>Email</th><td>{{ $staff->email }}</td></tr>
    <tr><th>Status</th><td>{{ ucfirst($staff->status) }}</td></tr>
    <tr><th>Created</th><td>{{ $staff->created_at->format('d M Y') }}</td></tr>
</table>

<h5 class="mt-4">Assigned Tasks ({{ $tasks->count() }})</h5>
<ul class="list-group mb-3">
    @forelse($tasks as $t)
        <li class="list-group-item d-flex justify-content-between">
            {{ $t->title }}
            <span class="badge bg-{{ $t->status === 'open' ? 'warning' : 'success' }}">{{ ucfirst($t->status) }}</span>
        </li>
    @empty
        <li class="list-group-item">No tasks assigned.</li>
    @endforelse
</ul>
<a href="{{ route('admin.staff.index') }}" class="btn btn-secondary">Back</a>
@endsection