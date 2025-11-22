<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class VisitReport extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'visit_date',
        'objective',
        'report',
        'next_meeting_date',
        'next_call_date',
    ];

    protected $casts = [
        'visit_date' => 'date',
        'next_meeting_date' => 'date',
        'next_call_date' => 'date',
    ];

    /**
     * Get the user that created the visit report.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all related entities (projects, customers, contacts).
     */
    public function visitReportables(): MorphToMany
    {
        return $this->morphToMany(
            Model::class,
            'visit_reportable',
            'visit_reportables',
            'visit_report_id',
            'visit_reportable_id'
        )->withTimestamps();
    }

    /**
     * Get related projects.
     */
    public function projects(): MorphToMany
    {
        return $this->morphToMany(Project::class, 'visit_reportable', 'visit_reportables', 'visit_report_id', 'visit_reportable_id')
            ->withTimestamps();
    }

    /**
     * Get related customers.
     */
    public function customers(): MorphToMany
    {
        return $this->morphToMany(Customer::class, 'visit_reportable', 'visit_reportables', 'visit_report_id', 'visit_reportable_id')
            ->withTimestamps();
    }

    /**
     * Get related contacts.
     */
    public function contacts(): MorphToMany
    {
        return $this->morphToMany(Contact::class, 'visit_reportable', 'visit_reportables', 'visit_report_id', 'visit_reportable_id')
            ->withTimestamps();
    }

    /**
     * Get the first project (for backward compatibility).
     */
    public function getProjectAttribute()
    {
        return $this->projects()->first();
    }

    /**
     * Scope to filter by project.
     */
    public function scopeForProject($query, $projectId)
    {
        return $query->whereHas('projects', function ($q) use ($projectId) {
            $q->where('visit_reportables.visit_reportable_id', $projectId);
        });
    }

    /**
     * Scope to filter by customer.
     */
    public function scopeForCustomer($query, $customerId)
    {
        return $query->whereHas('customers', function ($q) use ($customerId) {
            $q->where('visit_reportables.visit_reportable_id', $customerId);
        });
    }

    /**
     * Scope to filter by contact.
     */
    public function scopeForContact($query, $contactId)
    {
        return $query->whereHas('contacts', function ($q) use ($contactId) {
            $q->where('visit_reportables.visit_reportable_id', $contactId);
        });
    }
}
