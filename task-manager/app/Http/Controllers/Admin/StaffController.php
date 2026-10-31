<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StaffRequest;
use App\Models\{User, Role};

class StaffController extends Controller
{
    public function index()
    {
        $staff = User::where('role_id', Role::STAFF)->latest()->paginate(10);
        return view('admin.staff.index', compact('staff'));
    }

    public function create()
    {
        return view('admin.staff.create');
    }

    public function store(StaffRequest $request)
    {
        User::create($request->validated() + ['role_id' => Role::STAFF]);
        return redirect()->route('admin.staff.index')->with('success', 'Staff created successfully.');
    }

    public function show(User $staff)
    {
        abort_unless($staff->role_id === Role::STAFF, 404);
        $tasks = $staff->assignedTasks()->latest()->get();
        return view('admin.staff.show', compact('staff', 'tasks'));
    }

    public function edit(User $staff)
    {
        abort_unless($staff->role_id === Role::STAFF, 404);
        return view('admin.staff.edit', compact('staff'));
    }

    public function update(StaffRequest $request, User $staff)
    {
        abort_unless($staff->role_id === Role::STAFF, 404);

        $data = $request->validated();
        if (empty($data['password'])) {
            unset($data['password']); // keep old password
        }

        $staff->update($data);
        return redirect()->route('admin.staff.index')->with('success', 'Staff updated successfully.');
    }

    public function destroy(User $staff)
    {
        abort_unless($staff->role_id === Role::STAFF, 404);
        $staff->delete(); // soft delete
        return redirect()->route('admin.staff.index')->with('success', 'Staff deleted successfully.');
    }
}