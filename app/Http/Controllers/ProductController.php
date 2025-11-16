<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('creator')->orderBy('created_at', 'desc');

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            } elseif ($request->status === 'low_stock') {
                $query->whereColumn('stock_quantity', '<=', 'min_stock_level');
            }
        }

        $products = $query->paginate(15);
        $categories = Product::distinct()->whereNotNull('category')->pluck('category');
        $totalProducts = Product::count();

        return view('admin.products.index', [
            'products' => $products,
            'categories' => $categories,
            'totalProducts' => $totalProducts,
            'filters' => $request->only(['search', 'category', 'status']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255|unique:products,sku',
            'code' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
            'cost' => 'nullable|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'min_stock_level' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['is_active'] = $request->boolean('is_active', true);

        Product::create($validated);

        return redirect()->route('products.index')
                        ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('creator', 'quotationItems.quotation');

        return view('admin.products.show', [
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', [
            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255|unique:products,sku,' . $product->id,
            'code' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
            'cost' => 'nullable|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'min_stock_level' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $product->update($validated);

        return redirect()->route('products.index')
                        ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
                        ->with('success', 'Product deleted successfully.');
    }

    /**
     * Show product analytics dashboard.
     */
    public function analytics(Request $request)
    {
        // Check if products table exists
        if (!Schema::hasTable('products')) {
            return redirect()->route('products.index')
                ->with('error', 'Products table does not exist. Please run migrations: php artisan migrate');
        }

        // Get date range from request or use default (last 365 days)
        $endDate = $request->filled('end_date') 
            ? \Carbon\Carbon::parse($request->end_date)->endOfDay()
            : now();
            
        $startDate = $request->filled('start_date')
            ? \Carbon\Carbon::parse($request->start_date)->startOfDay()
            : $endDate->copy()->subYear();

        $baseQuery = Product::query()
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('created_at', [$startDate, $endDate]);
            });

        // Overall statistics
        $totalProducts = (clone $baseQuery)->count();
        $activeProducts = (clone $baseQuery)->where('is_active', true)->count();
        $inactiveProducts = (clone $baseQuery)->where('is_active', false)->count();
        $lowStockProducts = Product::whereColumn('stock_quantity', '<=', 'min_stock_level')
            ->whereNotNull('stock_quantity')
            ->whereNotNull('min_stock_level')
            ->count();

        // Products by category
        $productsByCategory = (clone $baseQuery)
            ->select('category', \DB::raw('COUNT(*) as total'))
            ->where('is_active', 1)
            ->whereNotNull('category')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        // Total value by category
        $valueByCategory = (clone $baseQuery)
            ->select('category', \DB::raw('SUM(price * COALESCE(stock_quantity, 0)) as total_value'), \DB::raw('COUNT(*) as count'))
            ->whereNotNull('category')
            ->whereNotNull('stock_quantity')
            ->groupBy('category')
            ->orderByDesc('total_value')
            ->get();

        // Monthly trends (products created)
        $monthlyTrends = (clone $baseQuery)
            ->select(\DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), \DB::raw('COUNT(*) as count'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function($item) {
                return [
                    'month' => \Carbon\Carbon::parse($item->month . '-01')->format('M Y'),
                    'count' => $item->count,
                ];
            });

        // Top products by stock value
        $topProductsByValue = Product::whereNotNull('stock_quantity')
            ->whereNotNull('price')
            ->select('id', 'name', 'category', 'price', 'stock_quantity', \DB::raw('(price * stock_quantity) as total_value'))
            ->orderByDesc('total_value')
            ->limit(10)
            ->get();

        // Stock status breakdown
        $stockStatus = [
            'in_stock' => Product::whereNotNull('stock_quantity')
                ->whereNotNull('min_stock_level')
                ->whereColumn('stock_quantity', '>', 'min_stock_level')
                ->count(),
            'low_stock' => Product::whereNotNull('stock_quantity')
                ->whereNotNull('min_stock_level')
                ->whereColumn('stock_quantity', '<=', 'min_stock_level')
                ->whereColumn('stock_quantity', '>', \DB::raw('0'))
                ->count(),
            'out_of_stock' => Product::where(function($q) {
                $q->where('stock_quantity', 0)
                  ->orWhereNull('stock_quantity');
            })->count(),
            'no_tracking' => Product::where(function($q) {
                $q->whereNull('stock_quantity')
                  ->orWhereNull('min_stock_level');
            })->count(),
        ];

        // Products by creator
        $productsByCreator = (clone $baseQuery)
            ->select('created_by', \DB::raw('COUNT(*) as count'))
            ->with('creator')
            ->whereNotNull('created_by')
            ->groupBy('created_by')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        // Average price by category
        $avgPriceByCategory = (clone $baseQuery)
            ->select('category', \DB::raw('AVG(price) as avg_price'), \DB::raw('COUNT(*) as count'))
            ->whereNotNull('category')
            ->whereNotNull('price')
            ->groupBy('category')
            ->orderByDesc('avg_price')
            ->get();

        $stats = [
            'total_products' => $totalProducts,
            'active_products' => $activeProducts,
            'inactive_products' => $inactiveProducts,
            'low_stock_products' => $lowStockProducts,
            'products_by_category' => $productsByCategory,
            'value_by_category' => $valueByCategory,
            'monthly_trends' => $monthlyTrends,
            'top_products_by_value' => $topProductsByValue,
            'stock_status' => $stockStatus,
            'products_by_creator' => $productsByCreator,
            'avg_price_by_category' => $avgPriceByCategory,
        ];

        return view('admin.products.analytics', [
            'stats' => $stats,
            'filters' => [
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
            ],
        ]);
    }
}
