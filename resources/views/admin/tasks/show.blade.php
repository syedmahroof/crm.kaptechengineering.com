@extends('layouts.admin')

@section('title', $task->title)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-100 dark:from-gray-800 dark:to-gray-900 rounded-xl p-6 mb-6">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div class="flex-1 min-w-0">
                <div class="flex items-center space-x-4 mb-3">
                    <label class="flex items-center cursor-pointer group">
                        <input type="checkbox" 
                               id="taskCompleteCheckbox"
                               class="w-6 h-6 rounded border-2 border-gray-300 dark:border-gray-600 hover:border-green-500 dark:hover:border-green-500 transition-colors cursor-pointer appearance-none checked:bg-green-600 checked:border-green-600 dark:checked:bg-green-500 dark:checked:border-green-500"
                               {{ $task->status === 'done' ? 'checked' : '' }}
                               onchange="toggleComplete(this.checked)">
                        <span class="ml-3 text-3xl font-bold text-gray-900 dark:text-white {{ $task->status === 'done' ? 'line-through text-gray-400' : '' }}">
                            {{ $task->title }}
                        </span>
                    </label>
                </div>
                <div class="flex items-center space-x-3 flex-wrap">
                    @php
                        $statusColors = [
                            'todo' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                            'in_progress' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                            'hold' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                            'review' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300',
                            'done' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                        ];
                        $statusColor = $statusColors[$task->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $statusColor }}">
                        <i class="fas fa-circle text-xs mr-1"></i>
                        {{ $statuses[$task->status] ?? ucwords(str_replace('_', ' ', $task->status)) }}
                    </span>
                    @php
                        $priorityColors = [
                            'low' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                            'medium' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                            'high' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300',
                            'urgent' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                        ];
                        $priorityColor = $priorityColors[$task->priority] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $priorityColor }}">
                        <i class="fas fa-flag text-xs mr-1"></i>
                        {{ $priorities[$task->priority] ?? ucfirst($task->priority) }} Priority
                    </span>
                    <span class="text-sm text-gray-600 dark:text-gray-400 flex items-center">
                        <i class="far fa-clock mr-1"></i>
                        Created {{ $task->created_at->diffForHumans() }}
                    </span>
                    @if($task->parentTask)
                    <a href="{{ route('tasks.show', $task->parentTask->id) }}" 
                       class="px-3 py-1 text-sm font-medium text-indigo-600 bg-indigo-50 border border-indigo-200 rounded-lg hover:bg-indigo-100 dark:bg-indigo-900/20 dark:text-indigo-400">
                        <i class="fas fa-level-up-alt mr-1"></i>Parent Task
                    </a>
                    @endif
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('tasks.edit', $task->id) }}" 
                   class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 hover:border-blue-700 dark:bg-blue-500 dark:border-blue-500 dark:hover:bg-blue-400">
                    <i class="fas fa-pencil mr-2"></i>Edit
                </a>
                <a href="{{ route('tasks.index') }}" 
                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                    <i class="fas fa-arrow-left mr-2"></i>Back
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Task Details Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-blue-600"></i>Task Details
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Assigned To</label>
                        <p class="mt-1 text-gray-900 dark:text-white flex items-center">
                            <i class="fas fa-user mr-2 text-gray-400"></i>
                            {{ $task->assignee->name ?? 'Unassigned' }}
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Created By</label>
                        <p class="mt-1 text-gray-900 dark:text-white flex items-center">
                            <i class="fas fa-user-plus mr-2 text-gray-400"></i>
                            {{ $task->creator->name ?? 'Unknown' }}
                        </p>
                    </div>
                    @if($task->project)
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Project</label>
                        <p class="mt-1 text-gray-900 dark:text-white flex items-center">
                            <i class="fas fa-folder mr-2 text-gray-400"></i>
                            {{ $task->project }}
                        </p>
                    </div>
                    @endif
                    @if($task->category)
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Category</label>
                        <p class="mt-1 text-gray-900 dark:text-white flex items-center">
                            <i class="fas fa-tag mr-2 text-gray-400"></i>
                            {{ $task->category }}
                        </p>
                    </div>
                    @endif
                    @if($task->due_date)
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Due Date</label>
                        <p class="mt-1 text-gray-900 dark:text-white flex items-center">
                            <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>
                            {{ $task->due_date->format('M d, Y h:i A') }}
                            @if($task->isOverdue())
                                <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">Overdue</span>
                            @elseif($task->daysUntilDue() !== null && $task->daysUntilDue() <= 3 && $task->daysUntilDue() >= 0)
                                <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">Due Soon</span>
                            @endif
                        </p>
                    </div>
                    @endif
                    @if($task->started_at)
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Started At</label>
                        <p class="mt-1 text-gray-900 dark:text-white flex items-center">
                            <i class="fas fa-play-circle mr-2 text-blue-500"></i>
                            {{ $task->started_at->format('M d, Y h:i A') }}
                        </p>
                    </div>
                    @endif
                    @if($task->completed_at)
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Completed At</label>
                        <p class="mt-1 text-gray-900 dark:text-white flex items-center">
                            <i class="fas fa-check-circle mr-2 text-green-500"></i>
                            {{ $task->completed_at->format('M d, Y h:i A') }}
                        </p>
                    </div>
                    @endif
                    @if($task->reviewed_at)
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Reviewed At</label>
                        <p class="mt-1 text-gray-900 dark:text-white flex items-center">
                            <i class="fas fa-eye mr-2 text-purple-500"></i>
                            {{ $task->reviewed_at->format('M d, Y h:i A') }}
                        </p>
                    </div>
                    @endif
                    @if($task->story_points)
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Story Points</label>
                        <p class="mt-1 text-gray-900 dark:text-white flex items-center">
                            <i class="fas fa-chart-bar mr-2 text-gray-400"></i>
                            {{ $task->story_points }}
                        </p>
                    </div>
                    @endif
                    @if($task->estimated_hours)
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Estimated Hours</label>
                        <p class="mt-1 text-gray-900 dark:text-white flex items-center">
                            <i class="fas fa-clock mr-2 text-gray-400"></i>
                            {{ $task->estimated_hours }}
                        </p>
                    </div>
                    @endif
                </div>

                <!-- Completion Progress -->
                @if($task->completion_percentage !== null)
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Completion Progress</label>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $task->completion_percentage }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                        <div class="bg-blue-600 h-3 rounded-full transition-all duration-300" 
                             style="width: {{ $task->completion_percentage }}%"></div>
                    </div>
                </div>
                @endif

                <!-- Tags -->
                @if($task->tags && count($task->tags) > 0)
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2 block">Tags</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach($task->tags as $tag)
                        <span class="px-3 py-1 text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 rounded-full">
                            <i class="fas fa-tag mr-1 text-xs"></i>{{ $tag }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($task->description)
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</label>
                    <p class="mt-2 text-gray-900 dark:text-white whitespace-pre-wrap">{{ $task->description }}</p>
                </div>
                @endif

                @if($task->notes)
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Notes</label>
                    <p class="mt-2 text-gray-900 dark:text-white whitespace-pre-wrap">{{ $task->notes }}</p>
                </div>
                @endif
            </div>

            <!-- Subtasks Section -->
            @if($task->subtasks->count() > 0)
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                        <i class="fas fa-tasks mr-2 text-indigo-600"></i>Subtasks
                        <span class="ml-3 px-2 py-0.5 text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300 rounded-full">
                            {{ $task->subtasks->count() }}
                        </span>
                    </h2>
                </div>
                <div class="space-y-3">
                    @foreach($task->subtasks as $subtask)
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <div class="flex items-center space-x-3 flex-1">
                            <input type="checkbox" 
                                   class="w-5 h-5 rounded border-2 border-gray-300 dark:border-gray-600"
                                   {{ $subtask->status === 'done' ? 'checked' : '' }}
                                   disabled>
                            <div class="flex-1">
                                <a href="{{ route('tasks.show', $subtask->id) }}" 
                                   class="text-sm font-medium text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 {{ $subtask->status === 'done' ? 'line-through' : '' }}">
                                    {{ $subtask->title }}
                                </a>
                                <div class="flex items-center space-x-2 mt-1">
                                    @php
                                        $subtaskStatusColor = $statusColors[$subtask->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-2 py-0.5 text-xs rounded-full {{ $subtaskStatusColor }}">
                                        {{ $statuses[$subtask->status] ?? $subtask->status }}
                                    </span>
                                    @if($subtask->assignee)
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-user mr-1"></i>{{ $subtask->assignee->name }}
                                    </span>
                                    @endif
                                    @if($subtask->due_date)
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-calendar-alt mr-1"></i>{{ $subtask->due_date->format('M d') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('tasks.show', $subtask->id) }}" 
                           class="ml-4 px-3 py-1.5 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 dark:bg-blue-900/20 dark:text-blue-400">
                            <i class="fas fa-external-link-alt mr-1"></i>View
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Stats -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Stats</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Subtasks</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $task->subtasks->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Completed Subtasks</span>
                        <span class="text-sm font-semibold text-green-600 dark:text-green-400">
                            {{ $task->subtasks->where('status', 'done')->count() }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500 dark:text-gray-400">History Items</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $task->history->count() }}</span>
                    </div>
                    @if($task->due_date)
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Days Until Due</span>
                        <span class="text-sm font-semibold {{ $task->isOverdue() ? 'text-red-600 dark:text-red-400' : ($task->daysUntilDue() <= 3 ? 'text-yellow-600 dark:text-yellow-400' : 'text-gray-900 dark:text-white') }}">
                            {{ $task->daysUntilDue() > 0 ? $task->daysUntilDue() : ($task->isOverdue() ? abs($task->daysUntilDue()) . ' days overdue' : 'Due today') }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
                <div class="space-y-2">
                    @if($task->status !== 'done')
                    <button onclick="document.getElementById('taskCompleteCheckbox').click()" 
                            class="w-full px-4 py-2 text-sm font-medium text-center text-green-600 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 dark:bg-green-900/20 dark:text-green-400">
                        <i class="fas fa-check mr-2"></i>Mark as Done
                    </button>
                    @endif
                    <a href="{{ route('tasks.edit', $task->id) }}" 
                       class="block w-full px-4 py-2 text-sm font-medium text-center text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 dark:bg-blue-900/20 dark:text-blue-400">
                        <i class="fas fa-edit mr-2"></i>Edit Task
                    </a>
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this task?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full px-4 py-2 text-sm font-medium text-center text-red-600 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 dark:bg-red-900/20 dark:text-red-400">
                            <i class="fas fa-trash mr-2"></i>Delete Task
                        </button>
                    </form>
                </div>
            </div>

            <!-- Task History -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6" x-data="{ open: true }">
                <button @click="open = !open" class="w-full flex items-center justify-between text-left mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                        <i class="fas fa-history mr-2 text-blue-600"></i>Task History
                        <span class="ml-3 px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 rounded-full">
                            {{ $task->history->count() }}
                        </span>
                    </h3>
                    <i class="fas fa-chevron-down text-gray-500 dark:text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                </button>
                <div x-show="open" x-collapse class="space-y-4 max-h-96 overflow-y-auto">
                    @forelse($task->history as $historyItem)
                    <div class="flex items-start space-x-3 pb-4 border-b border-gray-200 dark:border-gray-700 last:border-0 last:pb-0">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center"
                             style="background-color: @php
                                $bgColors = [
                                    'created' => 'rgba(59, 130, 246, 0.1)',
                                    'updated' => 'rgba(107, 114, 128, 0.1)',
                                    'status_changed' => 'rgba(168, 85, 247, 0.1)',
                                    'completed' => 'rgba(34, 197, 94, 0.1)',
                                    'uncompleted' => 'rgba(234, 179, 8, 0.1)',
                                    'assigned' => 'rgba(99, 102, 241, 0.1)',
                                    'priority_changed' => 'rgba(249, 115, 22, 0.1)',
                                ];
                                echo $bgColors[$historyItem->type] ?? 'rgba(107, 114, 128, 0.1)';
                             @endphp">
                            @php
                                $icons = [
                                    'created' => 'fa-plus text-blue-600 dark:text-blue-400',
                                    'updated' => 'fa-edit text-gray-600 dark:text-gray-400',
                                    'status_changed' => 'fa-exchange-alt text-purple-600 dark:text-purple-400',
                                    'completed' => 'fa-check-circle text-green-600 dark:text-green-400',
                                    'uncompleted' => 'fa-times-circle text-yellow-600 dark:text-yellow-400',
                                    'assigned' => 'fa-user-plus text-indigo-600 dark:text-indigo-400',
                                    'priority_changed' => 'fa-arrow-up text-orange-600 dark:text-orange-400',
                                ];
                                $icon = $icons[$historyItem->type] ?? 'fa-circle text-gray-400';
                            @endphp
                            <i class="fas {{ $icon }} text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-900 dark:text-white font-medium">
                                {{ $historyItem->description ?? 'Activity recorded' }}
                            </p>
                            <div class="flex items-center space-x-2 mt-1">
                                <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center">
                                    <i class="fas fa-user-circle mr-1"></i>
                                    {{ $historyItem->user->name ?? 'System' }}
                                </span>
                                <span class="text-xs text-gray-400">•</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $historyItem->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <i class="fas fa-history text-3xl mb-2 opacity-50"></i>
                        <p class="text-sm">No history yet</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function toggleComplete(completed) {
        const checkbox = document.getElementById('taskCompleteCheckbox');
        checkbox.disabled = true;
        
        try {
            const response = await fetch('{{ route('tasks.toggle-complete', $task->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ completed: completed })
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Update UI
                const title = checkbox.nextElementSibling;
                if (data.completed) {
                    title.classList.add('line-through', 'text-gray-400');
                    title.classList.remove('text-gray-900', 'dark:text-white');
                } else {
                    title.classList.remove('line-through', 'text-gray-400');
                    title.classList.add('text-gray-900', 'dark:text-white');
                }
                
                // Reload page to show updated history
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            } else {
                alert(data.message || 'Failed to update task status');
                checkbox.checked = !completed;
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while updating the task');
            checkbox.checked = !completed;
        } finally {
            checkbox.disabled = false;
        }
    }
</script>
@endsection
