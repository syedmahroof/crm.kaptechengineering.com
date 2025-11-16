<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'category',
        'is_pinned',
        'noteable_id',
        'noteable_type',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get available note categories
     */
    public static function getCategories(): array
    {
        return [
            'general' => 'General',
            'meeting' => 'Meeting',
            'project' => 'Project',
            'personal' => 'Personal',
            'reminder' => 'Reminder',
            'idea' => 'Idea',
            'todo' => 'To Do',
            'other' => 'Other',
        ];
    }
}
