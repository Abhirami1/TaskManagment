@extends('layouts.app')
@section('content')
<h3>Edit Staff</h3>
<form method="POST" action="{{ route('admin.staff.update', $staff) }}">
    @csrf @method('PUT')
    @include('admin.staff._form')
    <button class="btn btn-primary">Update</button>
    <a href="{{ route('admin.staff.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection