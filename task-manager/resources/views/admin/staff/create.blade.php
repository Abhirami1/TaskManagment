@extends('layouts.app')
@section('content')
<h3>Add Staff</h3>
<form method="POST" action="{{ route('admin.staff.store') }}">
    @csrf
    @include('admin.staff._form')
    <button class="btn btn-primary">Save</button>
    <a href="{{ route('admin.staff.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection