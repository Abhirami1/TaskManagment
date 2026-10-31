<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Models\{Task, User, Role};
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::with('assignee')
            ->search($request->search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.tasks.index', compact('tasks'));
    }

    public function create()
    {
        $staff = User::where('role_id', Role::STAFF)->where('status', 'active')->get();
        return view('admin.tasks.create', compact('staff'));
    }

    public function store(TaskRequest $request)
    {
        Task::create($request->validated() + ['created_by' => auth()->id()]);
        return redirect()->route('admin.tasks.index')->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        $task->load('assignee', 'creator');
        return view('admin.tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $staff = User::where('role_id', Role::STAFF)->where('status', 'active')->get();
        return view('admin.tasks.edit', compact('task', 'staff'));
    }

    public function update(TaskRequest $request, Task $task)
    {
        $task->update($request->validated());
        return redirect()->route('admin.tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('admin.tasks.index')->with('success', 'Task deleted successfully.');
    }
}