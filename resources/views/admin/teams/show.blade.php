@extends('layouts.admin')

@section('title', 'Team Details')

@section('content')
<div class="flex flex-col gap-6">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
                <i class="fas fa-users mr-2"></i>{{ $team->name }}
            </h1>
            <div class="flex gap-2">
                <a href="{{ route('teams.edit', $team) }}" 
                   class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <a href="{{ route('teams.index') }}" 
                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                    Back to List
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <!-- Team Info -->
            <div class="space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                    <div>
                        <span class="px-3 py-1 text-xs font-medium rounded-full {{ $team->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                            {{ $team->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
                @if($team->description)
                <div>
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</label>
                    <p class="text-gray-900 dark:text-white">{{ $team->description }}</p>
                </div>
                @endif
            </div>

            <!-- Team Leads -->
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2 block">Team Leads</label>
                <div class="flex flex-wrap gap-2">
                    @forelse($team->teamLeads as $lead)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                            <i class="fas fa-user-tie mr-2"></i>{{ $lead->name }}
                        </span>
                    @empty
                        <p class="text-gray-400">No team leads assigned</p>
                    @endforelse
                </div>
            </div>

            <!-- Team Members -->
            <div class="md:col-span-2">
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2 block">Team Members ({{ $team->users->count() }})</label>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    @forelse($team->users as $user)
                        <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                <i class="fas fa-user text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900 dark:text-white">{{ $user->name }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-400">No team members assigned</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

