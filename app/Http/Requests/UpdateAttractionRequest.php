<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttractionRequest extends FormRequest
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
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['sometimes', 'required', 'string'],
            'type' => ['nullable', 'string', 'max:100'],
            'country_id' => ['sometimes', 'required', 'exists:countries,id'],
            'destination_id' => ['nullable', 'exists:destinations,id'],
            'address' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'opening_hours' => ['nullable', 'string'],
            'admission_fee' => ['nullable', 'numeric', 'min:0'],
            'currency_code' => ['nullable', 'string', 'max:10'],
            'images.*' => ['nullable', 'image', 'max:2048'],
            'amenities' => ['nullable', 'array'],
            'amenities.*' => ['string'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
    
    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'is_featured' => $this->boolean('is_featured'),
            'is_active' => $this->boolean('is_active'),
            'admission_fee' => $this->input('admission_fee') ? (float) $this->input('admission_fee') : null,
            'latitude' => $this->input('latitude') ? (float) $this->input('latitude') : null,
            'longitude' => $this->input('longitude') ? (float) $this->input('longitude') : null,
            'sort_order' => $this->input('sort_order') ? (int) $this->input('sort_order') : 0,
        ]);
    }
}
