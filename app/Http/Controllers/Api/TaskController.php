<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    /**
     * Get tasks with advanced filtering and search
     */
    public function index(Request $request)
    {
        $query = Task::with(['assignee', 'creator', 'subtasks'])
            ->whereNull('parent_task_id') // Only show parent tasks by default
            ->public();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('project', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->has('priority') && $request->priority) {
            $query->where('priority', $request->priority);
        }

        // Filter by assigned user
        if ($request->has('assigned_to') && $request->assigned_to) {
            $query->where('assigned_to', $request->assigned_to);
        }

        // Filter by project
        if ($request->has('project') && $request->project) {
            $query->where('project', $request->project);
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        // Filter by tags
        if ($request->has('tags') && $request->tags) {
            $tags = is_array($request->tags) ? $request->tags : explode(',', $request->tags);
            $query->where(function ($q) use ($tags) {
                foreach ($tags as $tag) {
                    $q->orWhereJsonContains('tags', trim($tag));
                }
            });
        }

        // Filter by date range
        if ($request->has('due_date_from') && $request->due_date_from) {
            $query->where('due_date', '>=', $request->due_date_from);
        }
        if ($request->has('due_date_to') && $request->due_date_to) {
            $query->where('due_date', '<=', $request->due_date_to);
        }

        // Filter by completion percentage
        if ($request->has('completion_min') && $request->completion_min) {
            $query->where('completion_percentage', '>=', $request->completion_min);
        }

        // Sort options
        $sortBy = $request->get('sort_by', 'position');
        $sortOrder = $request->get('sort_order', 'asc');
        
        if ($sortBy === 'position') {
            $query->orderedByPosition();
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Get results
        if ($request->has('kanban') && $request->kanban) {
            // Return tasks grouped by status for Kanban board
            $tasks = $query->get()->groupBy('status');
            return response()->json([
                'data' => $tasks,
                'statuses' => Task::getStatuses(),
                'priorities' => Task::getPriorities(),
            ]);
        } else {
            // Return paginated results for list view
            $perPage = $request->input('per_page', 15);
            $tasks = $query->paginate($perPage);
            
            return response()->json([
                'data' => $tasks->items(),
                'pagination' => [
                    'total' => $tasks->total(),
                    'per_page' => $tasks->perPage(),
                    'current_page' => $tasks->currentPage(),
                    'last_page' => $tasks->lastPage(),
                    'from' => $tasks->firstItem(),
                    'to' => $tasks->lastItem(),
                ],
                'statuses' => Task::getStatuses(),
                'priorities' => Task::getPriorities(),
            ]);
        }
    }

    /**
     * Get task statistics for dashboard
     */
    public function stats(Request $request)
    {
        $userId = $request->get('user_id', Auth::id());
        
        $stats = [
            'total' => Task::where('assigned_to', $userId)->count(),
            'todo' => Task::where('assigned_to', $userId)->where('status', Task::STATUS_TODO)->count(),
            'in_progress' => Task::where('assigned_to', $userId)->where('status', Task::STATUS_IN_PROGRESS)->count(),
            'hold' => Task::where('assigned_to', $userId)->where('status', Task::STATUS_HOLD)->count(),
            'review' => Task::where('assigned_to', $userId)->where('status', Task::STATUS_REVIEW)->count(),
            'done' => Task::where('assigned_to', $userId)->where('status', Task::STATUS_DONE)->count(),
            'overdue' => Task::where('assigned_to', $userId)
                ->where('due_date', '<', now())
                ->where('status', '!=', Task::STATUS_DONE)
                ->count(),
            'due_today' => Task::where('assigned_to', $userId)
                ->whereDate('due_date', today())
                ->where('status', '!=', Task::STATUS_DONE)
                ->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Get my tasks (assigned to current user)
     */
    public function myTasks(Request $request)
    {
        $query = Task::with(['assignee', 'creator', 'subtasks'])
            ->where('assigned_to', Auth::id())
            ->whereNull('parent_task_id');

        // Apply same filters as index
        $this->applyFilters($query, $request);

        if ($request->has('kanban') && $request->kanban) {
            $tasks = $query->get()->groupBy('status');
            return response()->json([
                'data' => $tasks,
                'statuses' => Task::getStatuses(),
                'priorities' => Task::getPriorities(),
            ]);
        } else {
            $perPage = $request->input('per_page', 15);
        $tasks = $query->paginate($perPage);

        return response()->json([
            'data' => $tasks->items(),
            'pagination' => [
                'total' => $tasks->total(),
                'per_page' => $tasks->perPage(),
                'current_page' => $tasks->currentPage(),
                'last_page' => $tasks->lastPage(),
                'from' => $tasks->firstItem(),
                'to' => $tasks->lastItem(),
                ],
        ]);
        }
    }

    /**
     * Store a new task
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'assigned_to' => 'nullable|exists:users,id',
            'priority' => ['nullable', Rule::in(array_keys(Task::getPriorities()))],
            'status' => ['nullable', Rule::in(array_keys(Task::getStatuses()))],
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'story_points' => 'nullable|integer|min:1|max:100',
            'estimated_hours' => 'nullable|string|max:50',
            'due_date' => 'nullable|date|after:now',
            'color' => 'nullable|string|max:7',
            'parent_task_id' => 'nullable|exists:tasks,id',
            'deadline_type' => ['nullable', Rule::in([Task::DEADLINE_DUE_DATE, Task::DEADLINE_START_DATE, Task::DEADLINE_MILESTONE])],
            'is_public' => 'nullable|boolean',
            'completion_percentage' => 'nullable|integer|min:0|max:100',
        ]);

        // Get next position for the status
        $status = $validated['status'] ?? Task::STATUS_TODO;
        $maxPosition = Task::where('status', $status)->max('position') ?? 0;

        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'project' => $validated['project'] ?? null,
            'category' => $validated['category'] ?? null,
            'assigned_to' => $validated['assigned_to'] ?? Auth::id(),
            'created_by' => Auth::id(),
            'priority' => $validated['priority'] ?? Task::PRIORITY_MEDIUM,
            'status' => $status,
            'tags' => $validated['tags'] ?? [],
            'story_points' => $validated['story_points'] ?? null,
            'estimated_hours' => $validated['estimated_hours'] ?? null,
            'due_date' => $validated['due_date'] ?? null,
            'color' => $validated['color'] ?? null,
            'parent_task_id' => $validated['parent_task_id'] ?? null,
            'deadline_type' => $validated['deadline_type'] ?? Task::DEADLINE_DUE_DATE,
            'is_public' => $validated['is_public'] ?? true,
            'completion_percentage' => $validated['completion_percentage'] ?? 0,
            'position' => $maxPosition + 1,
        ]);

        return response()->json([
            'message' => 'Task created successfully',
            'task' => $task->load(['assignee', 'creator', 'subtasks']),
        ], 201);
    }

    /**
     * Show a specific task
     */
    public function show(Task $task)
    {
        $task->load(['assignee', 'creator', 'subtasks.assignee', 'parentTask']);
        
        return response()->json([
            'task' => $task,
        ]);
    }

    /**
     * Update a task
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'project' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'assigned_to' => 'nullable|exists:users,id',
            'priority' => ['nullable', Rule::in(array_keys(Task::getPriorities()))],
            'status' => ['nullable', Rule::in(array_keys(Task::getStatuses()))],
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'story_points' => 'nullable|integer|min:1|max:100',
            'estimated_hours' => 'nullable|string|max:50',
            'due_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'parent_task_id' => 'nullable|exists:tasks,id',
            'deadline_type' => ['nullable', Rule::in([Task::DEADLINE_DUE_DATE, Task::DEADLINE_START_DATE, Task::DEADLINE_MILESTONE])],
            'is_public' => 'nullable|boolean',
            'completion_percentage' => 'nullable|integer|min:0|max:100',
        ]);

        // Handle status changes with timestamps
        if (isset($validated['status']) && $validated['status'] !== $task->status) {
            $newStatus = $validated['status'];
            
            switch ($newStatus) {
                case Task::STATUS_IN_PROGRESS:
                    if (!$task->started_at) {
                        $validated['started_at'] = now();
                    }
                    break;
                case Task::STATUS_REVIEW:
                    $validated['reviewed_at'] = now();
                    break;
                case Task::STATUS_DONE:
                    $validated['completed_at'] = now();
                    $validated['completion_percentage'] = 100;
                    break;
            }
        }

        $task->update($validated);

        return response()->json([
            'message' => 'Task updated successfully',
            'task' => $task->load(['assignee', 'creator', 'subtasks']),
        ]);
    }

    /**
     * Update task position (for drag and drop)
     */
    public function updatePosition(Request $request, Task $task)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(array_keys(Task::getStatuses()))],
            'position' => 'required|integer|min:0',
        ]);

        // Update other tasks' positions in the same status
        Task::where('status', $validated['status'])
            ->where('id', '!=', $task->id)
            ->where('position', '>=', $validated['position'])
            ->increment('position');

        // Update the task
        $task->update([
            'status' => $validated['status'],
            'position' => $validated['position'],
        ]);

        // Handle status change timestamps
        switch ($validated['status']) {
            case Task::STATUS_IN_PROGRESS:
                if (!$task->started_at) {
                    $task->update(['started_at' => now()]);
                }
                break;
            case Task::STATUS_REVIEW:
                $task->update(['reviewed_at' => now()]);
                break;
            case Task::STATUS_DONE:
                $task->update([
                    'completed_at' => now(),
                    'completion_percentage' => 100,
                ]);
                break;
        }

        return response()->json([
            'message' => 'Task position updated successfully',
            'task' => $task->load(['assignee', 'creator']),
        ]);
    }

    /**
     * Delete a task
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully',
        ]);
    }

    /**
     * Mark a task as completed
     */
    public function complete(Task $task)
    {
        $task->complete();

        return response()->json([
            'message' => 'Task marked as completed successfully',
            'task' => $task->load(['assignee', 'creator', 'subtasks']),
        ]);
    }

    /**
     * Get available users for assignment
     */
    public function getUsers()
    {
        $users = User::select('id', 'name', 'email')
            ->where('id', '!=', Auth::id())
            ->orderBy('name')
            ->get();

        return response()->json($users);
    }

    /**
     * Get unique projects and categories
     */
    public function getFilters()
    {
        $projects = Task::whereNotNull('project')
            ->distinct()
            ->pluck('project')
            ->filter()
            ->sort()
            ->values();

        $categories = Task::whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();

        $tags = Task::whereNotNull('tags')
            ->get()
            ->pluck('tags')
            ->flatten()
            ->unique()
            ->filter()
            ->sort()
            ->values();

        return response()->json([
            'projects' => $projects,
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    /**
     * Apply filters to query
     */
    private function applyFilters($query, Request $request)
    {
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('project', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('priority') && $request->priority) {
            $query->where('priority', $request->priority);
        }

        if ($request->has('assigned_to') && $request->assigned_to) {
            $query->where('assigned_to', $request->assigned_to);
        }

        if ($request->has('project') && $request->project) {
            $query->where('project', $request->project);
        }

        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        if ($request->has('tags') && $request->tags) {
            $tags = is_array($request->tags) ? $request->tags : explode(',', $request->tags);
            $query->where(function ($q) use ($tags) {
                foreach ($tags as $tag) {
                    $q->orWhereJsonContains('tags', trim($tag));
                }
            });
        }

        if ($request->has('due_date_from') && $request->due_date_from) {
            $query->where('due_date', '>=', $request->due_date_from);
        }
        if ($request->has('due_date_to') && $request->due_date_to) {
            $query->where('due_date', '<=', $request->due_date_to);
        }

        if ($request->has('completion_min') && $request->completion_min) {
            $query->where('completion_percentage', '>=', $request->completion_min);
        }

        $sortBy = $request->get('sort_by', 'position');
        $sortOrder = $request->get('sort_order', 'asc');
        
        if ($sortBy === 'position') {
            $query->orderedByPosition();
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }
    }
}