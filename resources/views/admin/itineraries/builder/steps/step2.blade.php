<div class="space-y-6">
    <div>
        <h2 class="text-2xl font-semibold mb-2 text-gray-900 dark:text-white">Day Planner</h2>
        <p class="text-gray-600 dark:text-gray-400">
            Plan activities for each day of your itinerary
        </p>
    </div>

    @php
        $durationDays = $itinerary->duration_days ?? 7;
        $days = $itinerary->days ?? collect([]);
    @endphp

    <div class="space-y-6" id="days-container">
        @for($day = 1; $day <= $durationDays; $day++)
            @php
                $dayData = $days->firstWhere('day_number', $day);
            @endphp
            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Day {{ $day }}</h3>
                
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Day Title
                        </label>
                        <input
                            type="text"
                            name="days[{{ $day - 1 }}][title]"
                            value="{{ old("days.$day-1.title", $dayData->title ?? "Day $day") }}"
                            class="w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                            required
                        >
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Description
                        </label>
                        <textarea
                            name="days[{{ $day - 1 }}][description]"
                            rows="3"
                            class="w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        >{{ old("days.$day-1.description", $dayData->description ?? '') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Meals Included
                        </label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="days[{{ $day - 1 }}][meals][]" value="breakfast" 
                                       {{ in_array('breakfast', old("days.$day-1.meals", $dayData->meals ?? [])) ? 'checked' : '' }}
                                       class="rounded border-gray-300">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Breakfast</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="days[{{ $day - 1 }}][meals][]" value="lunch"
                                       {{ in_array('lunch', old("days.$day-1.meals", $dayData->meals ?? [])) ? 'checked' : '' }}
                                       class="rounded border-gray-300">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Lunch</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="days[{{ $day - 1 }}][meals][]" value="dinner"
                                       {{ in_array('dinner', old("days.$day-1.meals", $dayData->meals ?? [])) ? 'checked' : '' }}
                                       class="rounded border-gray-300">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Dinner</span>
                            </label>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="days[{{ $day - 1 }}][day_number]" value="{{ $day }}">

                <!-- Day Items -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Activities/Items
                    </label>
                    <div class="space-y-3" id="items-day-{{ $day }}">
                        @php
                            // Get items from the day - Laravel will lazy load if not already loaded
                            $dayItems = $dayData ? $dayData->items : null;
                        @endphp
                        @if($dayItems && $dayItems->count() > 0)
                            @foreach($dayItems as $itemIndex => $item)
                                @include('admin.itineraries.builder.partials.day-item', [
                                    'dayIndex' => $day - 1,
                                    'itemIndex' => $itemIndex,
                                    'item' => $item
                                ])
                            @endforeach
                        @else
                            @include('admin.itineraries.builder.partials.day-item', [
                                'dayIndex' => $day - 1,
                                'itemIndex' => 0,
                                'item' => null
                            ])
                        @endif
                    </div>
                    <button type="button" onclick="addDayItem({{ $day }})" 
                            class="mt-2 text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400">
                        <i class="fas fa-plus mr-1"></i>Add Activity
                    </button>
                </div>
            </div>
        @endfor
    </div>
</div>

@push('scripts')
<script>
function addDayItem(dayNumber) {
    const container = document.getElementById('items-day-' + dayNumber);
    const itemCount = container.children.length;
    const itemIndex = itemCount;
    const dayIndex = dayNumber - 1;
    
    const newItem = document.createElement('div');
    newItem.className = 'border border-gray-200 dark:border-gray-700 rounded p-3';
    newItem.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div>
                <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Type</label>
                <select name="days[${dayIndex}][items][${itemIndex}][type]" class="w-full px-2 py-1 text-sm border rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    <option value="attraction">Attraction</option>
                    <option value="transportation">Transportation</option>
                    <option value="activity">Activity</option>
                    <option value="hotel">Hotel</option>
                    <option value="meal">Meal</option>
                </select>
            </div>
            <div>
                <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Start Time</label>
                <input type="time" name="days[${dayIndex}][items][${itemIndex}][start_time]" 
                       class="w-full px-2 py-1 text-sm border rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" 
                       value="09:00" required>
            </div>
            <div>
                <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">End Time</label>
                <input type="time" name="days[${dayIndex}][items][${itemIndex}][end_time]" 
                       class="w-full px-2 py-1 text-sm border rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            </div>
            <div class="md:col-span-3">
                <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Title</label>
                <input type="text" name="days[${dayIndex}][items][${itemIndex}][title]" 
                       class="w-full px-2 py-1 text-sm border rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" 
                       placeholder="Activity title" required>
            </div>
            <div class="md:col-span-3">
                <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Description</label>
                <textarea name="days[${dayIndex}][items][${itemIndex}][description]" rows="2"
                          class="w-full px-2 py-1 text-sm border rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"></textarea>
            </div>
            <div>
                <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Location</label>
                <input type="text" name="days[${dayIndex}][items][${itemIndex}][location]" 
                       class="w-full px-2 py-1 text-sm border rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Duration (minutes)</label>
                <input type="number" name="days[${dayIndex}][items][${itemIndex}][duration_minutes]" 
                       class="w-full px-2 py-1 text-sm border rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            </div>
            <div class="flex items-end">
                <button type="button" onclick="this.closest('.border').remove()" 
                        class="px-2 py-1 text-sm text-red-600 hover:text-red-800">
                    <i class="fas fa-trash"></i> Remove
                </button>
            </div>
        </div>
    `;
    container.appendChild(newItem);
}
</script>
@endpush

