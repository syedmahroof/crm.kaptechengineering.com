<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'code',
        'description',
        'category',
        'unit',
        'price',
        'cost',
        'stock_quantity',
        'min_stock_level',
        'specifications',
        'images',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'cost' => 'decimal:2',
        'stock_quantity' => 'integer',
        'min_stock_level' => 'integer',
        'specifications' => 'array',
        'images' => 'array',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            $source = $product->slug ?? $product->name ?? Str::random(8);
            $product->slug = static::generateUniqueSlug($source);
        });

        static::updating(function (Product $product) {
            if ($product->isDirty('slug')) {
                $product->slug = static::generateUniqueSlug($product->slug, $product->id);
                return;
            }

            if ($product->isDirty('name')) {
                $product->slug = static::generateUniqueSlug($product->name, $product->id);
            }
        });
    }

    protected static function generateUniqueSlug(?string $value, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($value ?? '') ?: 'product';
        $slug = $baseSlug;
        $counter = 1;

        while (
            static::withTrashed()
                ->where('slug', $slug)
                ->when($ignoreId, function ($query, $ignoreId) {
                    return $query->where('id', '!=', $ignoreId);
                })
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    /**
     * Get the user who created the product.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the quotation items for the product.
     */
    public function quotationItems(): HasMany
    {
        return $this->hasMany(QuotationItem::class);
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Check if product is low in stock.
     */
    public function getIsLowStockAttribute(): bool
    {
        if ($this->min_stock_level === null) {
            return false;
        }
        return $this->stock_quantity <= $this->min_stock_level;
    }
}
