<div class="border border-gray-200 dark:border-gray-700 rounded p-3">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <div>
            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Type</label>
            @php
                // Get the type value, defaulting to 'attraction' to match database default
                $rawType = old("days.$dayIndex.items.$itemIndex.type", $item->type ?? 'attraction');
                // Normalize 'transport' to 'transportation' for backward compatibility with seeders
                $typeValue = $rawType === 'transport' ? 'transportation' : $rawType;
            @endphp
            <select name="days[{{ $dayIndex }}][items][{{ $itemIndex }}][type]" 
                    class="w-full px-2 py-1 text-sm border rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                <option value="attraction" {{ $typeValue == 'attraction' ? 'selected' : '' }}>Attraction</option>
                <option value="transportation" {{ $typeValue == 'transportation' ? 'selected' : '' }}>Transportation</option>
                <option value="activity" {{ $typeValue == 'activity' ? 'selected' : '' }}>Activity</option>
                <option value="hotel" {{ $typeValue == 'hotel' ? 'selected' : '' }}>Hotel</option>
                <option value="meal" {{ $typeValue == 'meal' ? 'selected' : '' }}>Meal</option>
            </select>
        </div>
        <div>
            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Start Time</label>
            @php
                $startTimeValue = '09:00';
                if ($item && $item->exists) {
                    // Get raw original value from database (before datetime cast)
                    $rawStartTime = $item->getRawOriginal('start_time');
                    if ($rawStartTime) {
                        // Extract time portion (HH:MM:SS -> HH:MM) or use as is if already HH:MM
                        $startTimeValue = strlen($rawStartTime) >= 5 ? substr($rawStartTime, 0, 5) : $rawStartTime;
                    }
                } elseif ($item && $item->start_time) {
                    // Fallback for new items or if getRawOriginal doesn't work
                    if ($item->start_time instanceof \Carbon\Carbon || $item->start_time instanceof \DateTime) {
                        $startTimeValue = $item->start_time->format('H:i');
                    } elseif (is_string($item->start_time)) {
                        $startTimeValue = strlen($item->start_time) >= 5 ? substr($item->start_time, 0, 5) : $item->start_time;
                    }
                }
                $startTimeValue = old("days.$dayIndex.items.$itemIndex.start_time", $startTimeValue);
            @endphp
            <input type="time" name="days[{{ $dayIndex }}][items][{{ $itemIndex }}][start_time]" 
                   class="w-full px-2 py-1 text-sm border rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" 
                   value="{{ $startTimeValue }}" required>
        </div>
        <div>
            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">End Time</label>
            @php
                $endTimeValue = '';
                if ($item && $item->exists && $item->end_time) {
                    // Get raw original value from database (before datetime cast)
                    $rawEndTime = $item->getRawOriginal('end_time');
                    if ($rawEndTime) {
                        // Extract time portion (HH:MM:SS -> HH:MM) or use as is if already HH:MM
                        $endTimeValue = strlen($rawEndTime) >= 5 ? substr($rawEndTime, 0, 5) : $rawEndTime;
                    }
                } elseif ($item && $item->end_time) {
                    // Fallback for new items or if getRawOriginal doesn't work
                    if ($item->end_time instanceof \Carbon\Carbon || $item->end_time instanceof \DateTime) {
                        $endTimeValue = $item->end_time->format('H:i');
                    } elseif (is_string($item->end_time)) {
                        $endTimeValue = strlen($item->end_time) >= 5 ? substr($item->end_time, 0, 5) : $item->end_time;
                    }
                }
                $endTimeValue = old("days.$dayIndex.items.$itemIndex.end_time", $endTimeValue);
            @endphp
            <input type="time" name="days[{{ $dayIndex }}][items][{{ $itemIndex }}][end_time]" 
                   class="w-full px-2 py-1 text-sm border rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" 
                   value="{{ $endTimeValue }}">
        </div>
        <div class="md:col-span-3">
            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Title</label>
            <input type="text" name="days[{{ $dayIndex }}][items][{{ $itemIndex }}][title]" 
                   class="w-full px-2 py-1 text-sm border rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" 
                   placeholder="Activity title" 
                   value="{{ old("days.$dayIndex.items.$itemIndex.title", $item->title ?? '') }}" required>
        </div>
        <div class="md:col-span-3">
            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Description</label>
            <textarea name="days[{{ $dayIndex }}][items][{{ $itemIndex }}][description]" rows="2"
                      class="w-full px-2 py-1 text-sm border rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old("days.$dayIndex.items.$itemIndex.description", $item->description ?? '') }}</textarea>
        </div>
        <div>
            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Location</label>
            <input type="text" name="days[{{ $dayIndex }}][items][{{ $itemIndex }}][location]" 
                   class="w-full px-2 py-1 text-sm border rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                   value="{{ old("days.$dayIndex.items.$itemIndex.location", $item->location ?? '') }}">
        </div>
        <div>
            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Duration (minutes)</label>
            <input type="number" name="days[{{ $dayIndex }}][items][{{ $itemIndex }}][duration_minutes]" 
                   class="w-full px-2 py-1 text-sm border rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                   value="{{ old("days.$dayIndex.items.$itemIndex.duration_minutes", $item->duration_minutes ?? '') }}">
        </div>
        <div class="flex items-end">
            <button type="button" onclick="this.closest('.border').remove()" 
                    class="px-2 py-1 text-sm text-red-600 hover:text-red-800">
                <i class="fas fa-trash"></i> Remove
            </button>
        </div>
    </div>
</div>

