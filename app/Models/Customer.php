<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Customer extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'company',
        'job_title',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'notes',
        'user_id',
        'branch_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the user that owns the customer.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Get the visit reports for the customer.
     */
    public function visitReports(): MorphToMany
    {
        return $this->morphToMany(VisitReport::class, 'visit_reportable', 'visit_reportables', 'visit_reportable_id', 'visit_report_id')
            ->withTimestamps();
    }

    /**
     * Get the leads for the customer.
     */
    public function leads(): MorphToMany
    {
        return $this->morphToMany(Lead::class, 'leadable', 'leadables', 'leadable_id', 'lead_id')
            ->withTimestamps();
    }

    /**
     * Get the customer's full name.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Backwards-compatible `name` accessor for templates and code that expect a `name` attribute.
     */
    public function getNameAttribute(): string
    {
        $full = trim("{$this->first_name} {$this->last_name}");
        if (!empty($full)) {
            return $full;
        }

        return $this->company ?? ($this->email ?? '');
    }
}
