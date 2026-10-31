<?php
namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private function ownTask(Task $task): Task
    {
        abort_unless($task->assigned_to === auth()->id(), 403, 'This task is not assigned to you.');
        return $task;
    }

    public function show(Task $task)
    {
        $this->ownTask($task);
        return view('staff.tasks.show', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $this->ownTask($task);

        $data = $request->validate(['status' => 'required|in:open,completed']);
        $task->update(['status' => $data['status']]); // status ONLY

        return redirect()->route('staff.dashboard')->with('success', 'Task status updated.');
    }
}