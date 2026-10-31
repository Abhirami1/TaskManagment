{{-- create.blade.php --}}
@extends('layouts.app')
@section('content')
<h3>Create Task</h3>
<form method="POST" action="{{ route('admin.tasks.store') }}">
    @csrf
    @include('admin.tasks._form')
    <button class="btn btn-primary">Save</button>
    <a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection