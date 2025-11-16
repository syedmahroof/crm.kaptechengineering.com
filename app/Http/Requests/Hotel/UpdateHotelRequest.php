<?php

namespace App\Http\Requests\Hotel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateHotelRequest extends FormRequest
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
        $hotelId = $this->route('hotel')->id;

        return [
            'name' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('hotels', 'slug')->ignore($hotelId),
            ],
            'description' => 'nullable|string',
            'type' => 'nullable|string|max:255',
            'country_id' => 'required|exists:countries,id',
            'destination_id' => 'nullable|exists:destinations,id',
            'address' => 'nullable|string|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'phone' => 'nullable|string|max:50',
            'website' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255',
            'star_rating' => 'nullable|integer|min:1|max:5',
            'total_rooms' => 'nullable|integer|min:0',
            'room_types' => 'nullable|array',
            'room_types.*' => 'string|max:255',
            'price_range_min' => 'nullable|numeric|min:0',
            'price_range_max' => 'nullable|numeric|min:0|gte:price_range_min',
            'currency_code' => 'nullable|string|size:3',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'amenities' => 'nullable|array',
            'amenities.*' => 'string|max:255',
            'meta_data' => 'nullable|array',
            'meta_data.title' => 'nullable|string|max:60',
            'meta_data.description' => 'nullable|string|max:160',
            'meta_data.keywords' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The hotel name is required.',
            'name.max' => 'The hotel name may not be greater than 255 characters.',
            'slug.unique' => 'This slug is already taken.',
            'country_id.required' => 'Please select a country.',
            'country_id.exists' => 'The selected country does not exist.',
            'destination_id.exists' => 'The selected destination does not exist.',
            'latitude.between' => 'The latitude must be between -90 and 90.',
            'longitude.between' => 'The longitude must be between -180 and 180.',
            'website.url' => 'The website must be a valid URL.',
            'email.email' => 'The email must be a valid email address.',
            'star_rating.min' => 'The star rating must be at least 1.',
            'star_rating.max' => 'The star rating may not be greater than 5.',
            'total_rooms.min' => 'The total rooms must be at least 0.',
            'price_range_max.gte' => 'The maximum price must be greater than or equal to the minimum price.',
            'currency_code.size' => 'The currency code must be exactly 3 characters.',
            'images.*.image' => 'Each image must be an image file.',
            'images.*.mimes' => 'Each image must be a file of type: jpeg, png, jpg, gif, webp.',
            'images.*.max' => 'Each image may not be greater than 5MB.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Convert JSON strings to arrays if needed
        if ($this->has('room_types') && is_string($this->room_types)) {
            $this->merge([
                'room_types' => json_decode($this->room_types, true),
            ]);
        }

        if ($this->has('amenities') && is_string($this->amenities)) {
            $this->merge([
                'amenities' => json_decode($this->amenities, true),
            ]);
        }

        if ($this->has('meta_data') && is_string($this->meta_data)) {
            $this->merge([
                'meta_data' => json_decode($this->meta_data, true),
            ]);
        }

        // Convert boolean strings to boolean
        if ($this->has('is_active') && is_string($this->is_active)) {
            $this->merge([
                'is_active' => filter_var($this->is_active, FILTER_VALIDATE_BOOLEAN),
            ]);
        }

        if ($this->has('is_featured') && is_string($this->is_featured)) {
            $this->merge([
                'is_featured' => filter_var($this->is_featured, FILTER_VALIDATE_BOOLEAN),
            ]);
        }
    }
}

