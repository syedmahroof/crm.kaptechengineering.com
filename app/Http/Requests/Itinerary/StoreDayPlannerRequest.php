<?php

namespace App\Http\Requests\Itinerary;

class StoreDayPlannerRequest extends BaseItineraryRequest
{
    public function rules(): array
    {
        return [
            'days' => ['required', 'array', 'min:1'],
            'days.*.day_number' => ['required', 'integer', 'min:1'],
            'days.*.title' => ['required', 'string', 'max:255'],
            'days.*.description' => ['nullable', 'string'],
            'days.*.items' => ['required', 'array', 'min:1'],
            'days.*.items.*.type' => ['required', 'in:attraction,transportation,activity,hotel,meal'],
            'days.*.items.*.start_time' => ['required', 'date_format:H:i'],
            'days.*.items.*.end_time' => ['nullable', 'date_format:H:i', 'after:days.*.items.*.start_time'],
            'days.*.items.*.item_id' => ['nullable', 'exists:attractions,id'],
            'days.*.items.*.title' => ['required_if:days.*.items.*.item_id,null', 'string', 'max:255'],
            'days.*.items.*.description' => ['nullable', 'string'],
            'days.*.items.*.location' => ['nullable', 'string', 'max:255'],
            'days.*.items.*.duration_minutes' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
