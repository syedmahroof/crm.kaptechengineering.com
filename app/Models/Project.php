<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonInterface;
use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read int $id
 * @property int $user_id
 * @property string $name
 * @property User $user
 * @property Page[] $pages
 * @property Activity[] $activities
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface $updated_at
 */
final class Project extends Model
{
    /** @use HasFactory<ProjectFactory> */
    use HasFactory;
    
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'status',
        'project_type',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the user that owns the project.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the pages for the project.
     *
     * @return HasMany<Page, $this>
     */
    public function pages(): HasMany
    {
        return $this->hasMany(Page::class);
    }

    /**
     * Get the activities for the project.
     *
     * @return HasMany<Activity, $this>
     */
    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * Get the contacts for the project.
     *
     * @return HasMany<Contact, $this>
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Get the enquiries for the project.
     *
     * @return HasMany<Enquiry, $this>
     */
    public function enquiries(): HasMany
    {
        return $this->hasMany(Enquiry::class);
    }

    /**
     * Get the visit reports for the project.
     *
     * @return HasMany<VisitReport, $this>
     */
    public function visitReports(): HasMany
    {
        return $this->hasMany(VisitReport::class);
    }

    /**
     * Get the project contacts.
     *
     * @return HasMany<ProjectContact, $this>
     */
    public function projectContacts(): HasMany
    {
        return $this->hasMany(ProjectContact::class);
    }

    /**
     * Get all available project types
     */
    public static function getProjectTypes(): array
    {
        return [
            'residential' => 'Residential',
            'commercial' => 'Commercial',
            'industrial' => 'Industrial',
            'infrastructure' => 'Infrastructure',
            'hospital' => 'Hospital',
            'hotel' => 'Hotel',
            'educational' => 'Educational',
            'retail' => 'Retail',
            'office' => 'Office',
            'mixed_use' => 'Mixed Use',
            'other' => 'Other',
        ];
    }

    /**
     * Scope a query to filter by project type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('project_type', $type);
    }
}
