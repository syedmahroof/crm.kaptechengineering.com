<?php

namespace App\Http\Requests\Itinerary;

class StoreSeoRequest extends BaseItineraryRequest
{
    public function rules(): array
    {
        return [
            'meta_title' => ['required', 'string', 'max:60'],
            'meta_description' => ['required', 'string', 'max:160'],
            'meta_keywords' => ['required', 'string'],
        ];
    }
}
