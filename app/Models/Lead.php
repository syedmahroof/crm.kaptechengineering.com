<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;
use App\Models\LeadPerson;
use App\Models\LeadFollowUp;
use App\Models\LeadNote;
use App\Models\LeadLossReason;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'phone_code',
        'website',
        'address',
        'city',
        'state',
        'state_id',
        'country',
        'country_id',
        'postal_code',
        'lead_source_id',
        'lead_priority_id',
        'assigned_user_id',
        'branch_id',
        'project_id',
        'lead_status_id',
        'lead_loss_reason_id',
        'business_type_id',
        'lead_type_id',
        'description',
        'last_contacted_at',
        'converted_at',
        'lost_reason',
        'lost_at',
        'itinerary_sent_at',
        'flight_details_sent_at',
        'created_by',
        'updated_by',
        'campaign_id',
        'type',
        'notes',
    ];

    protected static function booted()
    {
        static::created(function ($lead) {
            $lead->recordActivity('created');
        });

        static::updated(function ($lead) {
            $changes = $lead->getDirty();
            
            // Don't log updated_at changes
            if (count($changes) === 1 && isset($changes['updated_at'])) {
                return;
            }

            $lead->recordActivity('updated', [
                'changes' => $changes,
            ]);
        });
    }

    protected $casts = [
        'last_contacted_at' => 'datetime',
        'converted_at' => 'datetime',
        'lost_at' => 'datetime',
        'itinerary_sent_at' => 'datetime',
        'flight_details_sent_at' => 'datetime',
    ];

    public function getLeadLossReasonIdAttribute($value): ?int
    {
        return $value !== null ? (int) $value : null;
    }

    // Status constants (legacy - now using lead_statuses table)
    public const STATUS_NEW = 'new';
    public const STATUS_ITINERARY_SENT = 'itinerary_sent';
    public const STATUS_HOT_LEAD = 'hot_lead';
    public const STATUS_COLD_LEAD = 'cold_lead';
    public const STATUS_CONVERTED = 'converted';
    public const STATUS_LOST = 'lost';

    public static function statuses(): array
    {
        return [
            self::STATUS_NEW => 'New',
            self::STATUS_ITINERARY_SENT => 'Itinerary Sent',
            self::STATUS_HOT_LEAD => 'Hot Lead',
            self::STATUS_COLD_LEAD => 'Cold Lead',
            self::STATUS_CONVERTED => 'Converted',
            self::STATUS_LOST => 'Lost',
        ];
    }

    public function lead_source(): BelongsTo
    {
        return $this->belongsTo(LeadSource::class);
    }

    public function lead_priority(): BelongsTo
    {
        return $this->belongsTo(LeadPriority::class);
    }

    public function assigned_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    // Legacy method for backward compatibility
    public function lead_agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function lead_status(): BelongsTo
    {
        return $this->belongsTo(LeadStatus::class);
    }

    public function lossReason(): BelongsTo
    {
        return $this->belongsTo(LeadLossReason::class, 'lead_loss_reason_id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function business_type(): BelongsTo
    {
        return $this->belongsTo(BusinessType::class);
    }

    public function lead_type(): BelongsTo
    {
        return $this->belongsTo(LeadType::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(LeadActivity::class)->latest();
    }

    public function flight_tickets(): HasMany
    {
        return $this->hasMany(FlightTicket::class);
    }

    public function itineraries(): HasMany
    {
        return $this->hasMany(Itinerary::class);
    }

    public function recordActivity(string $type, array $properties = []): void
    {
        $this->activities()->create([
            'user_id' => Auth::id(),
            'type' => $type,
            'properties' => $properties,
        ]);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function persons(): HasMany
    {
        return $this->hasMany(LeadPerson::class);
    }

    public function follow_ups(): HasMany
    {
        return $this->hasMany(LeadFollowUp::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(LeadNote::class);
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function scopeNew($query)
    {
        return $query->where('status', self::STATUS_NEW);
    }

    public function scopeItinerarySent($query)
    {
        return $query->where('status', self::STATUS_ITINERARY_SENT);
    }

    public function scopeHotLead($query)
    {
        return $query->where('status', self::STATUS_HOT_LEAD);
    }

    public function scopeColdLead($query)
    {
        return $query->where('status', self::STATUS_COLD_LEAD);
    }

    public function scopeConverted($query)
    {
        return $query->where('status', self::STATUS_CONVERTED);
    }

    public function scopeLost($query)
    {
        return $query->where('status', self::STATUS_LOST);
    }

    public function scopeAssignedTo($query, $userId)
    {
        return $query->where('assigned_user_id', $userId);
    }

    public function markAsConverted()
    {
        $this->update([
            'status' => self::STATUS_CONVERTED,
            'converted_at' => now(),
        ]);
    }

    public function markAsLost(?int $reasonId = null, ?string $remarks = null)
    {
        $this->update([
            'status' => self::STATUS_LOST,
            'lead_loss_reason_id' => $reasonId,
            'lost_reason' => $remarks,
            'lost_at' => now(),
        ]);
    }
}
