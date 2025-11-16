@extends('layouts.admin')

@section('title', 'Edit Reminder')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Reminder</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Update reminder details</p>
        </div>
        <a href="{{ route('reminders.index') }}" class="px-4 py-2 border rounded-lg">Back</a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <form action="{{ route('reminders.update', $reminder) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" value="{{ old('title', $reminder->title) }}" required
                        class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter reminder title">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Description
                    </label>
                    <textarea name="description" rows="3"
                        class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter reminder description">{{ old('description', $reminder->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Reminder Date & Time <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" name="reminder_at" 
                            value="{{ old('reminder_at', $reminder->reminder_at->format('Y-m-d\TH:i')) }}" required
                            class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500">
                        @error('reminder_at')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Priority
                        </label>
                        <select name="priority"
                            class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500">
                            <option value="low" {{ old('priority', $reminder->priority) == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ old('priority', $reminder->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ old('priority', $reminder->priority) == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Type
                    </label>
                    <input type="text" name="type" value="{{ old('type', $reminder->type) }}"
                        class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500"
                        placeholder="e.g., general, follow-up, meeting">
                </div>

                <div>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="is_completed" value="1" {{ old('is_completed', $reminder->is_completed) ? 'checked' : '' }}
                            class="rounded border-gray-300">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Mark as completed</span>
                    </label>
                </div>

                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('reminders.index') }}" class="px-4 py-2 border rounded-lg">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Update Reminder
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

