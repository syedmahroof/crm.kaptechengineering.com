@extends('layouts.admin')

@section('title', $country->name)

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $country->name }}</h1>
        <div class="flex items-center space-x-3">
            <a href="{{ route('countries.edit', $country->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('countries.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                <i class="fas fa-arrow-left mr-2"></i>Back
            </a>
        </div>
    </div>

    <!-- Basic Information -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-4">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Basic Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Country Name</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $country->name }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">ISO Code</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $country->iso_code ?? $country->code ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Continent</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $country->continent ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Capital</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $country->capital ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Currency</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $country->currency_code ?? 'N/A' }} {{ $country->currency_symbol ?? '' }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone Code</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $country->phone_code ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                <p class="mt-1">
                    <span class="px-2 py-1 text-xs rounded-full {{ $country->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                        {{ $country->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </p>
            </div>
            @if($country->flag_url)
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Flag</label>
                <p class="mt-1">
                    <img src="{{ $country->flag_url }}" alt="{{ $country->name }}" class="w-16 h-12 object-cover rounded">
                </p>
            </div>
            @endif
            @if($country->description)
            <div class="md:col-span-2">
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</label>
                <p class="mt-1 text-gray-900 dark:text-white">{{ $country->description }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- States/Provinces -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">States/Provinces</h2>
            <a href="{{ route('states.index', ['country_id' => $country->id]) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                <i class="fas fa-plus mr-2"></i>Manage States
            </a>
        </div>
        <div id="states-container">
            <div class="text-center text-gray-500 dark:text-gray-400 py-4">
                <i class="fas fa-spinner fa-spin"></i> Loading states...
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total States</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white" id="states-count">-</p>
                </div>
                <i class="fas fa-map-marked-alt text-3xl text-blue-500"></i>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Destinations</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $country->destinations->count() }}</p>
                </div>
                <i class="fas fa-map text-3xl text-green-500"></i>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Attractions</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $country->attractions->count() }}</p>
                </div>
                <i class="fas fa-landmark text-3xl text-purple-500"></i>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Load states for this country
        $.ajax({
            url: '/api/states',
            method: 'GET',
            data: { country_id: {{ $country->id }} },
            success: function(states) {
                const container = $('#states-container');
                const count = states.length;
                $('#states-count').text(count);
                
                if (count === 0) {
                    container.html('<p class="text-center text-gray-500 dark:text-gray-400 py-4">No states/provinces found for this country.</p>');
                } else {
                    let html = '<div class="overflow-x-auto"><table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">';
                    html += '<thead class="bg-gray-50 dark:bg-gray-700"><tr>';
                    html += '<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Name</th>';
                    html += '<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Code</th>';
                    html += '<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>';
                    html += '</tr></thead><tbody class="divide-y divide-gray-200 dark:divide-gray-700">';
                    
                    states.forEach(function(state) {
                        html += '<tr class="hover:bg-gray-50 dark:hover:bg-gray-700">';
                        html += '<td class="px-6 py-4 font-medium text-gray-900 dark:text-white">' + state.name + '</td>';
                        html += '<td class="px-6 py-4 text-gray-500 dark:text-gray-400">' + (state.code || '-') + '</td>';
                        html += '<td class="px-6 py-4">';
                        html += '<span class="px-2 py-1 text-xs rounded-full ' + (state.is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300') + '">';
                        html += state.is_active ? 'Active' : 'Inactive';
                        html += '</span></td>';
                        html += '</tr>';
                    });
                    
                    html += '</tbody></table></div>';
                    container.html(html);
                }
            },
            error: function() {
                $('#states-container').html('<p class="text-center text-red-500 py-4">Error loading states. Please try again.</p>');
            }
        });
    });
</script>
@endpush
@endsection

