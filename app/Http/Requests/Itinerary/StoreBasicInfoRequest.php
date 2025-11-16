<?php

namespace App\Http\Requests\Itinerary;

use Illuminate\Validation\Rule;

class StoreBasicInfoRequest extends BaseItineraryRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'tagline' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'duration_days' => ['required', 'integer', 'min:1', 'max:365'],
            'country_id' => ['required', 'exists:countries,id'],
            'destination_id' => [
                'required',
                Rule::exists('destinations', 'id')->where('country_id', $this->input('country_id'))
            ],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'duration_days' => (int) $this->duration_days,
        ]);
    }
}
