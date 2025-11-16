<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get all team leads (users) for this team.
     */
    public function teamLeads(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'team_lead')
            ->withTimestamps();
    }

    /**
     * Get the first team lead (for backward compatibility).
     */
    public function teamLead()
    {
        return $this->teamLeads()->first();
    }

    /**
     * Get all users in this team.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'team_user')
            ->withTimestamps();
    }

    /**
     * Get all leads assigned to team members.
     */
    public function leads()
    {
        $teamUserIds = $this->users()->pluck('users.id');
        return Lead::whereIn('assigned_user_id', $teamUserIds);
    }
}
