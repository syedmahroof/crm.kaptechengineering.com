@extends('layouts.admin')

@section('title', $blog->title)

@section('content')
<div class="flex flex-col gap-6">
    <!-- Header -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $blog->title }}</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                By {{ $blog->author->name ?? 'Unknown' }} • {{ $blog->created_at->format('M d, Y') }}
            </p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="px-4 py-2 text-sm font-medium text-indigo-600 bg-white border border-indigo-600 rounded-lg hover:bg-indigo-50 dark:bg-gray-800 dark:text-indigo-400 dark:border-indigo-400 dark:hover:bg-gray-700">
                <i class="fas fa-pencil mr-2"></i>Edit
            </a>
            <a href="{{ route('admin.blogs.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-2"></i>Back
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Featured Image -->
            @if($blog->featured_image)
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}" class="w-full h-64 object-cover">
                </div>
            @endif

            <!-- Blog Content -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                @if($blog->excerpt)
                    <p class="text-lg text-gray-700 dark:text-gray-300 mb-6 italic">{{ $blog->excerpt }}</p>
                @endif
                
                <div class="prose dark:prose-invert max-w-none">
                    {!! nl2br(e($blog->content)) !!}
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Status Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Details</h3>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                        @php
                            $statusClasses = [
                                'published' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                'draft' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                'archived' => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300',
                            ];
                            $statusClass = $statusClasses[$blog->status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <p class="mt-1">
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusClass }}">
                                {{ ucfirst($blog->status) }}
                            </span>
                            @if($blog->is_featured)
                                <i class="fas fa-star text-yellow-500 ml-2" title="Featured"></i>
                            @endif
                        </p>
                    </div>
                    
                    @if($blog->category)
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Category</label>
                            <p class="mt-1 text-gray-900 dark:text-white">{{ $blog->category->name }}</p>
                        </div>
                    @endif
                    
                    @if($blog->published_at)
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Published</label>
                            <p class="mt-1 text-gray-900 dark:text-white">{{ $blog->published_at->format('M d, Y h:i A') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Actions</h3>
                <div class="space-y-2">
                    <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" data-confirm="Are you sure?">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 text-sm font-medium text-red-600 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800 dark:hover:bg-red-900/30">
                            <i class="fas fa-trash mr-2"></i>Delete Blog
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

