<div class="space-y-6">
    <div>
        <h2 class="text-2xl font-semibold mb-2 text-gray-900 dark:text-white">Preview & Publish</h2>
        <p class="text-gray-600 dark:text-gray-400">
            Review your itinerary and publish it when ready
        </p>
    </div>

    <!-- Itinerary Summary -->
    <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6 space-y-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Itinerary Summary</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Name</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $itinerary->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Duration</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $itinerary->duration_days }} days</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Country</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $itinerary->country->name ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Destination</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $itinerary->destination->name ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Status</p>
                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                    {{ ucfirst($itinerary->status) }}
                </span>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Progress</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ count($completedSteps ?? []) }}/5 steps completed</p>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex flex-col gap-4">
        <form method="POST" action="{{ route('itineraries.builder.publish', $itinerary->id) }}" class="inline">
            @csrf
            <input type="hidden" name="action" value="publish">
            <button type="submit" 
                    class="w-full px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                <i class="fas fa-check-circle mr-2"></i>Publish Itinerary
            </button>
        </form>

        <form method="POST" action="{{ route('itineraries.builder.publish', $itinerary->id) }}" class="inline">
            @csrf
            <input type="hidden" name="action" value="draft">
            <button type="submit" 
                    class="w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-600">
                <i class="fas fa-save mr-2"></i>Save as Draft
            </button>
        </form>

        <a href="{{ route('itineraries.show', $itinerary->id) }}" 
           class="w-full text-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-md hover:bg-blue-100 dark:bg-blue-900/20 dark:border-blue-800 dark:text-blue-400 dark:hover:bg-blue-900/30">
            <i class="fas fa-eye mr-2"></i>Preview Itinerary
        </a>
    </div>
</div>

