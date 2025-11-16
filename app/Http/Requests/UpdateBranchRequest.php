<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBranchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $branchId = $this->route('branch')->id;

        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:branches,code,' . $branchId,
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'manager_name' => 'nullable|string|max:255',
            'manager_phone' => 'nullable|string|max:20',
            'manager_email' => 'nullable|email|max:255',
            'is_active' => 'boolean',
            'description' => 'nullable|string',
            'timezone' => 'required|string|max:50',
            'working_hours' => 'nullable|array',
            'working_hours.*.is_open' => 'boolean',
            'working_hours.*.open_time' => 'required_with:working_hours.*.is_open|date_format:H:i',
            'working_hours.*.close_time' => 'required_with:working_hours.*.is_open|date_format:H:i|after:working_hours.*.open_time',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Branch name is required.',
            'code.required' => 'Branch code is required.',
            'code.unique' => 'This branch code is already taken.',
            'email.email' => 'Please enter a valid email address.',
            'manager_email.email' => 'Please enter a valid manager email address.',
            'timezone.required' => 'Timezone is required.',
            'working_hours.*.open_time.required_with' => 'Open time is required when day is marked as open.',
            'working_hours.*.close_time.required_with' => 'Close time is required when day is marked as open.',
            'working_hours.*.close_time.after' => 'Close time must be after open time.',
        ];
    }
}
