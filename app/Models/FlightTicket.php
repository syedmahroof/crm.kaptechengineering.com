<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class FlightTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'departure_airport',
        'arrival_airport',
        'departure_date',
        'return_date',
        'passenger_count',
        'class_type',
        'airline_preference',
        'budget_range',
        'special_requests',
        'status',
        'booking_reference',
        'total_cost',
        'currency',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'departure_date' => 'datetime',
        'return_date' => 'datetime',
        'passenger_count' => 'integer',
        'total_cost' => 'decimal:2',
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public static function statuses(): array
    {
        return [
            'pending' => 'Pending',
            'quoted' => 'Quoted',
            'booked' => 'Booked',
            'confirmed' => 'Confirmed',
            'cancelled' => 'Cancelled',
        ];
    }

    public static function classTypes(): array
    {
        return [
            'economy' => 'Economy',
            'premium_economy' => 'Premium Economy',
            'business' => 'Business',
            'first' => 'First Class',
        ];
    }

    public static function budgetRanges(): array
    {
        return [
            'budget' => 'Budget (< $500)',
            'mid_range' => 'Mid-range ($500 - $1500)',
            'premium' => 'Premium ($1500 - $3000)',
            'luxury' => 'Luxury (> $3000)',
        ];
    }
}
