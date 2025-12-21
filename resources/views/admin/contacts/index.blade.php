@extends('layouts.admin')

@section('title', 'Contacts')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Contacts</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Manage contact messages</p>
        </div>
        <div class="flex items-center space-x-3">
            @if(!$showProjectsByType)
            <button onclick="updatePreference('show_projects_by_type_card', true); location.reload();" 
                    class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700" 
                    title="Show Projects by Type card">
                <i class="fas fa-eye mr-2"></i>Show Projects Card
            </button>
            @endif
            <a href="{{ route('admin.contacts.export') . '?' . http_build_query(request()->all()) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                <i class="fas fa-file-excel mr-2"></i>Export
            </a>
            <a href="{{ route('admin.contacts.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>New Contact
            </a>
        </div>
    </div>

    <!-- Stats -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6" x-data="{ statsOpen: {{ (auth()->user()->preferences['stats_card_open'] ?? true) ? 'true' : 'false' }} }">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                <i class="fas fa-chart-bar mr-2 text-gray-400"></i>Statistics
            </h3>
            <button @click="statsOpen = !statsOpen; updatePreference('stats_card_open', statsOpen)" 
                    class="px-3 py-1.5 text-sm font-medium text-gray-600 bg-gray-100 border border-gray-200 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
                <i class="fas fa-chevron-down mr-1 transition-transform duration-200" :class="{ 'rotate-180': statsOpen }"></i>
                <span x-text="statsOpen ? 'Hide' : 'Show'">Hide</span>
            </button>
        </div>
        <div x-show="statsOpen" x-collapse>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-lg p-5 border border-blue-200 dark:border-blue-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600 dark:text-blue-400">
                                @if(request()->hasAny(['search', 'priority', 'contact_type', 'project_id', 'country_id', 'state_id', 'district_id']))
                                    Filtered Contacts
                                @else
                                    Total Contacts
                                @endif
                            </p>
                            <p class="text-3xl font-bold text-blue-900 dark:text-blue-100 mt-1">{{ number_format($stats['total']) }}</p>
                            @if(request()->hasAny(['search', 'priority', 'contact_type', 'project_id', 'country_id', 'state_id', 'district_id']))
                                <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">of {{ number_format(\App\Models\Contact::count()) }} total</p>
                            @endif
                        </div>
                        <div class="w-12 h-12 bg-blue-200 dark:bg-blue-800 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-blue-700 dark:text-blue-300 text-xl"></i>
                        </div>
                    </div>
                </div>
                @php
                    // Merge counts with all contact types to show 0 counts as well
                    $allTypeCounts = [];
                    foreach($contactTypes as $slug => $name) {
                        $allTypeCounts[$slug] = $stats['by_type'][$slug] ?? 0;
                    }
                    // Sort by count desc
                    arsort($allTypeCounts);
                @endphp
                
                @foreach($allTypeCounts as $type => $count)
                    @if($loop->index < 3)
                    <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 dark:from-indigo-900/20 dark:to-indigo-800/20 rounded-lg p-5 border border-indigo-200 dark:border-indigo-800">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-medium text-indigo-600 dark:text-indigo-400">{{ Str::limit($contactTypes[$type] ?? $type, 20) }}</p>
                                <p class="text-2xl font-bold text-indigo-900 dark:text-indigo-100 mt-1">{{ number_format($count) }}</p>
                            </div>
                            <div class="w-10 h-10 bg-indigo-200 dark:bg-indigo-800 rounded-lg flex items-center justify-center">
                                <i class="fas fa-tag text-indigo-700 dark:text-indigo-300"></i>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
            
            <!-- All Contact Types Breakdown (only show types beyond the first 3) -->
            @php
                // Get all types beyond the first 3
                $otherTypes = [];
                $shownCount = 0;
                
                foreach ($allTypeCounts as $type => $count) {
                    if ($shownCount >= 3) {
                        $otherTypes[$type] = $count;
                    }
                    $shownCount++;
                }
            @endphp
            
            @if(!empty($otherTypes))
            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                    <i class="fas fa-chart-pie mr-2 text-gray-400"></i>All Contact Types
                </h4>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach($otherTypes as $type => $count)
                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($count) }}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ Str::limit($contactTypes[$type] ?? $type, 15) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

   

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6" x-data="{ filtersOpen: false }">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                <i class="fas fa-filter mr-2 text-gray-400"></i>Filters
                @if(request()->hasAny(['search', 'priority', 'contact_type', 'project_id']))
                <span class="ml-3 px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 rounded-full">
                    {{ collect([request('search'), request('priority'), request('contact_type'), request('project_id')])->filter()->count() }}
                </span>
                @endif
            </h3>
            <button @click="filtersOpen = !filtersOpen" 
                    class="px-3 py-1.5 text-sm font-medium text-gray-600 bg-gray-100 border border-gray-200 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
                <i class="fas fa-chevron-down mr-1 transition-transform duration-200" :class="{ 'rotate-180': filtersOpen }"></i>
                <span x-text="filtersOpen ? 'Hide' : 'Show'">Show</span>
            </button>
        </div>
        <form method="GET" action="{{ route('admin.contacts.index') }}" x-show="filtersOpen" x-collapse>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search contacts..." 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Priority</label>
                    <select name="priority" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Priorities</option>
                        <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                        <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contact Type</label>
                    <select name="contact_type" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Types</option>
                        @foreach($contactTypes as $key => $label)
                            <option value="{{ $key }}" {{ request('contact_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Project</label>
                    <select name="project_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Projects</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <!-- Location Filters -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        <i class="fas fa-globe mr-1"></i>Country
                    </label>
                    <select name="country_id" id="country_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Countries</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" {{ request('country_id') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        <i class="fas fa-map mr-1"></i>State
                    </label>
                    <select name="state_id" id="state_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All States</option>
                        @foreach($states as $state)
                            <option value="{{ $state->id }}" {{ request('state_id') == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        <i class="fas fa-location-dot mr-1"></i>District
                    </label>
                    <select name="district_id" id="district_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Districts</option>
                        @foreach($districts as $district)
                            <option value="{{ $district->id }}" {{ request('district_id') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <!-- Sort Options -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        <i class="fas fa-sort mr-1"></i>Sort By
                    </label>
                    <select name="sort_by" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="created_at" {{ request('sort_by', 'created_at') == 'created_at' ? 'selected' : '' }}>Created Date</option>
                        <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                        <option value="email" {{ request('sort_by') == 'email' ? 'selected' : '' }}>Email</option>
                        <option value="updated_at" {{ request('sort_by') == 'updated_at' ? 'selected' : '' }}>Updated Date</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        <i class="fas fa-arrow-up mr-1"></i>Order
                    </label>
                    <select name="sort_direction" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="desc" {{ request('sort_direction', 'desc') == 'desc' ? 'selected' : '' }}>Descending</option>
                        <option value="asc" {{ request('sort_direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        <i class="fas fa-filter mr-2"></i>Apply Filters
                    </button>
                </div>
            </div>
        </form>
        @if(request()->hasAny(['search', 'priority', 'contact_type', 'project_id', 'country_id', 'state_id', 'district_id', 'sort_by', 'sort_direction']))
        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('admin.contacts.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline flex items-center">
                <i class="fas fa-times mr-1"></i>Clear all filters and sorting
            </a>
        </div>
        @endif
    </div>

    <!-- Contacts Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Project</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Priority</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Date</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($contacts as $contact)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-gray-900 dark:text-white">{{ $contact->name }}</div>
                                @if($contact->company_name)
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                        <i class="fas fa-building mr-1"></i>{{ $contact->company_name }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">{{ $contact->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($contact->phone)
                                    <div class="flex items-center space-x-2">
                                        <span class="text-gray-500 dark:text-gray-400">{{ $contact->phone }}</span>
                                        <a href="tel:{{ $contact->phone }}" 
                                           class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-lg hover:bg-green-200 dark:bg-green-900/30 dark:text-green-400 dark:hover:bg-green-900/50 transition-colors" 
                                           title="Click to call">
                                            <i class="fas fa-phone mr-1"></i>Call
                                        </a>
                                    </div>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($contact->contact_type)
                                    <span class="px-2 py-1 text-xs rounded-full bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                        {{ $contactTypes[$contact->contact_type] ?? $contact->contact_type }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($contact->project)
                                    <a href="{{ route('projects.show', $contact->project->id) }}" class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 hover:bg-purple-200 dark:hover:bg-purple-800">
                                        {{ Str::limit($contact->project->name, 20) }}
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $priorityColors = [
                                        'low' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                        'medium' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                        'high' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200',
                                        'urgent' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                    ];
                                    $priorityColor = $priorityColors[$contact->priority] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 py-1 text-xs rounded-full {{ $priorityColor }}">
                                    {{ ucfirst($contact->priority ?? 'N/A') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $contact->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.contacts.show', $contact->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 p-2 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.contacts.edit', $contact->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 p-2 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" class="inline" data-confirm="Are you sure you want to delete this contact?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 p-2 hover:bg-red-50 dark:hover:bg-red-900/20 rounded" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">No contacts found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($contacts->lastPage() > 1)
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700 dark:text-gray-300">
                        Showing {{ $contacts->firstItem() }} to {{ $contacts->lastItem() }} of {{ $contacts->total() }}
                    </div>
                    <div class="flex space-x-2">
                        @if($contacts->previousPageUrl())
                            <a href="{{ $contacts->previousPageUrl() }}" class="px-3 py-2 border rounded-lg">Previous</a>
                        @endif
                        @if($contacts->nextPageUrl())
                            <a href="{{ $contacts->nextPageUrl() }}" class="px-3 py-2 border rounded-lg">Next</a>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
// User preferences management
function updatePreference(key, value) {
    fetch('{{ route("admin.contacts.update-preference") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            key: key,
            value: value
        })
    }).then(response => response.json())
      .then(data => {
          if (data.success) {
              console.log('Preference updated:', key, value);
          }
      })
      .catch(error => {
          console.error('Error updating preference:', error);
      });
}

$(document).ready(function() {
    // Load states when country changes
    $('#country_id').on('change', function() {
        const countryId = $(this).val();
        const stateSelect = $('#state_id');
        const districtSelect = $('#district_id');
        
        // Reset states and districts
        stateSelect.html('<option value="">All States</option>');
        districtSelect.html('<option value="">All Districts</option>');
        
        if (countryId) {
            $.ajax({
                url: '/api/states',
                method: 'GET',
                data: { country_id: countryId },
                success: function(data) {
                    data.forEach(function(state) {
                        stateSelect.append(`<option value="${state.id}">${state.name}</option>`);
                    });
                }
            });
        }
    });
    
    // Load districts when state changes
    $('#state_id').on('change', function() {
        const stateId = $(this).val();
        const districtSelect = $('#district_id');
        
        // Reset districts
        districtSelect.html('<option value="">All Districts</option>');
        
        if (stateId) {
            $.ajax({
                url: '/api/districts',
                method: 'GET',
                data: { state_id: stateId },
                success: function(data) {
                    data.forEach(function(district) {
                        districtSelect.append(`<option value="${district.id}">${district.name}</option>`);
                    });
                }
            });
        }
    });
});
</script>
@endpush
@endsection

