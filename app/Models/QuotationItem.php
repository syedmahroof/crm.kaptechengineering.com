<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuotationItem extends Model
{
    protected $fillable = [
        'quotation_id',
        'product_id',
        'item_name',
        'description',
        'quantity',
        'unit',
        'unit_price',
        'discount_rate',
        'discount_amount',
        'tax_rate',
        'tax_amount',
        'total',
        'sort_order',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'discount_rate' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total' => 'decimal:2',
        'sort_order' => 'integer',
    ];

    /**
     * Get the quotation that owns the item.
     */
    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class);
    }

    /**
     * Get the product for the item.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Calculate total for the item.
     */
    public function calculateTotal(): void
    {
        $subtotal = $this->quantity * $this->unit_price;
        
        // Calculate discount
        if ($this->discount_rate > 0) {
            $this->discount_amount = ($subtotal * $this->discount_rate) / 100;
        }
        
        $afterDiscount = $subtotal - $this->discount_amount;
        
        // Calculate tax
        if ($this->tax_rate > 0) {
            $this->tax_amount = ($afterDiscount * $this->tax_rate) / 100;
        }
        
        $this->total = $afterDiscount + $this->tax_amount;
    }
}
