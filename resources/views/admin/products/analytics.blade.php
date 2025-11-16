@extends('layouts.admin')

@section('title', 'Product Analytics')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-50 via-indigo-50 to-blue-50 dark:from-gray-800 dark:via-gray-800 dark:to-gray-900 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Product Analytics</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Comprehensive insights into your product catalog</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('products.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
                    <i class="fas fa-arrow-left mr-2"></i>Back
                </a>
            </div>
        </div>
    </div>

    <!-- Date Range Filter -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <form method="GET" action="{{ route('products.analytics') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Start Date</label>
                <input type="date" name="start_date" value="{{ $filters['start_date'] }}" 
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Date</label>
                <input type="date" name="end_date" value="{{ $filters['end_date'] }}" 
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-filter mr-2"></i>Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Overall Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-lg p-5 border border-blue-200 dark:border-blue-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-600 dark:text-blue-400">Total Products</p>
                    <p class="text-3xl font-bold text-blue-900 dark:text-blue-100 mt-1">{{ number_format($stats['total_products']) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-200 dark:bg-blue-800 rounded-lg flex items-center justify-center">
                    <i class="fas fa-box text-blue-700 dark:text-blue-300 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-lg p-5 border border-green-200 dark:border-green-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-green-600 dark:text-green-400">Active Products</p>
                    <p class="text-3xl font-bold text-green-900 dark:text-green-100 mt-1">{{ number_format($stats['active_products']) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-200 dark:bg-green-800 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-700 dark:text-green-300 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-800/20 rounded-lg p-5 border border-yellow-200 dark:border-yellow-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-yellow-600 dark:text-yellow-400">Low Stock</p>
                    <p class="text-3xl font-bold text-yellow-900 dark:text-yellow-100 mt-1">{{ number_format($stats['low_stock_products']) }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-200 dark:bg-yellow-800 rounded-lg flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-yellow-700 dark:text-yellow-300 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 rounded-lg p-5 border border-red-200 dark:border-red-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-red-600 dark:text-red-400">Inactive Products</p>
                    <p class="text-3xl font-bold text-red-900 dark:text-red-100 mt-1">{{ number_format($stats['inactive_products']) }}</p>
                </div>
                <div class="w-12 h-12 bg-red-200 dark:bg-red-800 rounded-lg flex items-center justify-center">
                    <i class="fas fa-times-circle text-red-700 dark:text-red-300 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Products by Category -->
    @if($stats['products_by_category']->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
            <i class="fas fa-chart-pie text-indigo-500 mr-2"></i>Products by Category
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($stats['products_by_category'] as $item)
                <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg text-center border border-gray-200 dark:border-gray-600">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">{{ Str::limit($item->category, 20) }}</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $item->count }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">products</p>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Stock Status Breakdown -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
            <i class="fas fa-warehouse text-blue-500 mr-2"></i>Stock Status Breakdown
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                <p class="text-sm font-medium text-green-600 dark:text-green-400 mb-1">In Stock</p>
                <p class="text-2xl font-bold text-green-900 dark:text-green-100">{{ $stats['stock_status']['in_stock'] }}</p>
            </div>
            <div class="p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg border border-yellow-200 dark:border-yellow-800">
                <p class="text-sm font-medium text-yellow-600 dark:text-yellow-400 mb-1">Low Stock</p>
                <p class="text-2xl font-bold text-yellow-900 dark:text-yellow-100">{{ $stats['stock_status']['low_stock'] }}</p>
            </div>
            <div class="p-4 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
                <p class="text-sm font-medium text-red-600 dark:text-red-400 mb-1">Out of Stock</p>
                <p class="text-2xl font-bold text-red-900 dark:text-red-100">{{ $stats['stock_status']['out_of_stock'] }}</p>
            </div>
            <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">No Tracking</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['stock_status']['no_tracking'] }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Products by Stock Value -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                <i class="fas fa-trophy text-yellow-500 mr-2"></i>Top Products by Stock Value
            </h2>
            <div class="space-y-3 max-h-96 overflow-y-auto">
                @forelse($stats['top_products_by_value'] as $product)
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900 dark:text-white">{{ $product->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $product->category ?? 'No category' }} | 
                                Stock: {{ number_format($product->stock_quantity) }} | 
                                Price: {{ number_format($product->price, 2) }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ number_format($product->total_value, 2) }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">total value</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">No data available</p>
                @endforelse
            </div>
        </div>

        <!-- Products by Creator -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                <i class="fas fa-user-chart text-blue-500 mr-2"></i>Products by Creator
            </h2>
            <div class="space-y-3 max-h-96 overflow-y-auto">
                @forelse($stats['products_by_creator'] as $item)
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900 dark:text-white">{{ $item->creator->name ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $item->creator->email ?? 'N/A' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $item->count }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">products</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">No data available</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Value by Category -->
    @if($stats['value_by_category']->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
            <i class="fas fa-dollar-sign text-green-500 mr-2"></i>Total Stock Value by Category
        </h2>
        <div class="space-y-3">
            @foreach($stats['value_by_category'] as $item)
                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div class="flex-1">
                        <p class="font-medium text-gray-900 dark:text-white">{{ $item->category }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $item->count }} products</p>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ number_format($item->total_value, 2) }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">total value</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Average Price by Category -->
    @if($stats['avg_price_by_category']->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
            <i class="fas fa-chart-bar text-purple-500 mr-2"></i>Average Price by Category
        </h2>
        <div class="space-y-2">
            @foreach($stats['avg_price_by_category'] as $item)
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $item->category }} ({{ $item->count }} products)</span>
                    <div class="flex items-center space-x-3 flex-1 mx-4">
                        <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-4">
                            @php
                                $maxPrice = $stats['avg_price_by_category']->max('avg_price');
                                $width = $maxPrice > 0 ? ($item->avg_price / $maxPrice) * 100 : 0;
                            @endphp
                            <div class="bg-purple-500 h-4 rounded-full" style="width: {{ $width }}%"></div>
                        </div>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white w-20 text-right">{{ number_format($item->avg_price, 2) }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Monthly Trends -->
    @if($stats['monthly_trends']->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
            <i class="fas fa-chart-area text-green-500 mr-2"></i>Monthly Trends (Products Created)
        </h2>
        <div class="space-y-2">
            @foreach($stats['monthly_trends'] as $trend)
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $trend['month'] }}</span>
                    <div class="flex items-center space-x-3 flex-1 mx-4">
                        <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-4">
                            @php
                                $maxCount = $stats['monthly_trends']->max('count');
                                $width = $maxCount > 0 ? ($trend['count'] / $maxCount) * 100 : 0;
                            @endphp
                            <div class="bg-green-500 h-4 rounded-full" style="width: {{ $width }}%"></div>
                        </div>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white w-12 text-right">{{ $trend['count'] }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

