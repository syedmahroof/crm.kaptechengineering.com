<?php

namespace App\Http\Requests\Itinerary;

class StoreInclusionsExclusionsRequest extends BaseItineraryRequest
{
    public function rules(): array
    {
        return [
            'inclusions' => ['required', 'array', 'min:1'],
            'inclusions.*' => ['required', 'string', 'max:255'],
            'exclusions' => ['required', 'array', 'min:1'],
            'exclusions.*' => ['required', 'string', 'max:255'],
        ];
    }
}
