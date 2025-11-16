<?php

namespace App\Http\Requests\Leads;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Lead;

class StoreLeadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('create leads') ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:leads,email',
            'phone' => 'nullable|string|max:20|unique:leads,phone',
            'phone_code' => 'nullable|string|max:10',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'state_id' => 'nullable|exists:states,id',
            'country' => 'nullable|string|max:100',
            'country_id' => 'nullable|exists:countries,id',
            'postal_code' => 'nullable|string|max:20',
            'lead_source_id' => 'nullable|exists:lead_sources,id',
            'lead_priority_id' => 'nullable|exists:lead_priorities,id',
            'assigned_user_id' => 'nullable|exists:users,id',
            'lead_status_id' => 'nullable|exists:lead_statuses,id',
            'business_type_id' => 'nullable|exists:business_types,id',
            'branch_id' => 'nullable|exists:branches,id',
            'project_id' => 'nullable|exists:projects,id',
            'description' => 'nullable|string',
            'send_itinerary' => 'nullable|boolean',
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
            'source_id.exists' => 'The selected lead source is invalid.',
            'priority_id.exists' => 'The selected priority is invalid.',
            'agent_id.exists' => 'The selected agent is invalid.',
        ];
    }
}
