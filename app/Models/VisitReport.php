<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class VisitReport extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'project_id',
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
     * Get the project that owns the visit report.
     *
     * @return BelongsTo<Project, $this>
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user that created the visit report.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
