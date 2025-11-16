<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'project',
        'category',
        'assigned_to',
        'created_by',
        'status',
        'priority',
        'tags',
        'story_points',
        'estimated_hours',
        'due_date',
        'started_at',
        'completed_at',
        'reviewed_at',
        'attachments',
        'notes',
        'color',
        'position',
        'parent_task_id',
        'deadline_type',
        'is_public',
        'completion_percentage',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'tags' => 'array',
        'attachments' => 'array',
        'is_public' => 'boolean',
        'completion_percentage' => 'integer',
        'story_points' => 'integer',
        'position' => 'integer',
    ];

    // Kanban status constants
    const STATUS_TODO = 'todo';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_HOLD = 'hold';
    const STATUS_REVIEW = 'review';
    const STATUS_DONE = 'done';

    // Priority constants
    const PRIORITY_LOW = 'low';
    const PRIORITY_MEDIUM = 'medium';
    const PRIORITY_HIGH = 'high';
    const PRIORITY_URGENT = 'urgent';

    // Deadline types
    const DEADLINE_DUE_DATE = 'due_date';
    const DEADLINE_START_DATE = 'start_date';
    const DEADLINE_MILESTONE = 'milestone';

    /**
     * Get all available statuses
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_TODO => 'To Do',
            self::STATUS_IN_PROGRESS => 'In Progress',
            self::STATUS_HOLD => 'On Hold',
            self::STATUS_REVIEW => 'In Review',
            self::STATUS_DONE => 'Done',
        ];
    }

    /**
     * Get all available priorities
     */
    public static function getPriorities(): array
    {
        return [
            self::PRIORITY_LOW => 'Low',
            self::PRIORITY_MEDIUM => 'Medium',
            self::PRIORITY_HIGH => 'High',
            self::PRIORITY_URGENT => 'Urgent',
        ];
    }

    /**
     * Get priority color
     */
    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            self::PRIORITY_URGENT => 'red',
            self::PRIORITY_HIGH => 'orange',
            self::PRIORITY_MEDIUM => 'yellow',
            self::PRIORITY_LOW => 'green',
            default => 'gray',
        };
    }

    /**
     * Get status color
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            self::STATUS_TODO => 'gray',
            self::STATUS_IN_PROGRESS => 'blue',
            self::STATUS_HOLD => 'yellow',
            self::STATUS_REVIEW => 'purple',
            self::STATUS_DONE => 'green',
            default => 'gray',
        };
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    
    // Alias for assignee to match frontend expectations
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the parent task
     */
    public function parentTask(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'parent_task_id');
    }

    /**
     * Get the subtasks
     */
    public function subtasks(): HasMany
    {
        return $this->hasMany(Task::class, 'parent_task_id')->orderBy('position');
    }

    /**
     * Scope queries
     */
    public function scopeIncomplete($query)
    {
        return $query->where('status', '!=', self::STATUS_DONE);
    }

    public function scopeAssignedTo($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeByProject($query, $project)
    {
        return $query->where('project', $project);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeWithTags($query, $tags)
    {
        return $query->whereJsonContains('tags', $tags);
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeOrderedByPosition($query)
    {
        return $query->orderBy('position')->orderBy('created_at');
    }

    /**
     * Task actions
     */
    public function complete()
    {
        $this->status = self::STATUS_DONE;
        $this->completed_at = now();
        $this->completion_percentage = 100;
        $this->save();
    }

    public function start()
    {
        $this->status = self::STATUS_IN_PROGRESS;
        $this->started_at = now();
        $this->save();
    }

    public function hold()
    {
        $this->status = self::STATUS_HOLD;
        $this->save();
    }

    public function review()
    {
        $this->status = self::STATUS_REVIEW;
        $this->reviewed_at = now();
        $this->save();
    }

    /**
     * Check if task is overdue
     */
    public function isOverdue(): bool
    {
        return $this->due_date && $this->due_date->isPast() && $this->status !== self::STATUS_DONE;
    }

    /**
     * Get days until due
     */
    public function daysUntilDue(): ?int
    {
        if (!$this->due_date) {
            return null;
        }

        return now()->diffInDays($this->due_date, false);
    }

    /**
     * Get formatted due date
     */
    public function getFormattedDueDateAttribute(): ?string
    {
        if (!$this->due_date) {
            return null;
        }

        return $this->due_date->format('M j, Y');
    }

    /**
     * Get task progress status
     */
    public function getProgressStatusAttribute(): string
    {
        if ($this->completion_percentage === 100) {
            return 'completed';
        } elseif ($this->completion_percentage > 0) {
            return 'in_progress';
        } else {
            return 'not_started';
        }
    }

    /**
     * Get task history
     */
    public function history(): HasMany
    {
        return $this->hasMany(TaskHistory::class)->latest();
    }

    /**
     * Record activity in task history
     */
    public function recordActivity(string $type, array $properties = [], ?string $description = null): void
    {
        $this->history()->create([
            'user_id' => Auth::id(),
            'type' => $type,
            'properties' => $properties,
            'description' => $description ?? $this->generateDescription($type, $properties),
        ]);
    }

    /**
     * Generate a human-readable description from activity type and properties
     */
    protected function generateDescription(string $type, array $properties): string
    {
        return match($type) {
            'created' => 'Task was created',
            'updated' => 'Task was updated',
            'status_changed' => 'Status changed from ' . ($properties['old_status'] ?? 'N/A') . ' to ' . ($properties['new_status'] ?? 'N/A'),
            'completed' => 'Task was marked as completed',
            'uncompleted' => 'Task was marked as incomplete',
            'assigned' => 'Task was assigned to ' . ($properties['assignee_name'] ?? 'someone'),
            'priority_changed' => 'Priority changed from ' . ($properties['old_priority'] ?? 'N/A') . ' to ' . ($properties['new_priority'] ?? 'N/A'),
            default => 'Task activity: ' . $type,
        };
    }
}
