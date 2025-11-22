@extends('layouts.admin')

@section('title', 'Lead: ' . $lead->name)

@section('content')
@php
    $statusIcons = [
        'new' => 'fa-star',
        'hot_lead' => 'fa-fire',
        'convert_this_week' => 'fa-calendar-week',
        'cold_lead' => 'fa-snowflake',
        'converted' => 'fa-flag-checkered',
        'lost' => 'fa-triangle-exclamation',
    ];
@endphp

<div class="flex flex-col gap-6 rounded-xl">
    <!-- Lead Header -->
    <div class="bg-white dark:bg-white rounded-xl p-8 border border-gray-200 dark:border-gray-700 shadow-lg mb-6">
        <div class="flex justify-between items-center flex-wrap gap-4">
            <div class="flex-1">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-16 h-16 bg-indigo-100 dark:bg-indigo-100 rounded-xl flex items-center justify-center border-2 border-indigo-200 dark:border-indigo-200">
                        <i class="fas fa-user-tie text-3xl text-indigo-600 dark:text-indigo-600"></i>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold text-gray-900 dark:text-gray-900 mb-2">{{ $lead->name }}</h1>
                        <div class="flex items-center space-x-3 flex-wrap">
                            @php
                                $status = $lead->lead_status->slug ?? $lead->status ?? 'new';
                                $statusClasses = [
                                    'new' => 'bg-blue-100 text-blue-800 dark:bg-blue-100 dark:text-blue-800',
                                    'hot_lead' => 'bg-red-100 text-red-800 dark:bg-red-100 dark:text-red-800',
                                    'convert_this_week' => 'bg-amber-100 text-amber-800 dark:bg-amber-100 dark:text-amber-800',
                                    'cold_lead' => 'bg-gray-100 text-gray-800 dark:bg-gray-100 dark:text-gray-800',
                                    'converted' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-100 dark:text-emerald-800',
                                    'lost' => 'bg-red-100 text-red-800 dark:bg-red-100 dark:text-red-800',
                                ];
                                $statusClass = $statusClasses[$status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-100 dark:text-gray-800';
                                $statusName = $lead->lead_status->name ?? ucwords(str_replace('_', ' ', $status));
                            @endphp
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                {{ $statusName }}
                            </span>
                            <span class="text-sm text-gray-600 dark:text-gray-600 flex items-center">
                                <i class="far fa-clock mr-1"></i>
                                Created {{ $lead->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex space-x-3">
                <button type="button"
                        onclick="openStatusModal()"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 hover:border-blue-700 dark:bg-blue-600 dark:border-blue-600 dark:hover:bg-blue-700">
                    <i class="fas fa-arrows-rotate mr-2"></i>Update Status
                </button>
                <a href="{{ route('leads.edit', $lead->id) }}" 
                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 dark:bg-gray-100 dark:text-gray-700 dark:border-gray-300 dark:hover:bg-gray-200">
                    <i class="fas fa-pencil mr-2"></i>Edit
                </a>
                <a href="{{ route('leads.index') }}" 
                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 dark:bg-gray-100 dark:text-gray-700 dark:border-gray-300 dark:hover:bg-gray-200">
                    <i class="fas fa-arrow-left mr-2"></i>Back
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Lead Details Card -->
            <div class="bg-white dark:bg-white rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                <div class="flex items-center space-x-2 mb-6">
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-info-circle text-blue-600 dark:text-blue-600"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-900">Lead Details</h2>
                        <p class="text-xs text-gray-500 dark:text-gray-500">Basic information about the lead</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-500">Email</label>
                        <p class="text-gray-900 dark:text-gray-900 mt-1 flex items-center">
                            <i class="fas fa-envelope mr-2 text-gray-400"></i>
                            {{ $lead->email }}
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-500">Phone</label>
                        <p class="text-gray-900 dark:text-gray-900 mt-1 flex items-center">
                            <i class="fas fa-phone mr-2 text-gray-400"></i>
                            {{ $lead->phone ?? 'N/A' }}
                        </p>
                    </div>
                    @if($lead->address)
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-500">Address</label>
                        <p class="text-gray-900 dark:text-gray-900 mt-1 flex items-center">
                            <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>
                            {{ $lead->address }}
                        </p>
                    </div>
                    @endif
                    @if($lead->country)
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-500">Country</label>
                        <p class="text-gray-900 dark:text-gray-900 mt-1">
                            {{ $lead->country }}
                        </p>
                    </div>
                    @endif
                    @if($lead->lead_source)
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-500">Source</label>
                        <p class="text-gray-900 dark:text-gray-900 mt-1">
                            {{ $lead->lead_source->name }}
                        </p>
                    </div>
                    @endif
                    @if($lead->lead_priority)
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-500">Priority</label>
                        <span class="mt-1 inline-block px-3 py-1 text-xs font-semibold rounded-full" 
                              style="background-color: {{ $lead->lead_priority->color }}20; color: {{ $lead->lead_priority->color }}">
                            {{ $lead->lead_priority->name }}
                        </span>
                    </div>
                    @endif
                    @if($lead->business_type)
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-500">Business Type</label>
                        <p class="text-gray-900 dark:text-gray-900 mt-1">
                            {{ $lead->business_type->name }}
                        </p>
                    </div>
                    @endif
                    @if($lead->assigned_user)
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-500">Assigned User</label>
                        <p class="text-gray-900 dark:text-gray-900 mt-1">
                            {{ $lead->assigned_user->name ?? 'N/A' }}
                        </p>
                    </div>
                    @endif
                </div>
                @if($lead->description)
                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-300">
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-500">Description</label>
                    <p class="text-gray-900 dark:text-gray-900 mt-1">{{ $lead->description }}</p>
                </div>
                @endif
            </div>

            <!-- Linked Entities Card -->
            <div class="bg-white dark:bg-white rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-link text-indigo-600 dark:text-indigo-600"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-900">Linked Entities</h2>
                            <p class="text-xs text-gray-500 dark:text-gray-500">Projects, customers, and contacts associated with this lead</p>
                        </div>
                    </div>
                    <a href="{{ route('leads.edit', $lead->id) }}" 
                       class="px-3 py-1.5 text-xs font-medium text-indigo-600 bg-indigo-50 border border-indigo-200 rounded-lg hover:bg-indigo-100 dark:bg-indigo-50 dark:text-indigo-600 dark:border-indigo-200 dark:hover:bg-indigo-100 transition-colors">
                        <i class="fas fa-edit mr-1"></i>Edit
                    </a>
                </div>
                
                <div class="space-y-4">
                    <!-- Projects -->
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-500 mb-2">
                            <i class="fas fa-project-diagram mr-2 text-blue-500"></i>Projects
                        </label>
                        <div class="flex flex-wrap gap-2">
                            @forelse($lead->projects as $project)
                                <a href="{{ route('projects.show', $project->id) }}" 
                                   class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg bg-blue-100 text-blue-800 dark:bg-blue-100 dark:text-blue-800 hover:bg-blue-200 dark:hover:bg-blue-200 transition-colors shadow-sm">
                                    <i class="fas fa-project-diagram mr-2"></i>{{ $project->name }}
                                </a>
                            @empty
                                <span class="text-sm text-gray-400 dark:text-gray-400 italic">No projects linked</span>
                            @endforelse
                        </div>
                    </div>

                    <!-- Customers -->
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-500 mb-2">
                            <i class="fas fa-users mr-2 text-green-500"></i>Customers
                        </label>
                        <div class="flex flex-wrap gap-2">
                            @forelse($lead->customers as $customer)
                                <span class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg bg-green-100 text-green-800 dark:bg-green-100 dark:text-green-800 shadow-sm">
                                    <i class="fas fa-users mr-2"></i>{{ $customer->name }}
                                </span>
                            @empty
                                <span class="text-sm text-gray-400 dark:text-gray-400 italic">No customers linked</span>
                            @endforelse
                        </div>
                    </div>

                    <!-- Contacts -->
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-500 mb-2">
                            <i class="fas fa-address-book mr-2 text-purple-500"></i>Contacts
                        </label>
                        <div class="flex flex-wrap gap-2">
                            @forelse($lead->contacts as $contact)
                                <a href="{{ route('admin.contacts.show', $contact->id) }}" 
                                   class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg bg-purple-100 text-purple-800 dark:bg-purple-100 dark:text-purple-800 hover:bg-purple-200 dark:hover:bg-purple-200 transition-colors shadow-sm">
                                    <i class="fas fa-address-book mr-2"></i>{{ $contact->name }}
                                    @if($contact->email)
                                        <span class="ml-2 text-xs opacity-75">({{ $contact->email }})</span>
                                    @endif
                                </a>
                            @empty
                                <span class="text-sm text-gray-400 dark:text-gray-400 italic">No contacts linked</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Section -->
            @if($lead->leadProducts && $lead->leadProducts->count() > 0)
            <div class="bg-white dark:bg-white rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                <div class="flex items-center space-x-2 mb-6">
                    <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-box text-indigo-600 dark:text-indigo-600"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-900">Products</h2>
                        <p class="text-xs text-gray-500 dark:text-gray-500">Products associated with this lead</p>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Product</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Quantity</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Unit Price</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Notes</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-white divide-y divide-gray-200 dark:divide-gray-300">
                            @foreach($lead->leadProducts as $leadProduct)
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-900">
                                        {{ $leadProduct->product->name ?? 'N/A' }}
                                    </div>
                                    @if($leadProduct->product && $leadProduct->product->sku)
                                    <div class="text-xs text-gray-500 dark:text-gray-500">
                                        SKU: {{ $leadProduct->product->sku }}
                                    </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-900">
                                    {{ $leadProduct->quantity }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-900">
                                    @if($leadProduct->unit_price)
                                        {{ number_format($leadProduct->unit_price, 2) }}
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-900">
                                    @if($leadProduct->total_price)
                                        {{ number_format($leadProduct->total_price, 2) }}
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-500">
                                    {{ $leadProduct->notes ?? '-' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50 dark:bg-gray-100">
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-right text-sm font-medium text-gray-900 dark:text-gray-900">
                                    Grand Total:
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-bold text-indigo-600 dark:text-indigo-600">
                                    {{ number_format($lead->leadProducts->sum('total_price'), 2) }}
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            @endif

            <!-- Lead Notes -->
            <div class="bg-white dark:bg-white rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-sticky-note text-blue-600 dark:text-blue-600"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-900">Notes</h2>
                            <p class="text-xs text-gray-500 dark:text-gray-500">Add and view notes for this lead</p>
                        </div>
                    </div>
                    <button onclick="document.getElementById('noteForm').classList.toggle('hidden')" 
                            class="px-3 py-1.5 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 dark:bg-blue-900/20 dark:text-blue-400">
                        <i class="fas fa-plus mr-1"></i>Add Note
                    </button>
                </div>
                
                <!-- Add Note Form -->
                <form id="noteForm" class="hidden mb-4" onsubmit="addNote(event)">
                    @csrf
                    <textarea name="content" rows="3" required 
                              class="w-full px-3 py-2 border rounded-lg dark:bg-white dark:text-gray-900 mb-2" 
                              placeholder="Add a note..."></textarea>
                    <div class="flex justify-end">
                        <button type="button" onclick="document.getElementById('noteForm').classList.add('hidden')" 
                                class="px-3 py-1.5 text-sm text-gray-600 dark:text-gray-600 mr-2">Cancel</button>
                        <button type="submit" 
                                class="px-3 py-1.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                            Save Note
                        </button>
                    </div>
                </form>

                <!-- Notes List -->
                <div class="space-y-3" id="notesContainer">
                    @forelse(($lead->notes ?? collect([])) as $note)
                        <div class="border border-gray-200 dark:border-gray-300 rounded-lg p-4 bg-white dark:bg-white">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-user-circle text-gray-400"></i>
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-900">
                                        {{ $note->creator->name ?? 'Unknown' }}
                                    </span>
                                    <span class="text-xs text-gray-500 dark:text-gray-500">
                                        {{ $note->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            <p class="text-sm text-gray-700 dark:text-gray-700 whitespace-pre-wrap">{{ $note->content }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-500 text-center py-4">No notes yet. Add one to get started!</p>
                    @endforelse
                </div>
            </div>

            <!-- Lead Follow-ups -->
            <div class="bg-white dark:bg-white rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-green-100 dark:bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-check text-green-600 dark:text-green-600"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-900">Follow-ups</h2>
                            <p class="text-xs text-gray-500 dark:text-gray-500">Scheduled follow-up activities</p>
                        </div>
                    </div>
                    <button onclick="document.getElementById('followUpForm').classList.toggle('hidden')" 
                            class="px-3 py-1.5 text-sm font-medium text-green-600 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 dark:bg-green-900/20 dark:text-green-400">
                        <i class="fas fa-plus mr-1"></i>Schedule Follow-up
                    </button>
                </div>

                <!-- Add Follow-up Form -->
                <form id="followUpForm" class="hidden mb-4" onsubmit="addFollowUp(event)">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-1">Title</label>
                            <input type="text" name="title" required 
                                   class="w-full px-3 py-2 border rounded-lg dark:bg-white dark:text-gray-900" 
                                   placeholder="Follow-up title">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-1">Type</label>
                            <select name="type" required 
                                    class="w-full px-3 py-2 border rounded-lg dark:bg-white dark:text-gray-900">
                                <option value="call">Phone Call</option>
                                <option value="email">Email</option>
                                <option value="meeting">Meeting</option>
                                <option value="task">Task</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-1">Scheduled Date & Time</label>
                            <input type="datetime-local" name="scheduled_at" required 
                                   class="w-full px-3 py-2 border rounded-lg dark:bg-white dark:text-gray-900">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-1">Status</label>
                            <select name="status" required 
                                    class="w-full px-3 py-2 border rounded-lg dark:bg-white dark:text-gray-900">
                                <option value="scheduled">Scheduled</option>
                                <option value="completed">Completed</option>
                                <option value="canceled">Canceled</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="2" 
                                  class="w-full px-3 py-2 border rounded-lg dark:bg-white dark:text-gray-900" 
                                  placeholder="Follow-up description"></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" onclick="document.getElementById('followUpForm').classList.add('hidden')" 
                                class="px-3 py-1.5 text-sm text-gray-600 dark:text-gray-600 mr-2">Cancel</button>
                        <button type="submit" 
                                class="px-3 py-1.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">
                            Schedule Follow-up
                        </button>
                    </div>
                </form>

                <!-- Follow-ups List -->
                <div class="space-y-3" id="followUpsContainer">
                    @forelse(($lead->follow_ups ?? collect([]))->sortByDesc('scheduled_at') as $followUp)
                        <div class="border border-gray-200 dark:border-gray-300 rounded-lg p-4 bg-white dark:bg-white">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2 mb-1">
                                        <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-900">{{ $followUp->title }}</h3>
                                        <span class="px-2 py-0.5 text-xs rounded-full 
                                            {{ $followUp->status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-100 dark:text-green-800' : 
                                               ($followUp->status === 'canceled' ? 'bg-red-100 text-red-800 dark:bg-red-100 dark:text-red-800' : 
                                               'bg-blue-100 text-blue-800 dark:bg-blue-100 dark:text-blue-800') }}">
                                            {{ ucfirst($followUp->status) }}
                                        </span>
                                        <span class="px-2 py-0.5 text-xs rounded bg-gray-100 text-gray-700 dark:bg-gray-100 dark:text-gray-700">
                                            {{ \App\Models\LeadFollowUp::getTypes()[$followUp->type] ?? ucfirst($followUp->type) }}
                                        </span>
                                    </div>
                                    <div class="flex items-center space-x-4 text-xs text-gray-500 dark:text-gray-500">
                                        <span><i class="fas fa-clock mr-1"></i>{{ $followUp->scheduled_at->format('M d, Y h:i A') }}</span>
                                        @if($followUp->creator)
                                            <span><i class="fas fa-user mr-1"></i>{{ $followUp->creator->name }}</span>
                                        @endif
                                    </div>
                                    @if($followUp->description)
                                        <p class="text-sm text-gray-700 dark:text-gray-700 mt-2">{{ $followUp->description }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-500 text-center py-4">No follow-ups scheduled. Schedule one to track your interactions!</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Stats -->
            <div class="bg-white dark:bg-white rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-10 h-10 bg-purple-100 dark:bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-bar text-purple-600 dark:text-purple-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-900">Quick Stats</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-500">Lead statistics at a glance</p>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500 dark:text-gray-500">Persons</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-gray-900">{{ $lead->persons_count ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500 dark:text-gray-500">Follow-ups</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-gray-900">{{ $lead->follow_ups_count ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500 dark:text-gray-500">Notes</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-gray-900">{{ $lead->notes_count ?? 0 }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white dark:bg-white rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-10 h-10 bg-orange-100 dark:bg-orange-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-bolt text-orange-600 dark:text-orange-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-900">Actions</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-500">Quick actions for this lead</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <form action="{{ route('leads.destroy', $lead->id) }}" method="POST" data-confirm="Are you sure you want to delete this lead?">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 text-sm font-medium text-red-600 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800 dark:hover:bg-red-900/30">
                            <i class="fas fa-trash mr-2"></i>Delete Lead
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Lead Files/Media - Full Width -->
    <div class="bg-white dark:bg-white rounded-xl border border-gray-200 dark:border-gray-700 p-6 mt-6 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-900 flex items-center">
                <i class="fas fa-file-upload mr-2 text-purple-600"></i>Files & Media
            </h2>
            <button onclick="document.getElementById('fileUploadForm').classList.toggle('hidden')" 
                    class="px-3 py-1.5 text-sm font-medium text-purple-600 bg-purple-50 border border-purple-200 rounded-lg hover:bg-purple-100 dark:bg-purple-900/20 dark:text-purple-400">
                <i class="fas fa-plus mr-1"></i>Upload File
            </button>
        </div>
        
        <!-- Upload Form -->
        <form id="fileUploadForm" class="hidden mb-4" enctype="multipart/form-data" onsubmit="uploadFile(event)">
            @csrf
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-1">Select File</label>
                    <input type="file" name="file" id="fileInput" required 
                           class="w-full px-3 py-2 border rounded-lg dark:bg-white dark:text-gray-900"
                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.zip,.rar">
                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">Max file size: 10MB. Supported: PDF, DOC, DOCX, Images, ZIP, RAR</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-1">Description / Notes</label>
                    <textarea name="description" id="fileDescription" rows="3" 
                              class="w-full px-3 py-2 border rounded-lg dark:bg-white dark:text-gray-900" 
                              placeholder="Add a description or notes about this file (e.g., 'Passport copy', 'Flight ticket confirmation', etc.)"></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="document.getElementById('fileUploadForm').classList.add('hidden'); document.getElementById('fileInput').value = ''; document.getElementById('fileDescription').value = '';" 
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-gray-400 mr-2">Cancel</button>
                    <button type="submit" 
                            class="px-3 py-1.5 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700">
                        <i class="fas fa-upload mr-1"></i>Upload
                    </button>
                </div>
            </div>
        </form>

        <!-- Files List -->
        <div class="space-y-3" id="filesContainer">
            @forelse(($lead->files ?? collect([])) as $file)
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start space-x-3 flex-1 min-w-0">
                            <div class="flex-shrink-0">
                                @php
                                    $icon = 'fa-file';
                                    $mimeType = $file->mime_type ?? '';
                                    if (str_contains($mimeType, 'pdf')) {
                                        $icon = 'fa-file-pdf';
                                    } elseif (str_contains($mimeType, 'image')) {
                                        $icon = 'fa-file-image';
                                    } elseif (str_contains($mimeType, 'word') || str_contains($mimeType, 'document')) {
                                        $icon = 'fa-file-word';
                                    } elseif (str_contains($mimeType, 'zip') || str_contains($mimeType, 'rar')) {
                                        $icon = 'fa-file-archive';
                                    }
                                @endphp
                                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                                    <i class="fas {{ $icon }} text-purple-600 dark:text-purple-400 text-xl"></i>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $file->name }}</h3>
                                @if($file->description)
                                    <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">{{ $file->description }}</p>
                                @endif
                                <div class="flex items-center space-x-3 text-xs text-gray-500 dark:text-gray-400 mt-2">
                                    <span>{{ number_format($file->size / 1024, 2) }} KB</span>
                                    <span>•</span>
                                    <span>{{ $file->created_at->diffForHumans() }}</span>
                                    @if($file->user)
                                        <span>•</span>
                                        <span>Uploaded by {{ $file->user->name }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 ml-4">
                            <a href="{{ Storage::disk('public')->url($file->path) }}" 
                               target="_blank"
                               class="p-2 text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-all duration-200"
                               title="View/Download">
                                <i class="fas fa-download h-4 w-4"></i>
                            </a>
                            <button onclick="deleteFile({{ $file->id }}, '{{ addslashes($file->name) }}')" 
                                    class="p-2 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/30 transition-all duration-200"
                                    title="Delete"
                                    data-file-id="{{ $file->id }}">
                                <i class="fas fa-trash h-4 w-4"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500 dark:text-gray-500 text-center py-8">No files uploaded yet. Upload passport copies, tickets, or other documents here!</p>
            @endforelse
        </div>
    </div>

    <!-- Comprehensive Activity Timeline -->
    @if(isset($timelineItems) && $timelineItems->count() > 0)
    <div class="bg-white dark:bg-white rounded-xl border border-gray-200 dark:border-gray-700 p-6 mt-6 shadow-sm" x-data="{ open: true }">
        <button @click="open = !open" class="w-full flex items-center justify-between text-left mb-4">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-900 flex items-center">
                <i class="fas fa-history mr-2 text-blue-600"></i>Activity Timeline
                <span class="ml-3 px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-100 dark:text-blue-800 rounded-full">
                    {{ $timelineItems->count() }}
                </span>
            </h2>
            <i class="fas fa-chevron-down text-gray-500 dark:text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
        </button>
        
        <div x-show="open" x-collapse>
            <div class="relative">
                <!-- Timeline Line -->
                <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-gray-200 dark:bg-gray-300"></div>
                
                <div class="space-y-6">
                    @php
                        $currentDate = null;
                    @endphp
                    @foreach($timelineItems as $item)
                        @php
                            $itemDate = $item->created_at->format('Y-m-d');
                            $showDateHeader = $currentDate !== $itemDate;
                            $currentDate = $itemDate;
                        @endphp
                        
                        @if($showDateHeader)
                            <div class="relative flex items-center mb-4">
                                <div class="flex-shrink-0 w-12 h-0.5 bg-gray-300 dark:bg-gray-600"></div>
                                <div class="px-4 py-1 bg-gray-100 dark:bg-gray-100 rounded-lg">
                                    <span class="text-xs font-semibold text-gray-600 dark:text-gray-600">
                                        @if($item->created_at->isToday())
                                            Today
                                        @elseif($item->created_at->isYesterday())
                                            Yesterday
                                        @else
                                            {{ $item->created_at->format('M d, Y') }}
                                        @endif
                                    </span>
                                </div>
                                <div class="flex-1 h-0.5 bg-gray-300 dark:bg-gray-600"></div>
                            </div>
                        @endif
                        
                        <div class="relative flex items-start space-x-4">
                            <!-- Timeline Icon -->
                            <div class="flex-shrink-0 relative z-10">
                                @php
                                    $iconClass = 'fa-circle';
                                    $bgColor = 'bg-blue-100 dark:bg-blue-900/30';
                                    $iconColor = 'text-blue-600 dark:text-blue-400';
                                    
                                    if($item->type === 'follow_up') {
                                        if($item->subtype === 'follow_up_completed') {
                                            $iconClass = 'fa-check-circle';
                                            $bgColor = 'bg-green-100 dark:bg-green-900/30';
                                            $iconColor = 'text-green-600 dark:text-green-400';
                                        } elseif($item->subtype === 'follow_up_canceled') {
                                            $iconClass = 'fa-times-circle';
                                            $bgColor = 'bg-red-100 dark:bg-red-900/30';
                                            $iconColor = 'text-red-600 dark:text-red-400';
                                        } else {
                                            $iconClass = 'fa-calendar-check';
                                            $bgColor = 'bg-purple-100 dark:bg-purple-900/30';
                                            $iconColor = 'text-purple-600 dark:text-purple-400';
                                        }
                                    } elseif($item->type === 'note') {
                                        $iconClass = 'fa-sticky-note';
                                        $bgColor = 'bg-yellow-100 dark:bg-yellow-900/30';
                                        $iconColor = 'text-yellow-600 dark:text-yellow-400';
                                    } elseif($item->type === 'file') {
                                        $iconClass = 'fa-file-upload';
                                        $bgColor = 'bg-indigo-100 dark:bg-indigo-900/30';
                                        $iconColor = 'text-indigo-600 dark:text-indigo-400';
                                    } elseif($item->type === 'activity') {
                                        if($item->subtype === 'created') {
                                            $iconClass = 'fa-plus-circle';
                                            $bgColor = 'bg-green-100 dark:bg-green-900/30';
                                            $iconColor = 'text-green-600 dark:text-green-400';
                                        } elseif($item->subtype === 'status_updated') {
                                            $iconClass = 'fa-arrows-rotate';
                                            $bgColor = 'bg-orange-100 dark:bg-orange-900/30';
                                            $iconColor = 'text-orange-600 dark:text-orange-400';
                                        } elseif($item->subtype === 'file_uploaded') {
                                            $iconClass = 'fa-file-upload';
                                            $bgColor = 'bg-indigo-100 dark:bg-indigo-900/30';
                                            $iconColor = 'text-indigo-600 dark:text-indigo-400';
                                        } elseif($item->subtype === 'file_deleted') {
                                            $iconClass = 'fa-file-circle-minus';
                                            $bgColor = 'bg-red-100 dark:bg-red-900/30';
                                            $iconColor = 'text-red-600 dark:text-red-400';
                                        }
                                    }
                                @endphp
                                <div class="w-12 h-12 {{ $bgColor }} rounded-full flex items-center justify-center border-4 border-white dark:border-gray-800">
                                    <i class="fas {{ $iconClass }} {{ $iconColor }} text-sm"></i>
                                </div>
                            </div>
                            
                            <!-- Timeline Content -->
                            <div class="flex-1 min-w-0 pb-6">
                                <div class="bg-gray-50 dark:bg-white rounded-lg p-4 border border-gray-200 dark:border-gray-300">
                                    <div class="flex items-start justify-between mb-2">
                                        <div class="flex-1">
                                            <p class="text-sm text-gray-900 dark:text-gray-900">
                                                <span class="font-medium">{{ $item->user->name ?? 'System' }}</span>
                                                
                                                @if($item->type === 'follow_up')
                                                    @if($item->subtype === 'follow_up_created')
                                                        scheduled a follow-up: <span class="font-medium">{{ $item->data->title }}</span>
                                                    @elseif($item->subtype === 'follow_up_completed')
                                                        completed follow-up: <span class="font-medium">{{ $item->data->title }}</span>
                                                    @elseif($item->subtype === 'follow_up_canceled')
                                                        canceled follow-up: <span class="font-medium">{{ $item->data->title }}</span>
                                                    @endif
                                                @elseif($item->type === 'note')
                                                    added a note
                                                @elseif($item->type === 'file')
                                                    uploaded file: <span class="font-medium">{{ $item->data->name ?? 'a file' }}</span>
                                                @elseif($item->type === 'activity')
                                                    @if($item->subtype === 'created')
                                                        created this lead
                                                    @elseif($item->subtype === 'file_uploaded')
                                                        uploaded file: <span class="font-medium">{{ $item->data->properties['file_name'] ?? 'a file' }}</span>
                                                    @elseif($item->subtype === 'file_deleted')
                                                        deleted file: <span class="font-medium">{{ $item->data->properties['file_name'] ?? 'a file' }}</span>
                                                    @elseif($item->subtype === 'status_updated')
                                                        updated status to <span class="font-medium">{{ $item->data->properties['status_name'] ?? 'new status' }}</span>
                                                    @elseif($item->subtype === 'itinerary_sent')
                                                        marked itinerary as sent
                                                    @elseif($item->subtype === 'flight_details_sent')
                                                        marked flight details as sent
                                                    @else
                                                        updated this lead
                                                    @endif
                                                @endif
                                            </p>
                                            
                                            @if($item->type === 'follow_up' && $item->data->description)
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ Str::limit($item->data->description, 150) }}</p>
                                            @elseif($item->type === 'note' && $item->data->content)
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ Str::limit($item->data->content, 150) }}</p>
                                            @endif
                                            
                                            @if($item->type === 'follow_up')
                                                <div class="flex items-center space-x-4 mt-2 text-xs text-gray-500 dark:text-gray-400">
                                                    <span><i class="fas fa-clock mr-1"></i>Scheduled: {{ $item->data->scheduled_at->format('M d, Y h:i A') }}</span>
                                                    @if($item->data->type)
                                                        <span><i class="fas fa-tag mr-1"></i>{{ \App\Models\LeadFollowUp::getTypes()[$item->data->type] ?? ucfirst($item->data->type) }}</span>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-2">
                                        <i class="far fa-clock mr-1"></i>{{ $item->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Link to Lead Analytics Page -->
    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-xl border border-indigo-200 dark:border-indigo-800 p-6 mt-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-indigo-600 dark:text-indigo-400 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-900">View Comprehensive Analytics</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-600">Get detailed insights on lost reasons and performance metrics</p>
                </div>
            </div>
            <a href="{{ route('leads.analytics') }}" 
               class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-medium">
                <i class="fas fa-arrow-right mr-2"></i>View Analytics
            </a>
        </div>
    </div>

    <!-- Lead Analytics - Full Width (Hidden - moved to dedicated page) -->
    @if(false && isset($analytics))
    <div class="bg-white dark:bg-white rounded-xl border border-gray-200 dark:border-gray-700 p-6 mt-6 shadow-sm" x-data="{ activeTab: 'overview' }">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-900 flex items-center">
                <i class="fas fa-chart-line mr-2 text-indigo-600"></i>Lead Analytics
            </h2>
            <div class="flex flex-wrap gap-2 bg-gray-100 dark:bg-gray-100 rounded-lg p-1">
                <button @click="activeTab = 'overview'" 
                        :class="activeTab === 'overview' ? 'bg-white dark:bg-gray-600 text-indigo-600 dark:text-indigo-400 shadow-sm' : 'text-gray-600 dark:text-gray-300'"
                        class="px-3 md:px-4 py-2 text-xs md:text-sm font-medium rounded-md transition-all">
                    Overview
                </button>
                <button @click="activeTab = 'lost-reasons'" 
                        :class="activeTab === 'lost-reasons' ? 'bg-white dark:bg-gray-600 text-indigo-600 dark:text-indigo-400 shadow-sm' : 'text-gray-600 dark:text-gray-300'"
                        class="px-3 md:px-4 py-2 text-xs md:text-sm font-medium rounded-md transition-all">
                    Lost Reasons
                </button>
                <button @click="activeTab = 'performance'" 
                        :class="activeTab === 'performance' ? 'bg-white dark:bg-gray-600 text-indigo-600 dark:text-indigo-400 shadow-sm' : 'text-gray-600 dark:text-gray-300'"
                        class="px-3 md:px-4 py-2 text-xs md:text-sm font-medium rounded-md transition-all">
                    Performance
                </button>
            </div>
        </div>

        <!-- Overview Tab -->
        <div x-show="activeTab === 'overview'" class="space-y-6">
            <!-- Overall Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-lg p-5 border border-blue-200 dark:border-blue-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600 dark:text-blue-400">Total Leads</p>
                            <p class="text-3xl font-bold text-blue-900 dark:text-blue-100 mt-1">
                                {{ number_format($analytics['overall_stats']['total_leads']) }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-blue-200 dark:bg-blue-800 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-blue-700 dark:text-blue-300 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-lg p-5 border border-green-200 dark:border-green-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-600 dark:text-green-400">Converted</p>
                            <p class="text-3xl font-bold text-green-900 dark:text-green-100 mt-1">
                                {{ number_format($analytics['overall_stats']['converted_leads']) }}
                            </p>
                            <p class="text-xs text-green-700 dark:text-green-300 mt-1">
                                {{ $analytics['overall_stats']['conversion_rate'] }}% conversion rate
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-green-200 dark:bg-green-800 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-700 dark:text-green-300 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 rounded-lg p-5 border border-red-200 dark:border-red-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-red-600 dark:text-red-400">Lost Leads</p>
                            <p class="text-3xl font-bold text-red-900 dark:text-red-100 mt-1">
                                {{ number_format($analytics['overall_stats']['lost_leads']) }}
                            </p>
                            <p class="text-xs text-red-700 dark:text-red-300 mt-1">
                                {{ $analytics['overall_stats']['loss_rate'] }}% loss rate
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-red-200 dark:bg-red-800 rounded-lg flex items-center justify-center">
                            <i class="fas fa-times-circle text-red-700 dark:text-red-300 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-lg p-5 border border-purple-200 dark:border-purple-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-purple-600 dark:text-purple-400">Avg. Conversion Time</p>
                            <p class="text-3xl font-bold text-purple-900 dark:text-purple-100 mt-1">
                                {{ $analytics['overall_stats']['avg_time_to_conversion'] }}
                            </p>
                            <p class="text-xs text-purple-700 dark:text-purple-300 mt-1">days</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-200 dark:bg-purple-800 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-purple-700 dark:text-purple-300 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Distribution -->
            @if($analytics['status_distribution']->count() > 0)
            <div class="bg-gray-50 dark:bg-gray-900/50 rounded-lg p-5">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-900 mb-4">Status Distribution</h3>
                <div class="space-y-3">
                    @foreach($analytics['status_distribution'] as $statusItem)
                        @php
                            $total = $analytics['overall_stats']['total_leads'];
                            $statusCount = $statusItem['count'] ?? 0;
                            $percentage = $total > 0 ? round(($statusCount / $total) * 100, 1) : 0;
                            $statusName = $statusItem['status'] ?? 'Unknown';
                            $statusColor = $statusItem['color'] ?? '#6b7280';
                        @endphp
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <div class="flex items-center space-x-2">
                                    <div class="w-3 h-3 rounded-full" style="background-color: {{ $statusColor }}"></div>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $statusName }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm font-semibold text-gray-900 dark:text-gray-900">{{ number_format($statusCount) }}</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-500">({{ $percentage }}%)</span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-200 rounded-full h-2">
                                <div class="h-2 rounded-full transition-all duration-300" 
                                     style="background-color: {{ $statusColor }}; width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Lost Reasons Tab -->
        <div x-show="activeTab === 'lost-reasons'" class="space-y-6">
            <div class="bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/20 dark:to-orange-900/20 rounded-lg p-5 border border-red-200 dark:border-red-800 mb-6">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-pie text-red-600 dark:text-red-400 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-900">Lost Reason Analytics</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-600">Understand why leads are being lost to improve your conversion strategy</p>
                    </div>
                </div>
            </div>

            @if($analytics['lost_reason_stats']->count() > 0)
                @php
                    $maxCount = $analytics['lost_reason_stats']->pluck('count')->max();
                @endphp
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($analytics['lost_reason_stats'] as $reasonItem)
                        @php
                            $reasonCount = $reasonItem['count'] ?? 0;
                            $percentage = $maxCount > 0 ? round(($reasonCount / $maxCount) * 100, 1) : 0;
                            $reasonName = $reasonItem['reason'] ?? 'Unknown';
                            $reasonIcon = $reasonItem['icon'] ?? 'fa-exclamation-triangle';
                            $reasonColor = $reasonItem['color'] ?? '#ef4444';
                        @endphp
                        <div class="bg-white dark:bg-white rounded-lg p-5 border border-gray-200 dark:border-gray-300 hover:shadow-lg transition-shadow">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: {{ $reasonColor }}20;">
                                        <i class="fas {{ $reasonIcon }} text-lg" style="color: {{ $reasonColor }}"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 dark:text-gray-900">{{ $reasonName }}</h4>
                                        <p class="text-2xl font-bold mt-1" style="color: {{ $reasonColor }}">
                                            {{ number_format($reasonCount) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                <div class="h-2 rounded-full transition-all duration-300" 
                                     style="background-color: {{ $reasonColor }}; width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-chart-pie text-gray-300 dark:text-gray-600 text-5xl mb-4"></i>
                    <p class="text-gray-500 dark:text-gray-500">No lost reason data available yet</p>
                </div>
            @endif
        </div>

        <!-- Performance Tab -->
        <div x-show="activeTab === 'performance'" class="space-y-6">
            <!-- Source Performance -->
            @if($analytics['source_performance']->count() > 0)
            <div class="bg-gray-50 dark:bg-gray-900/50 rounded-lg p-5">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-funnel-dollar mr-2 text-blue-600"></i>Lead Source Performance
                </h3>
                <div class="space-y-3">
                    @foreach($analytics['source_performance']->take(5) as $sourceItem)
                        @php
                            $total = $analytics['overall_stats']['total_leads'];
                            $sourceCount = $sourceItem['count'] ?? 0;
                            $percentage = $total > 0 ? round(($sourceCount / $total) * 100, 1) : 0;
                            $sourceName = $sourceItem['source'] ?? 'Unknown';
                        @endphp
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $sourceName }}</span>
                            <div class="flex items-center space-x-3">
                                <div class="w-32 bg-gray-200 dark:bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="text-sm font-semibold text-gray-900 dark:text-gray-900 w-16 text-right">
                                    {{ number_format($sourceCount) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Agent Performance -->
            @if($analytics['agent_performance']->count() > 0)
            <div class="bg-gray-50 dark:bg-gray-900/50 rounded-lg p-5">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-user-tie mr-2 text-green-600"></i>Agent Performance
                </h3>
                <div class="space-y-4">
                    @foreach($analytics['agent_performance']->take(5) as $agentItem)
                        @php
                            $agentName = $agentItem['agent'] ?? 'Unknown';
                            $agentTotal = $agentItem['total'] ?? 0;
                            $agentConverted = $agentItem['converted'] ?? 0;
                            $agentConversionRate = $agentItem['conversion_rate'] ?? 0;
                        @endphp
                        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-medium text-gray-900 dark:text-gray-900">{{ $agentName }}</span>
                                <span class="text-sm font-semibold text-green-600 dark:text-green-400">
                                    {{ $agentConversionRate }}% conversion
                                </span>
                            </div>
                            <div class="flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-600">
                                <span><i class="fas fa-users mr-1"></i>{{ $agentTotal }} total</span>
                                <span><i class="fas fa-check-circle mr-1"></i>{{ $agentConverted }} converted</span>
                            </div>
                            <div class="mt-2 w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full" style="width: {{ $agentConversionRate }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Priority Distribution -->
            @if($analytics['priority_distribution']->count() > 0)
            <div class="bg-gray-50 dark:bg-gray-900/50 rounded-lg p-5">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-flag mr-2 text-yellow-600"></i>Priority Distribution
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($analytics['priority_distribution'] as $priorityItem)
                        @php
                            $priorityName = $priorityItem['priority'] ?? 'Unknown';
                            $priorityColor = $priorityItem['color'] ?? '#6b7280';
                            $priorityCount = $priorityItem['count'] ?? 0;
                        @endphp
                        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700 text-center">
                            <div class="w-8 h-8 rounded-full mx-auto mb-2 flex items-center justify-center" style="background-color: {{ $priorityColor }}20;">
                                <i class="fas fa-flag text-sm" style="color: {{ $priorityColor }}"></i>
                            </div>
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $priorityName }}</p>
                            <p class="text-2xl font-bold mt-1" style="color: {{ $priorityColor }}">
                                {{ number_format($priorityCount) }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>

<div id="statusModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" onclick="closeStatusModal()" aria-hidden="true"></div>
    <div class="relative mx-auto mt-20 w-full max-w-3xl px-4">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-900">Update Lead Status</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-500">Choose a status that reflects the current stage of this lead.</p>
                </div>
                <button type="button" onclick="closeStatusModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            <form id="statusUpdateForm" class="px-6 py-5 space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" id="statusOptionsContainer">
                    @foreach($leadStatuses as $statusOption)
                        @php
                            $optionSlug = $statusOption->slug ?? \Illuminate\Support\Str::slug($statusOption->name);
                            $isCurrent = ($lead->lead_status_id === $statusOption->id) || (($lead->lead_status->slug ?? $lead->status) === $optionSlug);
                            $icon = $statusIcons[$optionSlug] ?? 'fa-circle';
                        @endphp
                        <button type="button"
                                class="status-option flex items-start gap-3 p-4 rounded-lg border transition-all duration-200 {{ $isCurrent ? 'border-blue-500 ring-2 ring-blue-200 dark:ring-blue-900/40' : 'border-gray-200 hover:border-blue-400 dark:border-gray-700 hover:shadow-lg hover:shadow-blue-500/10' }}"
                                data-status-id="{{ $statusOption->id }}"
                                data-status-slug="{{ $optionSlug }}"
                                data-color="{{ $statusOption->color ?? '#2563eb' }}">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: {{ ($statusOption->color ?? '#2563eb') }}15;">
                                <i class="fas {{ $icon }} text-lg" style="color: {{ $statusOption->color ?? '#2563eb' }}"></i>
                            </div>
                            <div class="text-left">
                                <p class="text-sm font-semibold text-gray-900 dark:text-gray-900">{{ $statusOption->name }}</p>
                                @if($statusOption->description)
                                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ $statusOption->description }}</p>
                                @endif
                            </div>
                        </button>
                    @endforeach
                </div>

                <div id="lostFields" class="space-y-4 hidden">
                    <div>
                        <label for="loss_reason_id" class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-1">Loss Reason</label>
                        <select id="loss_reason_id" name="loss_reason_id"
                                class="w-full px-3 py-2 border rounded-lg dark:bg-white dark:border-gray-300 dark:text-gray-900">
                            <option value="">Select a reason...</option>
                            @foreach($lossReasons as $reason)
                                <option value="{{ $reason->id }}">{{ $reason->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="loss_remarks" class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-1">Remarks</label>
                        <textarea id="loss_remarks" name="loss_remarks" rows="3"
                                  class="w-full px-3 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                                  placeholder="Add a short note to explain why the lead was lost..."></textarea>
                    </div>
                </div>

                <div id="statusError" class="hidden text-sm text-red-600 dark:text-red-400"></div>

                <div class="flex items-center justify-end gap-3 border-t border-gray-200 dark:border-gray-700 pt-4">
                    <button type="button" onclick="closeStatusModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 border border-gray-200 rounded-lg hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                        Cancel
                    </button>
                    <button type="submit" id="statusSubmitButton"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700">
                        <span class="inline-flex items-center"><i class="fas fa-floppy-disk mr-2"></i>Save Status</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const statusModal = document.getElementById('statusModal');

    if (statusModal) {
        const statusOptions = statusModal.querySelectorAll('.status-option');
        const statusForm = document.getElementById('statusUpdateForm');
        const lostFields = document.getElementById('lostFields');
        const lossReasonSelect = document.getElementById('loss_reason_id');
        const lossRemarksInput = document.getElementById('loss_remarks');
        const statusError = document.getElementById('statusError');
        const statusSubmitButton = document.getElementById('statusSubmitButton');
        const updateStatusEndpoint = @json(route('leads.update-status', $lead->id));
        const csrfToken = '{{ csrf_token() }}';
        const existingLossReasonId = '{{ $lead->lead_loss_reason_id ?? '' }}';
        const existingLossRemarks = @json($lead->lost_reason ?? '');

        let selectedStatusId = '{{ $lead->lead_status_id ?? '' }}';
        let selectedStatusSlug = '{{ $lead->lead_status->slug ?? $lead->status ?? '' }}';

        const resetOptionStyles = () => {
            statusOptions.forEach(option => {
                option.classList.remove('border-blue-500', 'ring-2', 'ring-blue-200', 'dark:ring-blue-900/40');
                option.classList.add('border-gray-200', 'dark:border-gray-700');
            });
        };

        const highlightSelectedStatus = () => {
            resetOptionStyles();
            statusOptions.forEach(option => {
                if (option.dataset.statusSlug === selectedStatusSlug || option.dataset.statusId === selectedStatusId) {
                    option.classList.remove('border-gray-200', 'dark:border-gray-700');
                    option.classList.add('border-blue-500', 'ring-2', 'ring-blue-200', 'dark:ring-blue-900/40');
                }
            });
        };

        const updateLostFieldsVisibility = () => {
            if (!lostFields) {
                return;
            }

            if (selectedStatusSlug === 'lost') {
                lostFields.classList.remove('hidden');

                if (lossReasonSelect && !lossReasonSelect.value && existingLossReasonId) {
                    lossReasonSelect.value = existingLossReasonId;
                }

                if (lossRemarksInput && !lossRemarksInput.value && existingLossRemarks) {
                    lossRemarksInput.value = existingLossRemarks;
                }
            } else {
                lostFields.classList.add('hidden');
            }
        };

        statusOptions.forEach(option => {
            option.addEventListener('click', () => {
                selectedStatusId = option.dataset.statusId;
                selectedStatusSlug = option.dataset.statusSlug;
                highlightSelectedStatus();
                updateLostFieldsVisibility();
                if (statusError) {
                    statusError.classList.add('hidden');
                    statusError.textContent = '';
                }
            });
        });

        window.openStatusModal = function () {
            if (!statusModal) {
                return;
            }

            highlightSelectedStatus();
            updateLostFieldsVisibility();
            statusModal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        };

        window.closeStatusModal = function () {
            if (!statusModal) {
                return;
            }

            statusModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');

            if (statusError) {
                statusError.classList.add('hidden');
                statusError.textContent = '';
            }

            if (statusSubmitButton) {
                statusSubmitButton.disabled = false;
                statusSubmitButton.classList.remove('opacity-60', 'cursor-not-allowed');
            }
        };

        document.addEventListener('keydown', event => {
            if (event.key === 'Escape' && !statusModal.classList.contains('hidden')) {
                window.closeStatusModal();
            }
        });

        if (statusForm) {
            statusForm.addEventListener('submit', async event => {
                event.preventDefault();

                if (!selectedStatusId) {
                    if (statusError) {
                        statusError.textContent = 'Please select a status.';
                        statusError.classList.remove('hidden');
                    }
                    return;
                }

                const payload = {
                    status_id: selectedStatusId,
                };

                if (selectedStatusSlug === 'lost') {
                    const reasonValue = lossReasonSelect ? lossReasonSelect.value : '';
                    const remarksValue = lossRemarksInput ? lossRemarksInput.value.trim() : '';

                    if (!reasonValue) {
                        if (statusError) {
                            statusError.textContent = 'Please choose a loss reason.';
                            statusError.classList.remove('hidden');
                        }
                        return;
                    }

                    if (!remarksValue) {
                        if (statusError) {
                            statusError.textContent = 'Please add remarks for lost leads.';
                            statusError.classList.remove('hidden');
                        }
                        return;
                    }

                    payload.loss_reason_id = reasonValue;
                    payload.remarks = remarksValue;
                }

                if (statusError) {
                    statusError.classList.add('hidden');
                    statusError.textContent = '';
                }

                if (statusSubmitButton) {
                    statusSubmitButton.disabled = true;
                    statusSubmitButton.classList.add('opacity-60', 'cursor-not-allowed');
                }

                try {
                    const response = await fetch(updateStatusEndpoint, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify(payload),
                    });

                    if (!response.ok) {
                        const data = await response.json().catch(() => ({ message: 'Failed to update lead status.' }));
                        const message = data.errors
                            ? Object.values(data.errors).flat().join(' ')
                            : (data.message || 'Failed to update lead status.');

                        if (statusError) {
                            statusError.textContent = message;
                            statusError.classList.remove('hidden');
                        }

                        if (statusSubmitButton) {
                            statusSubmitButton.disabled = false;
                            statusSubmitButton.classList.remove('opacity-60', 'cursor-not-allowed');
                        }

                        return;
                    }

                    window.location.reload();
                } catch (error) {
                    console.error(error);
                    if (statusError) {
                        statusError.textContent = 'Something went wrong. Please try again.';
                        statusError.classList.remove('hidden');
                    }
                    if (statusSubmitButton) {
                        statusSubmitButton.disabled = false;
                        statusSubmitButton.classList.remove('opacity-60', 'cursor-not-allowed');
                    }
                }
            });
        }

        highlightSelectedStatus();
        updateLostFieldsVisibility();
    }

    async function addNote(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);
        const content = formData.get('content');
        
        if (!content || !content.trim()) {
            alert('Please enter a note before saving.');
            return;
        }
        
        // Get CSRF token from meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
        
        // Disable submit button to prevent double submission
        const submitButton = form.querySelector('button[type="submit"]');
        const originalText = submitButton.textContent;
        submitButton.disabled = true;
        submitButton.textContent = 'Saving...';
        
        try {
            const response = await fetch('{{ route("leads.notes.store", $lead->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ content: content.trim() })
            });
            
            const data = await response.json();
            
            if (response.ok && data) {
                // Add note to container
                const container = document.getElementById('notesContainer');
                
                // Remove empty message if exists
                const emptyMessage = container.querySelector('p.text-center');
                if (emptyMessage) {
                    emptyMessage.remove();
                }
                
                const creatorName = data.creator?.name || '{{ auth()->user()->name }}';
                const noteHtml = `
                    <div class="border border-gray-200 dark:border-gray-300 rounded-lg p-4 bg-white dark:bg-white">
                        <div class="flex items-start justify-between mb-2">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-user-circle text-gray-400"></i>
                                <span class="text-sm font-medium text-gray-900 dark:text-gray-900">${escapeHtml(creatorName)}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-500">Just now</span>
                            </div>
                        </div>
                        <p class="text-sm text-gray-700 dark:text-gray-700 whitespace-pre-wrap">${escapeHtml(content.trim())}</p>
                    </div>
                `;
                container.insertAdjacentHTML('afterbegin', noteHtml);
                form.reset();
                form.classList.add('hidden');
            } else {
                const errorMessage = data.message || data.error || (data.errors?.content ? data.errors.content[0] : 'Failed to add note. Please try again.');
                alert(errorMessage);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Failed to add note. Please check your connection and try again.');
        } finally {
            // Re-enable submit button
            submitButton.disabled = false;
            submitButton.textContent = originalText;
        }
    }
    
    // Helper function to escape HTML
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    async function addFollowUp(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);
        const data = {
            title: formData.get('title'),
            type: formData.get('type'),
            description: formData.get('description'),
            scheduled_at: formData.get('scheduled_at'),
            status: formData.get('status'),
        };
        
        try {
            const response = await fetch(`/api/leads/{{ $lead->id }}/follow-ups`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify(data)
            });
            
            const followUp = await response.json();
            if (response.ok) {
                // Reload page to show new follow-up
                location.reload();
            } else {
                alert('Failed to schedule follow-up. Please try again.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Failed to schedule follow-up. Please try again.');
        }
    }

    async function uploadFile(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);
        const fileInput = document.getElementById('fileInput');
        
        if (!fileInput.files.length) {
            alert('Please select a file to upload.');
            return;
        }
        
        const submitButton = form.querySelector('button[type="submit"]');
        const originalText = submitButton.innerHTML;
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Uploading...';
        
        try {
            const response = await fetch(`/api/leads/{{ $lead->id }}/files`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: formData
            });
            
            const data = await response.json();
            
            if (response.ok && data.success) {
                // Add file to container
                const container = document.getElementById('filesContainer');
                const file = data.file;
                
                // Determine icon based on mime type
                let icon = 'fa-file';
                const mimeType = file.mime_type || '';
                if (mimeType.includes('pdf')) {
                    icon = 'fa-file-pdf';
                } else if (mimeType.includes('image')) {
                    icon = 'fa-file-image';
                } else if (mimeType.includes('word') || mimeType.includes('document')) {
                    icon = 'fa-file-word';
                } else if (mimeType.includes('zip') || mimeType.includes('rar')) {
                    icon = 'fa-file-archive';
                }
                
                const fileSize = (file.size / 1024).toFixed(2);
                const uploadedBy = file.user ? file.user.name : 'Unknown';
                const description = file.description ? `<p class="text-sm text-gray-700 dark:text-gray-300 mt-1">${file.description}</p>` : '';
                
                const fileHtml = `
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start space-x-3 flex-1 min-w-0">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                                        <i class="fas ${icon} text-purple-600 dark:text-purple-400 text-xl"></i>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-white truncate">${file.name}</h3>
                                    ${description}
                                    <div class="flex items-center space-x-3 text-xs text-gray-500 dark:text-gray-400 mt-2">
                                        <span>${fileSize} KB</span>
                                        <span>•</span>
                                        <span>Just now</span>
                                        <span>•</span>
                                        <span>Uploaded by ${uploadedBy}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2 ml-4">
                                <a href="/storage/${file.path}" 
                                   target="_blank"
                                   class="p-2 text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-all duration-200"
                                   title="View/Download">
                                    <i class="fas fa-download h-4 w-4"></i>
                                </a>
                                <button onclick="deleteFile(${file.id}, '${file.name.replace(/'/g, "\\'")}')" 
                                        class="p-2 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/30 transition-all duration-200"
                                        title="Delete"
                                        data-file-id="${file.id}">
                                    <i class="fas fa-trash h-4 w-4"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                
                // Remove empty message if exists
                const emptyMessage = container.querySelector('p.text-center');
                if (emptyMessage) {
                    emptyMessage.remove();
                }
                
                container.insertAdjacentHTML('afterbegin', fileHtml);
                form.reset();
                form.classList.add('hidden');
            } else {
                alert(data.message || 'Failed to upload file. Please try again.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Failed to upload file. Please try again.');
        } finally {
            submitButton.disabled = false;
            submitButton.innerHTML = originalText;
        }
    }
    
    async function deleteFile(fileId, fileName) {
        if (!confirm(`Are you sure you want to delete "${fileName}"? This action cannot be undone.`)) {
            return;
        }
        
        try {
            const response = await fetch(`/api/leads/{{ $lead->id }}/files/${fileId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            });
            
            const data = await response.json();
            
            if (response.ok && data.success) {
                // Remove file from DOM - find by file ID
                const container = document.getElementById('filesContainer');
                const fileElement = container.querySelector(`button[data-file-id="${fileId}"]`)?.closest('.border');
                if (fileElement) {
                    fileElement.remove();
                }
                
                // Show empty message if no files left
                if (container.children.length === 0) {
                    container.innerHTML = '<p class="text-sm text-gray-500 dark:text-gray-400 text-center py-8">No files uploaded yet. Upload passport copies, tickets, or other documents here!</p>';
                }
            } else {
                alert(data.message || 'Failed to delete file. Please try again.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Failed to delete file. Please try again.');
        }
    }
</script>
@endpush
@endsection

