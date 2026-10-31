<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Task Manager')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <button class="btn btn-outline-light d-md-none" data-bs-toggle="collapse" data-bs-target="#sidebar">☰</button>
        <span class="navbar-brand mb-0 h1">Task Manager</span>
        <div class="d-flex align-items-center text-white">
            <span class="me-3">{{ auth()->user()->name }} ({{ auth()->user()->role->name }})</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-sm btn-danger">Logout</button>
            </form>
        </div>
    </div>
</nav>

<div class="container-fluid flex-grow-1">
    <div class="row">
        <aside id="sidebar" class="col-md-2 bg-light border-end collapse d-md-block p-3">
            <ul class="nav flex-column">
                @if(auth()->user()->isAdmin())
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.staff.index') }}">Staff</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.tasks.index') }}">Tasks</a></li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('staff.dashboard') }}">My Tasks</a></li>
                @endif
            </ul>
        </aside>

        <main class="col-md-10 p-4">
            @include('partials.alerts')
            @yield('content')
        </main>
    </div>
</div>

<footer class="bg-dark text-white text-center py-2 mt-auto">
    &copy; {{ date('Y') }} Task Manager
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>