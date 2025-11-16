<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CampaignContact extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'age',
        'dream_destination',
        'travel_experience',
        'social_media',
        'campaign_id',
        'additional_data',
        'terms_accepted',
        'is_winner',
        'winner_selected_at',
        'winner_notes',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'additional_data' => 'array',
        'terms_accepted' => 'boolean',
        'is_winner' => 'boolean',
        'winner_selected_at' => 'datetime',
        'age' => 'integer',
    ];

    /**
     * Get the campaign that owns the contact.
     */
    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }
}
