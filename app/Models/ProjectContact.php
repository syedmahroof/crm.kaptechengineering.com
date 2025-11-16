<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectContact extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'project_id',
        'name',
        'role',
        'phone',
        'email',
        'is_primary',
        'notes',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    /**
     * Get the project that owns the contact.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Available contact roles for projects.
     */
    public static function getRoles(): array
    {
        return [
            'project_manager' => 'Project Manager',
            'manager' => 'Manager',
            'site_engineer' => 'Site Engineer',
            'architect' => 'Architect',
            'plumber' => 'Plumber',
            'electrician' => 'Electrician',
            'hvac' => 'HVAC',
            'carpenter' => 'Carpenter',
            'painter' => 'Painter',
            'civil_contractor' => 'Civil Contractor',
            'fire_safety' => 'Fire Safety',
            'procurement' => 'Procurement',
            'consultant' => 'Consultant',
            'other' => 'Other',
        ];
    }

    /**
     * Accessor for friendly role label.
     */
    public function getRoleLabelAttribute(): string
    {
        if (isset(static::getRoles()[$this->role])) {
            return static::getRoles()[$this->role];
        }

        $label = str_replace('_', ' ', $this->role ?? 'Contact');

        return \Illuminate\Support\Str::title($label);
    }
}
