<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    use ApiResponse;

    private function ensureCanAccess(Request $request, Task $task): void
    {
        $user = $request->user();
        abort_if($user->isStaff() && $task->assigned_to !== $user->id, 403, 'This task is not assigned to you.');
    }

    public function index(Request $request)
    {
        $request->validate([
            'status'      => 'nullable|in:open,completed',
            'assigned_to' => 'nullable|integer',
            'sort_by'     => 'nullable|in:id,title,status,created_at,updated_at',
            'sort_dir'    => 'nullable|in:asc,desc',
            'per_page'    => 'nullable|integer|min:1|max:100',
            'date_from'   => 'nullable|date',
            'date_to'     => 'nullable|date',
        ]);

        $user = $request->user();

        $tasks = Task::with('assignee')
            ->when($user->isStaff(), fn ($q) => $q->where('assigned_to', $user->id)) // staff: own tasks only
            ->search($request->search)
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->when($user->isAdmin() && $request->assigned_to, fn ($q) => $q->where('assigned_to', $request->assigned_to))
            ->when($request->date_from, fn ($q, $d) => $q->whereDate('created_at', '>=', $d))
            ->when($request->date_to, fn ($q, $d) => $q->whereDate('created_at', '<=', $d))
            ->orderBy($request->get('sort_by', 'created_at'), $request->get('sort_dir', 'desc'))
            ->paginate($request->get('per_page', 10))
            ->withQueryString();

        return $this->paginated($tasks, TaskResource::class, 'Tasks fetched successfully.');
    }

    public function store(TaskRequest $request)
    {
        $task = Task::create($request->validated() + ['created_by' => $request->user()->id]);
        $task->load('assignee', 'creator');

        return $this->success((new TaskResource($task))->resolve(), 'Task created successfully.', 201);
    }

    public function show(Request $request, Task $task)
    {
        $this->ensureCanAccess($request, $task);
        $task->load('assignee', 'creator');

        return $this->success((new TaskResource($task))->resolve(), 'Task fetched successfully.');
    }

    public function update(Request $request, Task $task)
    {
        $this->ensureCanAccess($request, $task);

        if ($request->user()->isStaff()) {
            // staff: status ONLY, any other field in the request is ignored
            $data = $request->validate(['status' => 'required|in:open,completed']);
            $task->update(['status' => $data['status']]);
        } else {
            $task->update($request->validate((new TaskRequest)->rules()));
        }

        $task->load('assignee', 'creator');

        return $this->success((new TaskResource($task))->resolve(), 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return $this->success(null, 'Task deleted successfully.');
    }
}