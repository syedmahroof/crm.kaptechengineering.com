@extends('layouts.admin')

@section('title', 'Edit Visit Report')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                <i class="fas fa-edit mr-3 text-indigo-600 dark:text-indigo-400"></i>Edit Visit Report
            </h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Update visit report details</p>
        </div>
        <a href="{{ route('visit-reports.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
            <i class="fas fa-arrow-left mr-2"></i>Back to List
        </a>
    </div>

    <form action="{{ route('visit-reports.update', $visitReport->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Linked Entities Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
            <div class="flex items-center space-x-2 mb-6">
                <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-link text-indigo-600 dark:text-indigo-400"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Link Entities</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Select at least one project, customer, or contact</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Projects -->
                <div>
                    <label for="project_ids" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-project-diagram mr-2 text-blue-500"></i>Projects
                    </label>
                    <select name="project_ids[]" id="project_ids" multiple
                            class="entity-select w-full">
                        @foreach($projects as $proj)
                            <option value="{{ $proj->id }}" {{ (old('project_ids') && in_array($proj->id, old('project_ids'))) || $visitReport->projects->contains($proj->id) ? 'selected' : '' }}>{{ $proj->name }}</option>
                        @endforeach
                    </select>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                        <i class="fas fa-info-circle mr-1"></i>Search and select multiple projects
                    </p>
                    @error('project_ids')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Customers -->
                <div>
                    <label for="customer_ids" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-user mr-2 text-green-500"></i>Customers
                    </label>
                    <select name="customer_ids[]" id="customer_ids" multiple
                            class="entity-select w-full">
                        @foreach($customers as $cust)
                            <option value="{{ $cust->id }}" {{ (old('customer_ids') && in_array($cust->id, old('customer_ids'))) || $visitReport->customers->contains($cust->id) ? 'selected' : '' }}>{{ $cust->name }}</option>
                        @endforeach
                    </select>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                        <i class="fas fa-info-circle mr-1"></i>Search and select multiple customers
                    </p>
                    @error('customer_ids')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contacts -->
                <div>
                    <label for="contact_ids" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-address-book mr-2 text-purple-500"></i>Contacts
                    </label>
                    <select name="contact_ids[]" id="contact_ids" multiple
                            class="entity-select w-full">
                        @foreach($contacts as $cont)
                            <option value="{{ $cont->id }}" {{ (old('contact_ids') && in_array($cont->id, old('contact_ids'))) || $visitReport->contacts->contains($cont->id) ? 'selected' : '' }}>{{ $cont->name }}@if($cont->email) ({{ $cont->email }})@endif</option>
                        @endforeach
                    </select>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                        <i class="fas fa-info-circle mr-1"></i>Search and select multiple contacts
                    </p>
                    @error('contact_ids')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            @error('entity')
                <div class="mt-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-600 dark:text-red-400 mr-2"></i>
                        <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    </div>
                </div>
            @enderror
        </div>

        <!-- Visit Details Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
            <div class="flex items-center space-x-2 mb-6">
                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-check text-blue-600 dark:text-blue-400"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Visit Details</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Enter the visit information</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="visit_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-calendar mr-2 text-gray-400"></i>Visit Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="visit_date" id="visit_date" value="{{ old('visit_date', $visitReport->visit_date->format('Y-m-d')) }}" required
                           class="w-full px-4 py-2.5 border rounded-lg {{ $errors->has('visit_date') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500' }} dark:bg-gray-700 dark:text-white transition-colors">
                    @error('visit_date')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="objective" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-bullseye mr-2 text-gray-400"></i>Objective of Visiting <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="objective" id="objective" value="{{ old('objective', $visitReport->objective) }}" required
                           class="w-full px-4 py-2.5 border rounded-lg {{ $errors->has('objective') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500' }} dark:bg-gray-700 dark:text-white transition-colors"
                           placeholder="e.g., Site inspection, Client meeting, Follow-up discussion">
                    @error('objective')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="report" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-file-alt mr-2 text-gray-400"></i>Daily/Visiting Time Report Update
                    </label>
                    <textarea name="report" id="report" rows="6"
                              class="w-full px-4 py-2.5 border rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors resize-none"
                              placeholder="Enter detailed report of the visit, observations, discussions, and any important notes...">{{ old('report', $visitReport->report) }}</textarea>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        <i class="fas fa-lightbulb mr-1"></i>Provide a comprehensive summary of the visit
                    </p>
                    @error('report')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="next_meeting_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-handshake mr-2 text-gray-400"></i>Next Meeting Date
                    </label>
                    <input type="date" name="next_meeting_date" id="next_meeting_date" value="{{ old('next_meeting_date', $visitReport->next_meeting_date ? $visitReport->next_meeting_date->format('Y-m-d') : '') }}"
                           class="w-full px-4 py-2.5 border rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                    @error('next_meeting_date')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="next_call_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-phone mr-2 text-gray-400"></i>Next Call Date
                    </label>
                    <input type="date" name="next_call_date" id="next_call_date" value="{{ old('next_call_date', $visitReport->next_call_date ? $visitReport->next_call_date->format('Y-m-d') : '') }}"
                           class="w-full px-4 py-2.5 border rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                    @error('next_call_date')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('visit-reports.index') }}" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 transition-colors">
                <i class="fas fa-times mr-2"></i>Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                <i class="fas fa-save mr-2"></i>Update Visit Report
            </button>
        </div>
    </form>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--multiple {
        min-height: 42px;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        padding: 0.25rem;
        background-color: #fff;
    }
    .dark .select2-container--default .select2-selection--multiple {
        background-color: #374151;
        border-color: #4b5563;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #6366f1;
        border: 1px solid #4f46e5;
        color: #fff;
        padding: 0.25rem 0.5rem;
        margin: 0.125rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: #fff;
        margin-right: 0.5rem;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
        color: #fbbf24;
    }
    .select2-container--default .select2-search--inline .select2-search__field {
        padding: 0.5rem;
        margin: 0.125rem;
        min-height: 2rem;
    }
    .dark .select2-container--default .select2-search--inline .select2-search__field {
        background-color: #374151;
        color: #fff;
    }
    .select2-dropdown {
        border-color: #d1d5db;
        border-radius: 0.5rem;
    }
    .dark .select2-dropdown {
        background-color: #374151;
        border-color: #4b5563;
    }
    .dark .select2-container--default .select2-results__option {
        background-color: #374151;
        color: #fff;
    }
    .dark .select2-container--default .select2-results__option--highlighted {
        background-color: #4f46e5;
    }
    .dark .select2-container--default .select2-search--dropdown .select2-search__field {
        background-color: #374151;
        border-color: #4b5563;
        color: #fff;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2 for Projects with autocomplete
        $('#project_ids').select2({
            placeholder: 'Search and select projects...',
            allowClear: true,
            width: '100%',
            theme: 'bootstrap-5',
            closeOnSelect: false,
            tags: false,
            language: {
                noResults: function() {
                    return "No projects found";
                },
                searching: function() {
                    return "Searching...";
                }
            }
        });

        // Initialize Select2 for Customers with autocomplete
        $('#customer_ids').select2({
            placeholder: 'Search and select customers...',
            allowClear: true,
            width: '100%',
            theme: 'bootstrap-5',
            closeOnSelect: false,
            tags: false,
            language: {
                noResults: function() {
                    return "No customers found";
                },
                searching: function() {
                    return "Searching...";
                }
            }
        });

        // Initialize Select2 for Contacts with autocomplete
        $('#contact_ids').select2({
            placeholder: 'Search and select contacts...',
            allowClear: true,
            width: '100%',
            theme: 'bootstrap-5',
            closeOnSelect: false,
            tags: false,
            language: {
                noResults: function() {
                    return "No contacts found";
                },
                searching: function() {
                    return "Searching...";
                }
            }
        });
    });
</script>
@endpush
@endsection
