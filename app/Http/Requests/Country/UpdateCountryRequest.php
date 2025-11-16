<?php

namespace App\Http\Requests\Country;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCountryRequest extends FormRequest
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
        $countryId = $this->route('country')->id;

        return [
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                'size:3',
                Rule::unique('countries', 'code')->ignore($countryId),
            ],
            'iso_code' => [
                'required',
                'string',
                'size:2',
                Rule::unique('countries', 'iso_code')->ignore($countryId),
            ],
            'currency_code' => 'nullable|string|size:3',
            'currency_symbol' => 'nullable|string|max:10',
            'phone_code' => 'nullable|string|max:10',
            'capital' => 'nullable|string|max:255',
            'continent' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'flag_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'meta_data' => 'nullable|array',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The country name is required.',
            'name.max' => 'The country name may not be greater than 255 characters.',
            'code.required' => 'The country code is required.',
            'code.size' => 'The country code must be exactly 3 characters.',
            'code.unique' => 'This country code is already taken.',
            'iso_code.required' => 'The ISO code is required.',
            'iso_code.size' => 'The ISO code must be exactly 2 characters.',
            'iso_code.unique' => 'This ISO code is already taken.',
            'currency_code.size' => 'The currency code must be exactly 3 characters.',
            'flag_image.image' => 'The flag image must be an image file.',
            'flag_image.mimes' => 'The flag image must be a file of type: jpeg, png, jpg, gif, webp.',
            'flag_image.max' => 'The flag image may not be greater than 2MB.',
        ];
    }
}


