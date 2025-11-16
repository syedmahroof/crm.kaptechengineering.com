<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RhPageController extends Controller
{
    private const CATEGORY_META = [
        'Cable Tray' => [
            'title' => 'Cable Trays',
            'icon' => '📊',
            'description' => 'Ladder, perforated, raceway & stainless steel cable trays for industrial power distribution.',
            'anchor' => 'cable-trays',
            'order' => 1,
        ],
        'Channels/Bracket' => [
            'title' => 'Channels & Brackets',
            'icon' => '⚙️',
            'description' => 'Slotted channels, strut channels, L brackets & anchor fasteners for mounting solutions.',
            'anchor' => 'channels-brackets',
            'order' => 2,
        ],
        'Pipe Supporting Clamps' => [
            'title' => 'Pipe Supporting Clamps',
            'icon' => '🔧',
            'description' => 'Projection clamps & clevis hangers for secure pipe support systems in HVAC & plumbing.',
            'anchor' => 'pipe-clamps',
            'order' => 3,
        ],
        'Clamps' => [
            'title' => 'Clamps & Supports',
            'icon' => '🔗',
            'description' => 'U-bolts, split clamps, universal & saddle clamps for reliable pipe mounting solutions.',
            'anchor' => 'clamps-supports',
            'order' => 4,
        ],
        'Fasteners' => [
            'title' => 'Fasteners & Hardware',
            'icon' => '🔩',
            'description' => 'Threaded rods, hex nuts, washers & stainless steel fastener kits for industrial assembly.',
            'anchor' => 'fasteners',
            'order' => 5,
        ],
        'Accessories' => [
            'title' => 'Accessories & Fittings',
            'icon' => '🛠️',
            'description' => 'Cable tray accessories, hangers & brackets for complete installation solutions.',
            'anchor' => 'accessories',
            'order' => 6,
        ],
        'Cable Tray Accessories' => [
            'title' => 'Cable Tray Accessories',
            'icon' => '📦',
            'description' => 'Bends, tees, reducers & couplers that complete every cable tray installation.',
            'anchor' => 'cable-tray-accessories',
            'order' => 7,
        ],
    ];

    public function home()
    {
        $categorySummaries = $this->buildCategorySummaries();

        return view('frontend.rh.home', [
            'pageTitle' => 'Cable Tray Manufacturers India | Channels & Brackets | Kaptech Solutions',
            'metaDescription' => 'Premium cable trays, channels & brackets engineered for HVAC, electrical, solar & fire systems. ISO certified manufacturing with custom sizes & pan-India delivery.',
            'categorySummaries' => $categorySummaries,
            'totalProductCount' => $categorySummaries->sum('count'),
        ]);
    }

    public function about()
    {
        return view('frontend.rh.about', [
            'pageTitle' => 'About Kaptech Solutions | Industrial Cable Tray Manufacturer',
            'metaDescription' => '10+ years of expertise delivering precision cable trays, channels & brackets. Discover our mission, manufacturing capabilities and quality-first approach.',
        ]);
    }

    public function contact()
    {
        return view('frontend.rh.contact', [
            'pageTitle' => 'Contact Kaptech Solutions | Request Cable Tray Quotes & Support',
            'metaDescription' => 'Request quotes or technical support for cable trays, channels & brackets. Pan-India delivery with dedicated sales engineers ready to help.',
        ]);
    }

    public function products()
    {
        $productCategories = $this->prepareProductCategories();

        return view('frontend.rh.products', [
            'pageTitle' => 'Cable Trays & Channels Products | Kaptech Solutions',
            'metaDescription' => 'Browse ladder & perforated cable trays, slotted channels, brackets, clamps and fasteners manufactured with ISO certified quality.',
            'productCategories' => $productCategories,
            'totalProductCount' => $productCategories->sum(fn ($category) => count($category['products'])),
        ]);
    }

    public function productDetail(Product $product)
    {
        $productData = $this->transformProduct($product);
        $relatedProducts = Product::active()
            ->where('id', '!=', $product->id)
            ->where('category', $product->category)
            ->orderBy('name')
            ->limit(4)
            ->get()
            ->map(fn ($related) => $this->transformProduct($related));

        return view('frontend.rh.product-detail', [
            'pageTitle' => "{$product->name} | Kaptech Solutions",
            'metaDescription' => Str::limit(strip_tags($product->description ?? 'Detailed specifications, finishes & applications for premium industrial products.'), 155),
            'product' => $productData,
            'relatedProducts' => $relatedProducts,
        ]);
    }

    private function buildCategorySummaries(): Collection
    {
        $counts = Product::active()
            ->select('category', DB::raw('COUNT(*) as total'))
            ->whereNotNull('category')
            ->groupBy('category')
            ->pluck('total', 'category');

        $summaries = collect(self::CATEGORY_META)->map(function ($meta, $categoryKey) use ($counts) {
            $meta['key'] = $categoryKey;
            $meta['count'] = (int) ($counts[$categoryKey] ?? 0);
            return $meta;
        });

        $missingCategories = $counts->keys()->diff(array_keys(self::CATEGORY_META));

        foreach ($missingCategories as $categoryKey) {
            $summaries->push($this->resolveCategoryMeta($categoryKey, (int) $counts[$categoryKey]));
        }

        return $summaries->sortBy('order')->values();
    }

    private function prepareProductCategories(): Collection
    {
        $products = Product::active()
            ->whereNotNull('category')
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        return $products
            ->groupBy('category')
            ->map(function ($items, $categoryKey) {
                $meta = $this->resolveCategoryMeta($categoryKey, $items->count());

                return [
                    'key' => $categoryKey,
                    'title' => $meta['title'],
                    'icon' => $meta['icon'],
                    'description' => $meta['description'],
                    'anchor' => $meta['anchor'],
                    'order' => $meta['order'],
                    'count' => $items->count(),
                    'products' => $items->map(fn ($product) => $this->transformProduct($product))->all(),
                ];
            })
            ->sortBy('order')
            ->values();
    }

    private function resolveCategoryMeta(string $categoryKey, int $count = 0): array
    {
        $meta = self::CATEGORY_META[$categoryKey] ?? [
            'title' => $categoryKey ?: 'Uncategorized',
            'icon' => '🧰',
            'description' => 'Explore our range of industrial-grade solutions.',
            'anchor' => Str::slug($categoryKey ?: 'category'),
            'order' => 999,
        ];

        $meta['key'] = $categoryKey;
        $meta['count'] = $count;
        $meta['anchor'] = $meta['anchor'] ?? Str::slug($meta['title']);
        $meta['order'] = $meta['order'] ?? 999;

        return $meta;
    }

    private function transformProduct(Product $product): array
    {
        $plainDescription = trim(strip_tags((string) $product->description));

        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'category' => $product->category,
            'description' => $product->description,
            'short_description' => $plainDescription ? Str::limit($plainDescription, 180) : null,
            'image' => $this->resolveProductImage($product),
            'specifications' => $product->specifications ?? [],
        ];
    }

    private function resolveProductImage(Product $product): string
    {
        $images = $product->images ?? [];

        if (is_string($images)) {
            $images = [$images];
        }

        if (is_array($images) && count($images) > 0) {
            $image = $images[0];

            if (filter_var($image, FILTER_VALIDATE_URL)) {
                return $image;
            }

            $path = ltrim($image, '/');

            if (Str::startsWith($path, 'rh/')) {
                return asset($path);
            }

            return Storage::disk('public')->url($path);
        }

        return asset('rh/assets/images/placeholder.svg');
    }
}

