<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Reminder;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Models\Contact;
use App\Models\VisitReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $now = now();
        $startOfDay = $now->copy()->startOfDay();
        $endOfDay = $now->copy()->endOfDay();
        $startOfWeek = $now->copy()->startOfWeek();
        $endOfWeek = $now->copy()->endOfWeek();

        // Get leads statistics with visibility rules
        $leadsQuery = Lead::query();
        $this->applyLeadVisibility($leadsQuery, $user);
        
        $totalLeads = (clone $leadsQuery)->count();
        $newLeads = (clone $leadsQuery)
            ->whereDate('created_at', '>=', $startOfDay)
            ->whereDate('created_at', '<=', $endOfDay)
            ->count();
        
        // Get "Convert this week" count (leads with convert_this_week status)
        $convertThisWeekCount = (clone $leadsQuery)
            ->whereHas('lead_status', function($q) {
                $q->where('slug', 'convert_this_week');
            })
            ->count();
        
        // Get converted count
        $convertedCount = (clone $leadsQuery)
            ->whereHas('lead_status', function($q) {
                $q->where('slug', 'converted');
            })
            ->count();

        // Get tasks statistics
        $pendingTasks = Task::where('assigned_to', $user->id)
            ->where('status', '!=', 'completed')
            ->count();

        $completedTasks = Task::where('assigned_to', $user->id)
            ->where('status', 'completed')
            ->whereDate('completed_at', '>=', $startOfDay)
            ->count();

        // Get reminders (actual reminder records)
        $reminders = Reminder::where('user_id', $user->id)
            ->where('is_completed', false)
            ->where('reminder_at', '>=', $startOfDay)
            ->where('reminder_at', '<=', $endOfDay->copy()->addDay())
            ->orderBy('reminder_at')
            ->limit(5)
            ->get()
            ->map(function ($reminder) {
                $reminderAt = Carbon::parse($reminder->reminder_at);
                return [
                    'id' => $reminder->id,
                    'title' => $reminder->title,
                    'time' => $reminderAt->format('h:i A'),
                    'date' => $reminderAt->isToday() ? 'Today' : ($reminderAt->isTomorrow() ? 'Tomorrow' : $reminderAt->format('M d')),
                ];
            });

        // Get todos (incomplete tasks assigned to user)
        $todos = Task::where('assigned_to', $user->id)
            ->where('status', '!=', 'completed')
            ->orderBy('due_date')
            ->limit(5)
            ->get()
            ->map(function ($task) {
                return [
                    'id' => $task->id,
                    'title' => $task->title,
                    'completed' => $task->status === 'completed',
                    'due_date' => $task->due_date,
                ];
            });

        // Get leads assigned to current user
        // Apply visibility rules based on user role
        $assignedLeadsQuery = Lead::query();
        $this->applyLeadVisibility($assignedLeadsQuery, $user);
        $assignedLeads = $assignedLeadsQuery
            ->with(['lead_status', 'lead_priority', 'assigned_user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($lead) {
                return [
                    'id' => $lead->id,
                    'name' => $lead->name,
                    'company' => $lead->company ?? null,
                    'status' => $lead->lead_status ? $lead->lead_status->name : ($lead->status ?? 'New'),
                    'date' => $lead->created_at->diffForHumans(),
                    'created_at' => $lead->created_at,
                ];
            });

        // Get pending tasks
        $pendingTasksList = Task::where('assigned_to', $user->id)
            ->where('status', '!=', 'completed')
            ->orderBy('due_date')
            ->limit(5)
            ->get()
            ->map(function ($task) {
                $dueDate = $task->due_date ? Carbon::parse($task->due_date) : null;
                $dueText = 'No due date';
                
                if ($dueDate) {
                    if ($dueDate->isToday()) {
                        $dueText = 'Today';
                    } elseif ($dueDate->isTomorrow()) {
                        $dueText = 'Tomorrow';
                    } elseif ($dueDate->isFuture()) {
                        $dueText = 'In ' . $dueDate->diffInDays(now()) . ' days';
                    } else {
                        $dueText = 'Overdue';
                    }
                }

                return [
                    'id' => $task->id,
                    'title' => $task->title,
                    'priority' => $task->priority ?? 'medium',
                    'due' => $dueText,
                ];
            });

        // Get projects statistics
        $totalProjects = Project::count();
        $activeProjects = Project::where('status', 'in_progress')->count();
        $newProjects = Project::whereDate('created_at', '>=', $startOfDay)
            ->whereDate('created_at', '<=', $endOfDay)
            ->count();

        // Get contacts statistics
        $totalContacts = Contact::count();
        $newContacts = Contact::whereDate('created_at', '>=', $startOfDay)
            ->whereDate('created_at', '<=', $endOfDay)
            ->count();
        $urgentContacts = Contact::where('priority', 'urgent')->count();

        // Get visit reports statistics
        $totalVisitReports = VisitReport::count();
        $recentVisitReports = VisitReport::whereDate('visit_date', '>=', $startOfDay->copy()->subDays(7))
            ->whereDate('visit_date', '<=', $endOfDay)
            ->count();
        $upcomingMeetings = VisitReport::where('next_meeting_date', '>=', $startOfDay)
            ->where('next_meeting_date', '<=', $endOfDay->copy()->addDays(7))
            ->count();

        // Get quote of the day (you can replace this with a database query if you have quotes stored)
        $quotes = [
            [
                'text' => "The journey of a thousand miles begins with a single step.",
                'author' => "Lao Tzu"
            ],
            [
                'text' => "Travel makes one modest. You see what a tiny place you occupy in the world.",
                'author' => "Gustave Flaubert"
            ],
            [
                'text' => "The world is a book, and those who do not travel read only one page.",
                'author' => "Saint Augustine"
            ]
        ];
        $quoteOfTheDay = $quotes[now()->dayOfYear % count($quotes)];

        return view('admin.dashboard', [
            'stats' => [
                'totalLeads' => $totalLeads,
                'pendingTasks' => $pendingTasks,
                'completedTasks' => $completedTasks,
                'newLeads' => $newLeads,
                'convertThisWeek' => $convertThisWeekCount,
                'converted' => $convertedCount,
                'totalProjects' => $totalProjects,
                'activeProjects' => $activeProjects,
                'newProjects' => $newProjects,
                'totalContacts' => $totalContacts,
                'newContacts' => $newContacts,
                'urgentContacts' => $urgentContacts,
                'totalVisitReports' => $totalVisitReports,
                'recentVisitReports' => $recentVisitReports,
                'upcomingMeetings' => $upcomingMeetings,
            ],
            'reminders' => $reminders,
            'todos' => $todos,
            'assignedLeads' => $assignedLeads,
            'pendingTasksList' => $pendingTasksList,
            'quoteOfTheDay' => $quoteOfTheDay
        ]);
    }

    /**
     * Apply lead visibility rules based on user role.
     * 
     * - Super-admin: sees all leads
     * - Manager: sees all leads in their branches + their assigned leads (even in other branches)
     * - Team lead: sees all leads assigned to their team members + their assigned leads
     * - Agent: sees only their assigned leads
     */
    protected function applyLeadVisibility($query, $user)
    {
        // Super-admin sees all leads
        if ($user->hasRole('super-admin')) {
            return;
        }

        // Manager: sees all leads in their branches + their assigned leads
        if ($user->hasRole('manager')) {
            $branchIds = $user->branches()->pluck('branches.id');
            $query->where(function($q) use ($user, $branchIds) {
                // Leads in manager's branches
                if ($branchIds->isNotEmpty()) {
                    $q->whereIn('branch_id', $branchIds);
                }
                // OR leads assigned to the manager (even in other branches)
                $q->orWhere('assigned_user_id', $user->id);
            });
            return;
        }

        // Team lead: sees all leads assigned to their team members + their assigned leads
        if ($user->hasRole('team-lead')) {
            $teamMemberIds = collect();
            // Get all team members from teams where this user is the team lead
            $ledTeams = $user->ledTeams()->with('users')->get();
            foreach ($ledTeams as $team) {
                $teamMemberIds = $teamMemberIds->merge($team->users->pluck('id'));
            }
            // Remove the team lead's own ID from the list (we'll add it separately)
            $teamMemberIds = $teamMemberIds->unique()->filter(function($id) use ($user) {
                return $id != $user->id;
            });

            $query->where(function($q) use ($user, $teamMemberIds) {
                // Leads assigned to team members
                if ($teamMemberIds->isNotEmpty()) {
                    $q->whereIn('assigned_user_id', $teamMemberIds);
                }
                // OR leads assigned to the team lead
                $q->orWhere('assigned_user_id', $user->id);
            });
            return;
        }

        // Agent: sees only their assigned leads
        $query->where('assigned_user_id', $user->id);
    }

}
