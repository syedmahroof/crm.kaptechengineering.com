@extends('layouts.admin')

@section('title', 'Hotels')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Hotels</h1>
        <a href="{{ route('hotels.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i>New Hotel
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Hotel</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Star Rating</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Country</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($hotels as $hotel)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($hotel->images && is_array($hotel->images) && count($hotel->images) > 0)
                                        <img src="{{ asset('storage/' . $hotel->images[0]) }}" alt="{{ $hotel->name }}" class="w-12 h-12 rounded-lg object-cover mr-4">
                                    @endif
                                    <div>
                                        <a href="{{ route('hotels.show', $hotel->id) }}" class="font-medium text-blue-600 dark:text-blue-400 hover:underline">{{ $hotel->name }}</a>
                                        @if($hotel->is_featured)
                                            <span class="text-xs text-yellow-600 dark:text-yellow-400">Featured</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">{{ $hotel->type ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                @if($hotel->star_rating)
                                    @for($i = 0; $i < $hotel->star_rating; $i++)
                                        <i class="fas fa-star text-yellow-400"></i>
                                    @endfor
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">{{ $hotel->country->name ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full {{ $hotel->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $hotel->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('hotels.show', $hotel->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('hotels.edit', $hotel->id) }}" class="text-green-600 hover:text-green-900 dark:text-green-400">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('hotels.destroy', $hotel->id) }}" method="POST" class="inline" data-confirm="Are you sure?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">No hotels found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($hotels->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $hotels->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

