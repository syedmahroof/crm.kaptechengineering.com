<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property-read int $id
 * @property string $name
 * @property string $email
 * @property CarbonInterface|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface $updated_at
 */
final class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The roles relationship is provided by the HasRoles trait.
     * The following methods are available from the HasRoles trait:
     * - roles() - Get all roles assigned to the user
     * - hasRole() - Check if user has a specific role
     * - assignRole() - Assign a role to the user
     * - syncRoles() - Sync multiple roles to the user
     * - removeRole() - Remove a role from the user
     */

    /**
     * Get the user's notifications.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    /**
     * Get all itineraries created by this user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function itineraries(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Itinerary::class);
    }

    /**
     * Get the user's notifications.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notifications(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(\App\Models\Notification::class, 'notifiable')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Get the user's unread notifications.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function unreadNotifications(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(\App\Models\Notification::class, 'notifiable')
            ->whereNull('read_at')
            ->orderBy('created_at', 'desc');
    }
    
    /**
     * Send the given notification.
     *
     * @param  mixed  $instance
     * @return void
     */
    public function notify($instance)
    {
        // This method is provided by the Notifiable trait
        parent::notify($instance);
    }

    /**
     * The lead agents that belong to the user.
     */
    public function leadAgent()
    {
        return $this->hasOne(LeadAgent::class);
    }

    /**
     * Get all of the reminders for the user.
     */
    public function reminders()
    {
        return $this->hasMany(Reminder::class);
    }

    /**
     * Get all of the notes for the user.
     */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    /**
     * Get all of the files for the user.
     */
    public function files()
    {
        return $this->hasMany(File::class);
    }


    /**
     * Get all follow-ups created by the user.
     */
    public function followUps()
    {
        return $this->hasMany(FollowUp::class);
    }

    /**
     * Get all follow-ups assigned to the user.
     */
    public function assignedFollowUps()
    {
        return $this->hasMany(FollowUp::class, 'assigned_to');
    }

    /**
     * Get all tasks assigned to the user.
     */
    public function assignedTasks()
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    /**
     * Get all tasks created by the user.
     */
    public function createdTasks()
    {
        return $this->hasMany(Task::class, 'created_by');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the projects for the user.
     *
     * @return HasMany<Project, $this>
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Get all blogs created by the user.
     *
     * @return HasMany<Blog, $this>
     */
    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class, 'author_id');
    }

    /**
     * Get all branches that belong to the user.
     *
     * @return BelongsToMany<Branch, $this>
     */
    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class, 'user_branches')
            ->withPivot('is_primary')
            ->withTimestamps();
    }

    /**
     * Get the primary branch for the user.
     *
     * @return BelongsToMany<Branch, $this>
     */
    public function primaryBranch(): BelongsToMany
    {
        return $this->belongsToMany(Branch::class, 'user_branches')
            ->wherePivot('is_primary', true)
            ->withPivot('is_primary')
            ->withTimestamps();
    }

    /**
     * Sync user branches with primary branch designation.
     *
     * @param array $branchIds
     * @param int|null $primaryBranchId
     * @return void
     */
    public function syncBranches(array $branchIds, ?int $primaryBranchId): void
    {
        $syncData = [];
        
        foreach ($branchIds as $branchId) {
            $syncData[$branchId] = [
                'is_primary' => $primaryBranchId !== null && $branchId == $primaryBranchId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        $this->branches()->sync($syncData);
    }

    /**
     * Get all teams that this user belongs to.
     *
     * @return BelongsToMany<Team, $this>
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_user')
            ->withTimestamps();
    }

    /**
     * Get all teams where this user is a team lead.
     *
     * @return BelongsToMany<Team, $this>
     */
    public function ledTeams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_lead')
            ->withTimestamps();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'preferences' => 'array',
        ];
    }
}
