<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class Campaign extends Model
{
    use HasFactory, SoftDeletes;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_PAUSED = 'paused';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    public const TYPES = [
        'email' => 'Email Campaign',
        'social_media' => 'Social Media',
        'ppc' => 'Pay Per Click',
        'content' => 'Content Marketing',
        'event' => 'Event',
        'other' => 'Other',
    ];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'start_date',
        'end_date',
        'budget',
        'status',
        'type',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'budget' => 'decimal:2',
    ];

    protected $attributes = [
        'status' => self::STATUS_DRAFT,
    ];

    /**
     * Get the validation rules for the model.
     *
     * @return array
     */
    public static function rules($id = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'budget' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'string', Rule::in([
                self::STATUS_DRAFT,
                self::STATUS_ACTIVE,
                self::STATUS_PAUSED,
                self::STATUS_COMPLETED,
                self::STATUS_CANCELLED,
            ])],
            'type' => ['required', 'string', Rule::in(array_keys(self::TYPES))],
        ];
    }

    /**
     * Get the human-readable statuses.
     *
     * @return array
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_PAUSED => 'Paused',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_CANCELLED => 'Cancelled',
        ];
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::creating(function ($campaign) {
            $campaign->slug = Str::slug($campaign->name);
            $campaign->created_by = $campaign->created_by ?? auth()->id();
        });

        static::updating(function ($campaign) {
            if ($campaign->isDirty('name')) {
                $campaign->slug = Str::slug($campaign->name);
            }
        });
    }

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function contacts()
    {
        return $this->hasMany(CampaignContact::class);
    }

    /**
     * Scope a query to only include active campaigns.
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Get the URL to the campaign's show page.
     */
    public function getUrlAttribute(): string
    {
        return route('campaigns.show', $this);
    }
}
