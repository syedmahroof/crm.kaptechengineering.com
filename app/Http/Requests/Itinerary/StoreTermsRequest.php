<?php

namespace App\Http\Requests\Itinerary;

class StoreTermsRequest extends BaseItineraryRequest
{
    public function rules(): array
    {
        return [
            'terms_conditions' => ['required', 'string', 'min:10'],
            'cancellation_policy' => ['required', 'string', 'min:10'],
        ];
    }
}
