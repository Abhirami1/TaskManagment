<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StaffRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // route middleware already checks the role
    }

    public function rules(): array
    {
        $staff = $this->route('staff'); // null on create

        return [
            'name'   => 'required|string|max:255',
            'email'  => ['required', 'email', Rule::unique('users', 'email')->ignore($staff?->id)],
            'password' => [$staff ? 'nullable' : 'required', 'string', 'min:8'],
            'status' => 'required|in:active,inactive',
        ];
    }
}