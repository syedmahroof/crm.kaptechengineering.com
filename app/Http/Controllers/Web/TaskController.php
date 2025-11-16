<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display the tasks index page
     */
    public function index(Request $request)
    {
        $query = Task::with(['assignee', 'creator', 'subtasks'])
            ->whereNull('parent_task_id')
            ->public();

        // Apply filters
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

        // Sort and paginate
        $sortBy = $request->get('sort_by', 'position');
        $sortOrder = $request->get('sort_order', 'asc');
        
        if ($sortBy === 'position') {
            $query->orderedByPosition();
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        $tasks = $query->paginate(15);

        // Get filter options
        $filters = $this->getFilterOptions();

        return view('admin.tasks.index', [
            'initialTasks' => $tasks->items(),
            'statuses' => Task::getStatuses(),
            'priorities' => Task::getPriorities(),
            'users' => User::select('id', 'name', 'email')->orderBy('name')->get(),
            'filters' => $filters,
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

    /**
     * Display the task dashboard
     */
    public function dashboard()
    {
        $userId = Auth::id();
        
        // Get task statistics
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

        // Get recent tasks
        $recentTasks = Task::with(['assignee', 'creator'])
            ->where('assigned_to', $userId)
            ->whereNull('parent_task_id')
            ->orderBy('updated_at', 'desc')
            ->limit(10)
            ->get();

        // Get upcoming tasks (due in next 7 days)
        $upcomingTasks = Task::with(['assignee', 'creator'])
            ->where('assigned_to', $userId)
            ->where('due_date', '>=', now())
            ->where('due_date', '<=', now()->addDays(7))
            ->where('status', '!=', Task::STATUS_DONE)
            ->whereNull('parent_task_id')
            ->orderBy('due_date')
            ->get();

        // Get overdue tasks
        $overdueTasks = Task::with(['assignee', 'creator'])
            ->where('assigned_to', $userId)
            ->where('due_date', '<', now())
            ->where('status', '!=', Task::STATUS_DONE)
            ->whereNull('parent_task_id')
            ->orderBy('due_date')
            ->get();

        return view('admin.tasks.dashboard', [
            'initialStats' => $stats,
            'recentTasks' => $recentTasks,
            'upcomingTasks' => $upcomingTasks,
            'overdueTasks' => $overdueTasks,
        ]);
    }

    /**
     * Display the Kanban board
     */
    public function kanban(Request $request)
    {
        $query = Task::with(['assignee', 'creator', 'subtasks'])
            ->whereNull('parent_task_id')
            ->public();

        // Apply filters
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('project', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->has('project') && $request->project) {
            $query->where('project', $request->project);
        }

        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        if ($request->has('priority') && $request->priority) {
            $query->where('priority', $request->priority);
        }

        if ($request->has('assigned_to') && $request->assigned_to) {
            $query->where('assigned_to', $request->assigned_to);
        }

        $tasks = $query->orderedByPosition()->get()->groupBy('status');

        // Get filter options
        $filters = $this->getFilterOptions();

        return view('admin.tasks.kanban', [
            'initialTasks' => $tasks,
            'statuses' => Task::getStatuses(),
            'priorities' => Task::getPriorities(),
            'users' => User::select('id', 'name', 'email')->orderBy('name')->get(),
            'filters' => $filters,
        ]);
    }

    /**
     * Display my tasks
     */
    public function myTasks(Request $request)
    {
        $query = Task::with(['assignee', 'creator', 'subtasks'])
            ->where('assigned_to', Auth::id())
            ->whereNull('parent_task_id');

        // Apply same filters as index
        $this->applyFilters($query, $request);

        $tasks = $query->paginate(15);

        // Get filter options
        $filters = $this->getFilterOptions();

        return view('admin.tasks.index', [
            'initialTasks' => $tasks->items(),
            'statuses' => Task::getStatuses(),
            'priorities' => Task::getPriorities(),
            'users' => User::select('id', 'name', 'email')->orderBy('name')->get(),
            'filters' => $filters,
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

    /**
     * Show the form for creating a new task
     */
    public function create()
    {
        return view('admin.tasks.create', [
            'users' => User::select('id', 'name', 'email')->orderBy('name')->get(),
            'parentTasks' => Task::whereNull('parent_task_id')
                ->select('id', 'title')
                ->orderBy('title')
                ->get(),
        ]);
    }

    /**
     * Store a newly created task
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'assigned_to' => 'nullable|exists:users,id',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:todo,in_progress,hold,review,done',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'story_points' => 'nullable|integer|min:1|max:100',
            'estimated_hours' => 'nullable|string|max:50',
            'due_date' => 'nullable|date',
            'color' => 'nullable|string|max:7',
            'parent_task_id' => 'nullable|exists:tasks,id',
            'deadline_type' => 'required|in:due_date,start_date,milestone',
            'is_public' => 'nullable|boolean',
            'completion_percentage' => 'nullable|integer|min:0|max:100',
        ]);

        // Get next position for the status
        $status = $validated['status'];
        $maxPosition = Task::where('status', $status)->max('position') ?? 0;

        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'project' => $validated['project'] ?? null,
            'category' => $validated['category'] ?? null,
            'assigned_to' => $validated['assigned_to'] ?? Auth::id(),
            'created_by' => Auth::id(),
            'priority' => $validated['priority'],
            'status' => $status,
            'tags' => $validated['tags'] ?? [],
            'story_points' => $validated['story_points'] ?? null,
            'estimated_hours' => $validated['estimated_hours'] ?? null,
            'due_date' => $validated['due_date'] ?? null,
            'color' => $validated['color'] ?? null,
            'parent_task_id' => $validated['parent_task_id'] ?? null,
            'deadline_type' => $validated['deadline_type'],
            'is_public' => $validated['is_public'] ?? true,
            'completion_percentage' => $validated['completion_percentage'] ?? 0,
            'position' => $maxPosition + 1,
        ]);

        // Record creation in history
        $task->recordActivity('created', [
            'title' => $task->title,
            'status' => $task->status,
            'priority' => $task->priority,
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified task
     */
    public function show(Task $task)
    {
        $task->load(['assignee', 'creator', 'subtasks.assignee', 'parentTask', 'history.user']);
        
        return view('admin.tasks.show', [
            'task' => $task,
            'statuses' => Task::getStatuses(),
            'priorities' => Task::getPriorities(),
        ]);
    }

    /**
     * Show the form for editing the specified task
     */
    public function edit(Task $task)
    {
        return view('admin.tasks.edit', [
            'task' => $task,
            'users' => User::select('id', 'name', 'email')->orderBy('name')->get(),
            'parentTasks' => Task::whereNull('parent_task_id')
                ->where('id', '!=', $task->id)
                ->select('id', 'title')
                ->orderBy('title')
                ->get(),
            'isEdit' => true,
        ]);
    }

    /**
     * Update the specified task
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'project' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'assigned_to' => 'nullable|exists:users,id',
            'priority' => 'nullable|in:low,medium,high,urgent',
            'status' => 'nullable|in:todo,in_progress,hold,review,done',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'story_points' => 'nullable|integer|min:1|max:100',
            'estimated_hours' => 'nullable|string|max:50',
            'due_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'parent_task_id' => 'nullable|exists:tasks,id',
            'deadline_type' => 'nullable|in:due_date,start_date,milestone',
            'is_public' => 'nullable|boolean',
            'completion_percentage' => 'nullable|integer|min:0|max:100',
        ]);

        // Track changes for history
        $changes = [];
        $oldStatus = $task->status;
        $oldPriority = $task->priority;
        $oldAssignee = $task->assigned_to;

        // Handle status changes with timestamps
        if (isset($validated['status']) && $validated['status'] !== $task->status) {
            $newStatus = $validated['status'];
            $changes['status'] = ['old' => $oldStatus, 'new' => $newStatus];
            
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

        // Track priority changes
        if (isset($validated['priority']) && $validated['priority'] !== $task->priority) {
            $changes['priority'] = ['old' => $oldPriority, 'new' => $validated['priority']];
        }

        // Track assignee changes
        if (isset($validated['assigned_to']) && $validated['assigned_to'] != $oldAssignee) {
            $newAssignee = User::find($validated['assigned_to']);
            $changes['assigned_to'] = [
                'old' => $task->assignee?->name ?? 'Unassigned',
                'new' => $newAssignee?->name ?? 'Unassigned',
            ];
        }

        $task->update($validated);

        // Record history for changes
        if (!empty($changes)) {
            if (isset($changes['status'])) {
                $task->recordActivity('status_changed', [
                    'old_status' => $changes['status']['old'],
                    'new_status' => $changes['status']['new'],
                ]);
            }
            if (isset($changes['priority'])) {
                $task->recordActivity('priority_changed', [
                    'old_priority' => $changes['priority']['old'],
                    'new_priority' => $changes['priority']['new'],
                ]);
            }
            if (isset($changes['assigned_to'])) {
                $task->recordActivity('assigned', [
                    'assignee_name' => $changes['assigned_to']['new'],
                    'old_assignee' => $changes['assigned_to']['old'],
                ]);
            }
            if (count($changes) > 1 || (!isset($changes['status']) && !isset($changes['priority']) && !isset($changes['assigned_to']))) {
                $task->recordActivity('updated', $changes);
            }
        }

        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified task
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully.');
    }

    /**
     * Get filter options for the frontend
     */
    private function getFilterOptions()
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

        return [
            'projects' => $projects,
            'categories' => $categories,
            'tags' => $tags,
        ];
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

    /**
     * Toggle task completion status
     */
    public function toggleComplete(Request $request, Task $task)
    {
        $isCompleted = $request->input('completed', false);

        if ($isCompleted && $task->status !== Task::STATUS_DONE) {
            $task->status = Task::STATUS_DONE;
            $task->completed_at = now();
            $task->completion_percentage = 100;
            $task->save();

            $task->recordActivity('completed', [
                'completed_at' => $task->completed_at->toDateTimeString(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Task marked as completed',
                'status' => $task->status,
                'completed' => true,
            ]);
        } elseif (!$isCompleted && $task->status === Task::STATUS_DONE) {
            $oldStatus = $task->status;
            $task->status = Task::STATUS_TODO;
            $task->completed_at = null;
            $task->completion_percentage = 0;
            $task->save();

            $task->recordActivity('uncompleted', [
                'old_status' => $oldStatus,
                'new_status' => $task->status,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Task marked as incomplete',
                'status' => $task->status,
                'completed' => false,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'No change needed',
            'status' => $task->status,
            'completed' => $task->status === Task::STATUS_DONE,
        ]);
    }
}