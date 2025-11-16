<?php

namespace App\Http\Requests\Itinerary;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseItineraryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Authorization is handled by controller/middleware
    }
    
    public function getInclusions(): array
    {
        return array_filter(
            array_map('trim', $this->input('inclusions', [])),
            fn($item) => !empty($item)
        );
    }
    
    public function getExclusions(): array
    {
        return array_filter(
            array_map('trim', $this->input('exclusions', [])),
            fn($item) => !empty($item)
        );
    }
    
    public function getMetaKeywords(): array
    {
        $keywords = $this->input('meta_keywords', '');
        if (is_string($keywords)) {
            return array_filter(
                array_map('trim', explode(',', $keywords)),
                fn($keyword) => !empty($keyword)
            );
        }
        return [];
    }
}
