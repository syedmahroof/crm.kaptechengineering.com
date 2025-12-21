<?php

namespace App\Models;

use App\Traits\HasNotifications;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Contact extends Model
{
    use HasFactory, SoftDeletes, HasNotifications;

    protected $fillable = [
        'name',
        'company_name',
        'email',
        'phone',
        'contact_type',
        'country_id',
        'state_id',
        'district_id',
        'branch_id',
        'address',
        'subject',
        'message',
        'priority',
        'admin_notes',
        'replied_at',
        'replied_by',
        'project_id',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    // Relationships
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function repliedBy()
    {
        return $this->belongsTo(User::class, 'replied_by');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    /**
     * The enquiries that belong to the contact.
     */
    public function enquiries()
    {
        return $this->belongsToMany(Enquiry::class, 'enquiry_contact')
                    ->withPivot('contact_type', 'notes')
                    ->withTimestamps();
    }

    // Scopes
    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeHighPriority($query)
    {
        return $query->whereIn('priority', ['high', 'urgent']);
    }

    // Accessors
    public function getPriorityColorAttribute()
    {
        return match($this->priority) {
            'low' => 'green',
            'medium' => 'yellow',
            'high' => 'orange',
            'urgent' => 'red',
            default => 'gray',
        };
    }

    public function getIsUrgentAttribute()
    {
        return $this->priority === 'urgent';
    }

  

    /**
     * Get the visit reports for the contact.
     */
    public function visitReports(): MorphToMany
    {
        return $this->morphToMany(VisitReport::class, 'visit_reportable', 'visit_reportables', 'visit_reportable_id', 'visit_report_id')
            ->withTimestamps();
    }

    /**
     * Get the leads for the contact.
     */
    public function leads(): MorphToMany
    {
        return $this->morphToMany(Lead::class, 'leadable', 'leadables', 'leadable_id', 'lead_id')
            ->withTimestamps();
    }

    /**
     * Scope a query to filter by contact type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('contact_type', $type);
    }
}
