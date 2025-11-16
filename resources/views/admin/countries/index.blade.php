@extends('layouts.admin')

@section('title', 'Countries')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Countries</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Manage countries and their information</p>
        </div>
        <a href="{{ route('countries.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i>New Country
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <form method="GET" action="{{ route('countries.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search..." class="px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
            <select name="continent" class="px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                <option value="">All Continents</option>
                @foreach($continents as $continent)
                    <option value="{{ $continent }}" {{ ($filters['continent'] ?? '') == $continent ? 'selected' : '' }}>{{ $continent }}</option>
                @endforeach
            </select>
            <select name="is_active" class="px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                <option value="">All Status</option>
                <option value="1" {{ ($filters['is_active'] ?? '') == '1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ ($filters['is_active'] ?? '') == '0' ? 'selected' : '' }}>Inactive</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Filter</button>
        </form>
    </div>

    <!-- Countries Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Country</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Continent</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($countries as $country)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $country->name }}</td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">{{ $country->iso_code ?? $country->code }}</td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">{{ $country->continent ?? 'N/A' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full {{ $country->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                    {{ $country->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('countries.show', $country->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('countries.edit', $country->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('countries.toggle-active', $country->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400" title="Toggle Status">
                                            <i class="fas fa-toggle-{{ $country->is_active ? 'on' : 'off' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('countries.destroy', $country->id) }}" method="POST" class="inline" data-confirm="Are you sure you want to delete this country?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">No countries found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($countries->hasPages())
        <div class="flex justify-center">
            {{ $countries->links() }}
        </div>
    @endif
</div>
@endsection

