<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, Task};

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalStaff'  => User::where('role_id', 2)->count(),
            'totalTasks'  => Task::count(),
            'openTasks'   => Task::where('status', 'open')->count(),
            'closedTasks' => Task::where('status', 'completed')->count(),
        ]);
    }
}