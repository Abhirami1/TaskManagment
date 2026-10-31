@extends('layouts.app')
@section('content')
<h3 class="mb-4">Admin Dashboard</h3>
<div class="row g-3">
    <div class="col-md-3"><div class="card text-bg-primary"><div class="card-body">
        <h6>Total Staff</h6><h2>{{ $totalStaff }}</h2></div></div></div>
    <div class="col-md-3"><div class="card text-bg-secondary"><div class="card-body">
        <h6>Total Tasks</h6><h2>{{ $totalTasks }}</h2></div></div></div>
    <div class="col-md-3"><div class="card text-bg-warning"><div class="card-body">
        <h6>Open Tasks</h6><h2>{{ $openTasks }}</h2></div></div></div>
    <div class="col-md-3"><div class="card text-bg-success"><div class="card-body">
        <h6>Closed Tasks</h6><h2>{{ $closedTasks }}</h2></div></div></div>
</div>
@endsection