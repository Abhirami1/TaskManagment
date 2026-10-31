<?php
namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tasks = auth()->user()->assignedTasks()
            ->search($request->search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('staff.dashboard', compact('tasks'));
    }
}