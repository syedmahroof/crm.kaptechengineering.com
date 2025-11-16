<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Reminder extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'reminder_at',
        'is_completed',
        'user_id',
        'lead_id',
        'type',
        'priority'
    ];

    protected $casts = [
        'reminder_at' => 'datetime',
        'is_completed' => 'boolean',
    ];

    public function remindable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }
}
