<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StaffRequest;
use App\Http\Resources\StaffResource;
use App\Models\{Role, User};
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    use ApiResponse;

    private function ensureStaff(User $staff): void
    {
        abort_unless($staff->role_id === Role::STAFF, 404);
    }

    public function index(Request $request)
    {
        $request->validate([
            'status'   => 'nullable|in:active,inactive',
            'sort_by'  => 'nullable|in:id,name,email,status,created_at',
            'sort_dir' => 'nullable|in:asc,desc',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        $staff = User::where('role_id', Role::STAFF)
            ->when($request->search, fn ($q, $s) => $q->where(
                fn ($w) => $w->where('name', 'like', "%{$s}%")->orWhere('email', 'like', "%{$s}%")
            ))
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->orderBy($request->get('sort_by', 'created_at'), $request->get('sort_dir', 'desc'))
            ->paginate($request->get('per_page', 10))
            ->withQueryString();

        return $this->paginated($staff, StaffResource::class, 'Staff list fetched successfully.');
    }

    public function store(StaffRequest $request)
    {
        $staff = User::create($request->validated() + ['role_id' => Role::STAFF]);

        return $this->success((new StaffResource($staff))->resolve(), 'Staff created successfully.', 201);
    }

    public function show(User $staff)
    {
        $this->ensureStaff($staff);

        return $this->success((new StaffResource($staff))->resolve(), 'Staff fetched successfully.');
    }

    public function update(StaffRequest $request, User $staff)
    {
        $this->ensureStaff($staff);

        $data = $request->validated();
        if (empty($data['password'])) {
            unset($data['password']);
        }

        $staff->update($data);

        return $this->success((new StaffResource($staff->fresh()))->resolve(), 'Staff updated successfully.');
    }

    public function destroy(User $staff)
    {
        $this->ensureStaff($staff);

        $staff->tokens()->delete(); // revoke their API tokens
        $staff->delete();           // soft delete

        return $this->success(null, 'Staff deleted successfully.');
    }
}