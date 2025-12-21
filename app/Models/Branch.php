<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Branch extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'address',
        'phone',
        'email',
        'manager_name',
        'manager_phone',
        'manager_email',
        'is_active',
        'description',
        'timezone',
        'working_hours',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'working_hours' => 'array',
    ];

    /**
     * The attributes that should have default values.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'is_active' => true,
        'timezone' => 'UTC',
    ];

    /**
     * Scope a query to only include active branches.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include inactive branches.
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Get the users for the branch.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_branches')
            ->withPivot('is_primary')
            ->withTimestamps();
    }

    /**
     * Get the leads for the branch.
     */
    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }

    /**
     * Get the customers for the branch.
     */
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    /**
     * Get the projects for the branch.
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Get the builders for the branch.
     */
    public function builders(): HasMany
    {
        return $this->hasMany(Builder::class);
    }
}