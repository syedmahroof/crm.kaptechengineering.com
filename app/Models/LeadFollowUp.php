<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class LeadFollowUp extends Model
{
    use SoftDeletes;

    public const TYPE_CALL = 'call';
    public const TYPE_EMAIL = 'email';
    public const TYPE_MEETING = 'meeting';
    public const TYPE_TASK = 'task';
    public const TYPE_OTHER = 'other';

    public const STATUS_SCHEDULED = 'scheduled';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELED = 'canceled';
    public const STATUS_NO_SHOW = 'no_show';

    protected $fillable = [
        'lead_id',
        'type',
        'title',
        'description',
        'scheduled_at',
        'completed_at',
        'status',
        'created_by',
        'assigned_to',
        'reminder_at',
        'location',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'completed_at' => 'datetime',
        'reminder_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    
    protected $attributes = [
        'status' => self::STATUS_SCHEDULED,
        'type' => self::TYPE_OTHER,
    ];

    public static function getTypes(): array
    {
        return [
            self::TYPE_CALL => 'Phone Call',
            self::TYPE_EMAIL => 'Email',
            self::TYPE_MEETING => 'Meeting',
            self::TYPE_TASK => 'Task',
            self::TYPE_OTHER => 'Other',
        ];
    }

    public static function getStatuses(): array
    {
        return [
            self::STATUS_SCHEDULED => 'Scheduled',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_CANCELED => 'Canceled',
            self::STATUS_NO_SHOW => 'No Show',
        ];
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_SCHEDULED)
            ->where('scheduled_at', '>=', now())
            ->orderBy('scheduled_at');
    }

    public function scopePastDue(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_SCHEDULED)
            ->where('scheduled_at', '<', now())
            ->orderBy('scheduled_at');
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_COMPLETED)
            ->orderBy('completed_at', 'desc');
    }

    public function markAsCompleted(): bool
    {
        return $this->update([
            'status' => self::STATUS_COMPLETED,
            'completed_at' => now(),
        ]);
    }

    public function markAsCanceled(?string $reason = null): bool
    {
        return $this->update([
            'status' => self::STATUS_CANCELED,
            'notes' => $reason ? ($this->notes ? $this->notes . "\n\nCanceled: " . $reason : "Canceled: " . $reason) : $this->notes,
        ]);
    }

    public function isUpcoming(): bool
    {
        return $this->status === self::STATUS_SCHEDULED && $this->scheduled_at->isFuture();
    }

    public function isPastDue(): bool
    {
        return $this->status === self::STATUS_SCHEDULED && $this->scheduled_at->isPast();
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }
}
