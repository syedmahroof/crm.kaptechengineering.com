@extends('layouts.admin')

@section('title', 'Testimonial: ' . $testimonial->name)

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Testimonial Details</h1>
        <a href="{{ route('admin.testimonials.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
            <i class="fas fa-arrow-left mr-2"></i>Back
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $testimonial->name }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Location</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $testimonial->location }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Rating</label>
                <p class="mt-1">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= $testimonial->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                    @endfor
                </p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Trip Type</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $testimonial->trip_type }}</p>
            </div>
        </div>

        @if($testimonial->image_url)
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Image</label>
                <img src="{{ $testimonial->image_url }}" alt="{{ $testimonial->name }}" class="mt-2 w-32 h-32 object-cover rounded-lg">
            </div>
        @endif

        <div>
            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Review</label>
            <p class="mt-1 text-gray-900 dark:text-white">{{ $testimonial->review }}</p>
        </div>

        <div>
            <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-edit mr-2"></i>Edit Testimonial
            </a>
        </div>
    </div>
</div>
@endsection

