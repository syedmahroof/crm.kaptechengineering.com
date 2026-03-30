@extends('layouts.admin')

@section('title', 'Builder Details - ' . $builder->name)

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $builder->name }}</h1>
            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $builder->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $builder->status ? 'Active' : 'Inactive' }}
            </span>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.builders.edit', $builder->id) }}" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('admin.builders.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                Back to List
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Overview -->
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Basic Information</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase">Contact Person</p>
                            <p class="mt-1 text-gray-900 dark:text-white font-semibold">{{ $builder->contact_person ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase">Branch</p>
                            <p class="mt-1 text-gray-900 dark:text-white font-semibold">{{ $builder->branch->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase">Email</p>
                            <p class="mt-1 text-gray-900 dark:text-white font-semibold">{{ $builder->email ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase">Phone</p>
                            <p class="mt-1 text-gray-900 dark:text-white font-semibold">{{ $builder->phone ?? 'N/A' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm font-medium text-gray-500 uppercase">Location</p>
                            <p class="mt-1 text-gray-900 dark:text-white font-semibold">
                                {{ $builder->location ? $builder->location . ', ' : '' }}
                                {{ $builder->district->name ?? '' }}, {{ $builder->state->name ?? '' }}, {{ $builder->country->name ?? '' }}
                            </p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm font-medium text-gray-500 uppercase">Full Address</p>
                            <p class="mt-1 text-gray-900 dark:text-white font-semibold">{{ $builder->address ?? 'N/A' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm font-medium text-gray-500 uppercase">Description</p>
                            <p class="mt-1 text-gray-900 dark:text-white font-semibold italic">{{ $builder->description ?? 'No description provided' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Purchase Managers Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Purchase Managers</h2>
                </div>
                <div class="p-6">
                    @if($builder->purchaseManagers->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($builder->purchaseManagers as $manager)
                                <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-100 dark:border-gray-600 flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold">
                                            {{ strtoupper(substr($manager->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-white">{{ $manager->name }}</h4>
                                            <p class="text-xs text-gray-500">{{ $manager->company_name ?? 'Individual' }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-600 dark:text-gray-400"><i class="fas fa-phone mr-1"></i>{{ $manager->phone ?? 'N/A' }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400"><i class="fas fa-envelope mr-1"></i>{{ $manager->email ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-6 text-gray-500 border-2 border-dashed border-gray-200 rounded-xl">
                            <p>No purchase managers linked to this builder.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar / Statistics -->
        <div class="space-y-6">
            <div class="bg-indigo-600 rounded-xl shadow-lg p-6 text-white text-center">
                <p class="mt-2 opacity-80 uppercase text-xs tracking-widest font-semibold">Total Projects</p>
                <h3 class="text-4xl font-extrabold">{{ $builder->projects->count() }}</h3>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-md font-semibold text-gray-900 dark:text-white">Projects</h2>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($builder->projects as $project)
                        <a href="{{ route('admin.projects.show', $project->id) }}" class="block px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <h4 class="font-semibold text-gray-900 dark:text-white">{{ $project->name }}</h4>
                            <p class="text-sm text-gray-500">{{ $project->location ?? 'No location' }}</p>
                        </a>
                    @empty
                        <div class="px-6 py-8 text-center text-gray-500">
                            No projects found for this builder.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
