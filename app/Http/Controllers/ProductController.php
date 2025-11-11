<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Lead;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->can('view products'), 403, 'Unauthorized action.');
        
        $products = Product::with(['category', 'brand'])->paginate(15);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        abort_unless(auth()->user()->can('create products'), 403, 'Unauthorized action.');
        
        $categories = Category::all();
        $brands = Brand::all();

        return view('products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->can('create products'), 403, 'Unauthorized action.');
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'brand', 'leads']);

        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        abort_unless(auth()->user()->can('edit products'), 403, 'Unauthorized action.');
        
        $categories = Category::all();
        $brands = Brand::all();

        return view('products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, Product $product)
    {
        abort_unless(auth()->user()->can('edit products'), 403, 'Unauthorized action.');
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        abort_unless(auth()->user()->can('delete products'), 403, 'Unauthorized action.');
        
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function analytics()
    {
        // Total Products
        $totalProducts = Product::count();
        
        // Active vs Inactive Products
        $activeProducts = Product::where('status', 'active')->count();
        $inactiveProducts = Product::where('status', 'inactive')->count();
        
        // Products Growth (last 30 days vs previous 30 days)
        $productsThisMonth = Product::where('created_at', '>=', Carbon::now()->subDays(30))->count();
        $productsLastMonth = Product::whereBetween('created_at', [
            Carbon::now()->subDays(60),
            Carbon::now()->subDays(30),
        ])->count();
        $productsGrowth = $productsLastMonth > 0
            ? round((($productsThisMonth - $productsLastMonth) / $productsLastMonth) * 100, 1)
            : ($productsThisMonth > 0 ? 100 : 0);
        
        // Products by Category
        $productsByCategory = Category::withCount('products')->get()->map(function ($category) {
            return [
                'name' => $category->name,
                'count' => $category->products_count,
            ];
        });
        
        // Products by Brand
        $productsByBrand = Brand::withCount('products')->get()->map(function ($brand) {
            return [
                'name' => $brand->name,
                'count' => $brand->products_count,
            ];
        });
        
        // Top Products by Lead Count (products with most associated leads)
        $topProducts = Product::withCount('leads')
            ->orderByDesc('leads_count')
            ->limit(10)
            ->get();
        
        // Average Price
        $avgPrice = Product::whereNotNull('price')->avg('price') ?? 0;
        $totalValue = Product::whereNotNull('price')->sum('price') ?? 0;
        
        // Trend Data (Last 30 days)
        $trendLabels = [];
        $trendData = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $trendLabels[] = $date->format('M d');
            $trendData[] = Product::whereDate('created_at', $date)->count();
        }
        
        // Monthly Comparison (Last 6 months)
        $monthlyLabels = [];
        $monthlyNew = [];
        $monthlyActive = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthlyLabels[] = $month->format('M Y');
            
            $newProducts = Product::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            $monthlyNew[] = $newProducts;
            
            $active = Product::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->where('status', 'active')
                ->count();
            $monthlyActive[] = $active;
        }
        
        // Products with Leads (engagement)
        $productsWithLeads = Product::has('leads')->count();
        $productsWithoutLeads = Product::doesntHave('leads')->count();
        $engagementRate = $totalProducts > 0 
            ? round(($productsWithLeads / $totalProducts) * 100, 1) 
            : 0;
        
        // Price Distribution
        $priceRanges = [
            'Under $100' => Product::whereNotNull('price')->where('price', '<', 100)->count(),
            '$100 - $500' => Product::whereNotNull('price')->whereBetween('price', [100, 500])->count(),
            '$500 - $1000' => Product::whereNotNull('price')->whereBetween('price', [500, 1000])->count(),
            '$1000 - $5000' => Product::whereNotNull('price')->whereBetween('price', [1000, 5000])->count(),
            'Over $5000' => Product::whereNotNull('price')->where('price', '>', 5000)->count(),
        ];
        
        return view('products.analytics', compact(
            'totalProducts',
            'activeProducts',
            'inactiveProducts',
            'productsGrowth',
            'productsByCategory',
            'productsByBrand',
            'topProducts',
            'avgPrice',
            'totalValue',
            'trendLabels',
            'trendData',
            'monthlyLabels',
            'monthlyNew',
            'monthlyActive',
            'productsWithLeads',
            'productsWithoutLeads',
            'engagementRate',
            'priceRanges'
        ));
    }
}
