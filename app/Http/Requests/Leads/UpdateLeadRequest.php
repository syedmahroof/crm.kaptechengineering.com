<?php

namespace App\Http\Requests\Leads;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Lead;
use Illuminate\Validation\Rule;

class UpdateLeadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        if (!$user) {
            return false;
        }

        $lead = $this->route('lead');

        if ($lead instanceof Lead) {
            return $user->can('update', $lead);
        }

        return $user->can('edit leads');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('leads', 'email')->ignore($this->route('lead'))
            ],
            'phone' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('leads', 'phone')->ignore($this->route('lead'))
            ],
            'job_title' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'lead_source_id' => 'nullable|exists:lead_sources,id',
            'lead_priority_id' => 'nullable|exists:lead_priorities,id',
            'assigned_user_id' => 'nullable|exists:users,id',
            'lead_status_id' => 'nullable|exists:lead_statuses,id',
            'business_type_id' => 'nullable|exists:business_types,id',
            'branch_id' => 'nullable|exists:branches,id',
            'project_ids' => 'nullable|array',
            'project_ids.*' => 'exists:projects,id',
            'customer_ids' => 'nullable|array',
            'customer_ids.*' => 'exists:customers,id',
            'contact_ids' => 'nullable|array',
            'contact_ids.*' => 'exists:contacts,id',
            'description' => 'nullable|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.unique' => 'A lead with this email already exists.',
            'phone.unique' => 'A lead with this phone number already exists.',
            'status.in' => 'The selected status is invalid.',
            'lead_source_id.exists' => 'The selected lead source is invalid.',
            'lead_priority_id.exists' => 'The selected priority is invalid.',
            'assigned_user_id.exists' => 'The selected user is invalid.',
        ];
    }
}
