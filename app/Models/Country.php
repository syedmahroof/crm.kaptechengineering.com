<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'iso_code',
        'currency_code',
        'currency_symbol',
        'phone_code',
        'capital',
        'continent',
        'description',
        'flag_image',
        'meta_data',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'meta_data' => 'array',
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'flag_url',
    ];

    /**
     * Get the attractions for the country.
     */
    public function attractions(): HasMany
    {
        return $this->hasMany(Attraction::class);
    }

    /**
     * Get the hotels for the country.
     */
    public function hotels(): HasMany
    {
        return $this->hasMany(Hotel::class);
    }

    /**
     * Get the states for the country.
     */
    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }

    /**
     * Get the districts for the country.
     */
    public function districts(): HasMany
    {
        return $this->hasMany(District::class);
    }

    /**
     * Scope a query to only include active countries.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order countries by sort order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Get the country's flag URL.
     */
    public function getFlagUrlAttribute(): string
    {
        if (isset($this->attributes['flag_image']) && $this->attributes['flag_image']) {
            return asset('storage/' . $this->attributes['flag_image']);
        }
        
        // Check if iso_code exists before using it
        if (!array_key_exists('iso_code', $this->attributes)) {
            return '';
        }
        
        return "https://flagcdn.com/24x18/{$this->iso_code}.png";
    }
}