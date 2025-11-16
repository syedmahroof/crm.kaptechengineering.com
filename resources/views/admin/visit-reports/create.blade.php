@extends('layouts.admin')

@section('title', 'Create Visit Report')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Create Visit Report</h1>
        <a href="{{ route('visit-reports.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
            <i class="fas fa-arrow-left mr-2"></i>Back
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <form action="{{ route('visit-reports.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="project_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Project *</label>
                    <select name="project_id" id="project_id" required
                            class="mt-1 block w-full px-3 py-2 border rounded-md {{ $errors->has('project_id') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white">
                        <option value="">Select a project...</option>
                        @foreach($projects as $proj)
                            <option value="{{ $proj->id }}" {{ (old('project_id') ?? ($project->id ?? '')) == $proj->id ? 'selected' : '' }}>{{ $proj->name }}</option>
                        @endforeach
                    </select>
                    @error('project_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="visit_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date *</label>
                    <input type="date" name="visit_date" id="visit_date" value="{{ old('visit_date', date('Y-m-d')) }}" required
                           class="mt-1 block w-full px-3 py-2 border rounded-md {{ $errors->has('visit_date') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white">
                    @error('visit_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="objective" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Objective of Visiting *</label>
                    <input type="text" name="objective" id="objective" value="{{ old('objective') }}" required
                           class="mt-1 block w-full px-3 py-2 border rounded-md {{ $errors->has('objective') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} dark:bg-gray-700 dark:text-white"
                           placeholder="Enter objective of visiting">
                    @error('objective')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="report" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Daily/Visiting Time Report Update</label>
                    <textarea name="report" id="report" rows="6"
                              class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                              placeholder="Enter daily or visiting time report update">{{ old('report') }}</textarea>
                    @error('report')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="next_meeting_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Next Meeting Date</label>
                    <input type="date" name="next_meeting_date" id="next_meeting_date" value="{{ old('next_meeting_date') }}"
                           class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    @error('next_meeting_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="next_call_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Next Call Date</label>
                    <input type="date" name="next_call_date" id="next_call_date" value="{{ old('next_call_date') }}"
                           class="mt-1 block w-full px-3 py-2 border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    @error('next_call_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('visit-reports.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700">
                    Create Visit Report
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

