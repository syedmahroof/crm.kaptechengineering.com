<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBlogRequest extends FormRequest
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
        $blogId = $this->route('blog')->id;

        return [
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('blogs', 'slug')->ignore($blogId),
            ],
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'meta_data' => 'nullable|array',
            'meta_data.title' => 'nullable|string|max:60',
            'meta_data.description' => 'nullable|string|max:160',
            'meta_data.keywords' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:blog_categories,id',
            'published_at' => 'nullable|date',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The blog title is required.',
            'title.max' => 'The blog title may not be greater than 255 characters.',
            'slug.unique' => 'This slug is already taken.',
            'content.required' => 'The blog content is required.',
            'featured_image.image' => 'The featured image must be an image file.',
            'featured_image.mimes' => 'The featured image must be a file of type: jpeg, png, jpg, gif, webp.',
            'featured_image.max' => 'The featured image may not be greater than 2MB.',
            'status.required' => 'Please select a status for the blog.',
            'status.in' => 'The selected status is invalid.',
            'category_id.exists' => 'The selected category does not exist.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('meta_data') && is_string($this->meta_data)) {
            $this->merge([
                'meta_data' => json_decode($this->meta_data, true),
            ]);
        }
        
        // Convert is_featured string to boolean
        if ($this->has('is_featured') && is_string($this->is_featured)) {
            $this->merge([
                'is_featured' => filter_var($this->is_featured, FILTER_VALIDATE_BOOLEAN),
            ]);
        }
    }
}
