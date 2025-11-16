<div class="space-y-6">
    <div>
        <h2 class="text-2xl font-semibold mb-2 text-gray-900 dark:text-white">SEO Settings</h2>
        <p class="text-gray-600 dark:text-gray-400">
            Optimize your itinerary for search engines
        </p>
    </div>

    <div class="space-y-6">
        <!-- Meta Title -->
        <div>
            <label for="meta_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Meta Title
                <span class="text-xs text-gray-500">(Max 60 characters, optional)</span>
            </label>
            <input
                type="text"
                id="meta_title"
                name="meta_title"
                value="{{ old('meta_title', $itinerary->meta_title) }}"
                maxlength="60"
                class="w-full px-3 py-2 border rounded-md {{ $errors->has('meta_title') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="SEO-friendly title..."
            >
            <p class="text-xs text-gray-500 mt-1"><span id="meta-title-count">0</span>/60 characters</p>
            @error('meta_title')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Meta Description -->
        <div>
            <label for="meta_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Meta Description
                <span class="text-xs text-gray-500">(Max 160 characters, optional)</span>
            </label>
            <textarea
                id="meta_description"
                name="meta_description"
                rows="3"
                maxlength="160"
                class="w-full px-3 py-2 border rounded-md {{ $errors->has('meta_description') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="SEO-friendly description..."
            >{{ old('meta_description', $itinerary->meta_description) }}</textarea>
            <p class="text-xs text-gray-500 mt-1"><span id="meta-desc-count">0</span>/160 characters</p>
            @error('meta_description')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Meta Keywords -->
        <div>
            <label for="meta_keywords" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Meta Keywords
                <span class="text-xs text-gray-500">(optional)</span>
            </label>
            <input
                type="text"
                id="meta_keywords"
                name="meta_keywords"
                value="{{ old('meta_keywords', is_array($itinerary->meta_keywords) ? implode(', ', $itinerary->meta_keywords) : $itinerary->meta_keywords) }}"
                class="w-full px-3 py-2 border rounded-md {{ $errors->has('meta_keywords') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="keyword1, keyword2, keyword3..."
            >
            <p class="text-xs text-gray-500 mt-1">Separate keywords with commas</p>
            @error('meta_keywords')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Slug -->
        <div>
            <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                URL Slug
            </label>
            <input
                type="text"
                id="slug"
                name="slug"
                value="{{ old('slug', $itinerary->slug) }}"
                class="w-full px-3 py-2 border rounded-md {{ $errors->has('slug') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="auto-generated-from-title"
            >
            <p class="text-xs text-gray-500 mt-1">Leave empty to auto-generate from title</p>
            @error('slug')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- OG Image -->
        <div>
            <label for="og_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Open Graph Image
            </label>
            @if($itinerary->og_image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $itinerary->og_image) }}" alt="OG Image" class="h-32 w-auto rounded-md">
                </div>
            @endif
            <input
                type="file"
                id="og_image"
                name="og_image"
                accept="image/*"
                class="w-full px-3 py-2 border rounded-md {{ $errors->has('og_image') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >
            @error('og_image')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const metaTitle = document.getElementById('meta_title');
    const metaDesc = document.getElementById('meta_description');
    const titleCount = document.getElementById('meta-title-count');
    const descCount = document.getElementById('meta-desc-count');
    
    if (metaTitle && titleCount) {
        titleCount.textContent = metaTitle.value.length;
        metaTitle.addEventListener('input', function() {
            titleCount.textContent = this.value.length;
        });
    }
    
    if (metaDesc && descCount) {
        descCount.textContent = metaDesc.value.length;
        metaDesc.addEventListener('input', function() {
            descCount.textContent = this.value.length;
        });
    }

    // Auto-generate slug from meta title
    const slugInput = document.getElementById('slug');
    if (metaTitle && slugInput) {
        metaTitle.addEventListener('blur', function() {
            if (!slugInput.value && this.value) {
                let slug = this.value.toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/(^-|-$)/g, '');
                slugInput.value = slug;
            }
        });
    }
});
</script>
@endpush

