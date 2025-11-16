<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'image',
        'mobile_image',
        'desktop_image',
        'alt_tag',
        'image_position',
        'overlay_opacity',
        'link',
        'button_text',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'overlay_opacity' => 'integer',
    ];

    // Removed $appends to avoid conflicts with form data
    // protected $appends = [
    //     'image_url',
    //     'mobile_image_url',
    //     'desktop_image_url',
    // ];

    /**
     * Scope a query to only include active banners.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order banners by sort order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at');
    }

    /**
     * Get the appropriate image based on device type
     */
    public function getImageForDevice($device = 'desktop')
    {
        if ($device === 'mobile' && $this->mobile_image) {
            return $this->mobile_image;
        }
        
        if ($this->desktop_image) {
            return $this->desktop_image;
        }
        
        // Fallback to the original image field
        return $this->image;
    }

    /**
     * Get image position CSS class
     */
    public function getImagePositionClass()
    {
        return match($this->image_position) {
            'top' => 'bg-top',
            'center' => 'bg-center',
            'bottom' => 'bg-bottom',
            'left' => 'bg-left',
            'right' => 'bg-right',
            default => 'bg-center',
        };
    }

    /**
     * Get overlay opacity percentage
     */
    public function getOverlayOpacityAttribute($value)
    {
        return $value ?? 40;
    }

    /**
     * Get the full URL for the image
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    /**
     * Get the full URL for the mobile image
     */
    public function getMobileImageUrlAttribute()
    {
        return $this->mobile_image ? asset('storage/' . $this->mobile_image) : null;
    }

    /**
     * Get the full URL for the desktop image
     */
    public function getDesktopImageUrlAttribute()
    {
        return $this->desktop_image ? asset('storage/' . $this->desktop_image) : null;
    }
}
