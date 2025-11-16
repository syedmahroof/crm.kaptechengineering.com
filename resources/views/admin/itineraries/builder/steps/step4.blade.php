<div class="space-y-6">
    <div>
        <h2 class="text-2xl font-semibold mb-2 text-gray-900 dark:text-white">Inclusions & Exclusions</h2>
        <p class="text-gray-600 dark:text-gray-400">
            Specify what's included and excluded in this itinerary
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Inclusions -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Inclusions <span class="text-red-500">*</span>
            </label>
            <div id="inclusions-container" class="space-y-2">
                @php
                    $inclusions = old('inclusions', $itinerary->inclusions ?? []);
                    if (empty($inclusions)) {
                        $inclusions = [''];
                    }
                @endphp
                @foreach($inclusions as $index => $inclusion)
                    <div class="flex gap-2 inclusion-item">
                        <input
                            type="text"
                            name="inclusions[]"
                            value="{{ $inclusion }}"
                            class="flex-1 px-3 py-2 border rounded-md {{ $errors->has("inclusions.$index") ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter inclusion item..."
                            required
                        >
                        @if($index > 0)
                            <button type="button" onclick="this.closest('.inclusion-item').remove()" 
                                    class="px-3 py-2 text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>
            <button type="button" onclick="addInclusion()" 
                    class="mt-2 text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400">
                <i class="fas fa-plus mr-1"></i>Add Inclusion
            </button>
            @error('inclusions')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Exclusions -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Exclusions <span class="text-red-500">*</span>
            </label>
            <div id="exclusions-container" class="space-y-2">
                @php
                    $exclusions = old('exclusions', $itinerary->exclusions ?? []);
                    if (empty($exclusions)) {
                        $exclusions = [''];
                    }
                @endphp
                @foreach($exclusions as $index => $exclusion)
                    <div class="flex gap-2 exclusion-item">
                        <input
                            type="text"
                            name="exclusions[]"
                            value="{{ $exclusion }}"
                            class="flex-1 px-3 py-2 border rounded-md {{ $errors->has("exclusions.$index") ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter exclusion item..."
                            required
                        >
                        @if($index > 0)
                            <button type="button" onclick="this.closest('.exclusion-item').remove()" 
                                    class="px-3 py-2 text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>
            <button type="button" onclick="addExclusion()" 
                    class="mt-2 text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400">
                <i class="fas fa-plus mr-1"></i>Add Exclusion
            </button>
            @error('exclusions')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>

@push('scripts')
<script>
function addInclusion() {
    const container = document.getElementById('inclusions-container');
    const newItem = document.createElement('div');
    newItem.className = 'flex gap-2 inclusion-item';
    newItem.innerHTML = `
        <input type="text" name="inclusions[]" 
               class="flex-1 px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
               placeholder="Enter inclusion item..." required>
        <button type="button" onclick="this.closest('.inclusion-item').remove()" 
                class="px-3 py-2 text-red-600 hover:text-red-800">
            <i class="fas fa-trash"></i>
        </button>
    `;
    container.appendChild(newItem);
}

function addExclusion() {
    const container = document.getElementById('exclusions-container');
    const newItem = document.createElement('div');
    newItem.className = 'flex gap-2 exclusion-item';
    newItem.innerHTML = `
        <input type="text" name="exclusions[]" 
               class="flex-1 px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
               placeholder="Enter exclusion item..." required>
        <button type="button" onclick="this.closest('.exclusion-item').remove()" 
                class="px-3 py-2 text-red-600 hover:text-red-800">
            <i class="fas fa-trash"></i>
        </button>
    `;
    container.appendChild(newItem);
}
</script>
@endpush

