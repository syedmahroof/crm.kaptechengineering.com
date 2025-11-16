<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lead;
use App\Models\Project;
use App\Models\VisitReport;
use App\Models\Task;
use App\Models\LeadFollowUp;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StaffPerformanceController extends Controller
{
    /**
     * Display a listing of staff with performance metrics.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $query = User::with(['roles']);

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        // Get date range for performance metrics
        $startDate = $request->filled('start_date') 
            ? Carbon::parse($request->start_date)->startOfDay()
            : now()->subDays(30)->startOfDay();
            
        $endDate = $request->filled('end_date')
            ? Carbon::parse($request->end_date)->endOfDay()
            : now()->endOfDay();

        $users = $query->orderBy('name')->get();

        // Calculate performance metrics for each user
        $usersWithPerformance = $users->map(function ($user) use ($startDate, $endDate) {
            return $this->calculateUserPerformance($user, $startDate, $endDate);
        });

        // Get roles for filter
        $roles = \Spatie\Permission\Models\Role::all()->pluck('name');

        return view('admin.staff-performance.index', [
            'users' => $usersWithPerformance,
            'roles' => $roles,
            'filters' => $request->only(['search', 'role', 'start_date', 'end_date']),
            'startDate' => $startDate->toDateString(),
            'endDate' => $endDate->toDateString(),
        ]);
    }

    /**
     * Display individual staff performance details.
     */
    public function show(User $user, Request $request)
    {
        $this->authorize('view', $user);

        // Get date range
        $startDate = $request->filled('start_date') 
            ? Carbon::parse($request->start_date)->startOfDay()
            : now()->subDays(30)->startOfDay();
            
        $endDate = $request->filled('end_date')
            ? Carbon::parse($request->end_date)->endOfDay()
            : now()->endOfDay();

        $performance = $this->calculateUserPerformance($user, $startDate, $endDate, true);

        // Get detailed statistics
        $detailedStats = $this->getDetailedStats($user, $startDate, $endDate);

        return view('admin.staff-performance.show', [
            'user' => $user,
            'performance' => $performance,
            'detailedStats' => $detailedStats,
            'filters' => [
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
            ],
        ]);
    }

    /**
     * Calculate performance metrics for a user.
     */
    private function calculateUserPerformance(User $user, Carbon $startDate, Carbon $endDate, bool $detailed = false)
    {
        // Leads assigned
        $totalLeads = Lead::where('assigned_user_id', $user->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $convertedLeads = Lead::where('assigned_user_id', $user->id)
            ->whereNotNull('converted_at')
            ->whereBetween('converted_at', [$startDate, $endDate])
            ->count();

        $conversionRate = $totalLeads > 0 ? round(($convertedLeads / $totalLeads) * 100, 2) : 0;

        // Projects
        $totalProjects = Project::where('user_id', $user->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $activeProjects = Project::where('user_id', $user->id)
            ->where('status', 'in_progress')
            ->count();

        // Visit Reports
        $totalVisitReports = VisitReport::where('user_id', $user->id)
            ->whereBetween('visit_date', [$startDate, $endDate])
            ->count();

        // Tasks
        $totalTasks = Task::where('assigned_to', $user->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $completedTasks = Task::where('assigned_to', $user->id)
            ->where('status', 'completed')
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->count();

        $taskCompletionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 2) : 0;

        // Follow-ups
        $totalFollowUps = LeadFollowUp::where('created_by', $user->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $completedFollowUps = LeadFollowUp::where('created_by', $user->id)
            ->where('status', 'completed')
            ->whereBetween('completed_at', [$startDate, $endDate])
            ->count();

        $followUpCompletionRate = $totalFollowUps > 0 ? round(($completedFollowUps / $totalFollowUps) * 100, 2) : 0;

        $performance = [
            'user' => $user,
            'total_leads' => $totalLeads,
            'converted_leads' => $convertedLeads,
            'conversion_rate' => $conversionRate,
            'total_projects' => $totalProjects,
            'active_projects' => $activeProjects,
            'total_visit_reports' => $totalVisitReports,
            'total_tasks' => $totalTasks,
            'completed_tasks' => $completedTasks,
            'task_completion_rate' => $taskCompletionRate,
            'total_follow_ups' => $totalFollowUps,
            'completed_follow_ups' => $completedFollowUps,
            'follow_up_completion_rate' => $followUpCompletionRate,
        ];

        if ($detailed) {
            // Additional detailed metrics
            $performance['leads_by_status'] = Lead::where('assigned_user_id', $user->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->whereNotNull('lead_status_id')
                ->selectRaw('lead_status_id, COUNT(*) as count')
                ->groupBy('lead_status_id')
                ->get()
                ->map(function($item) {
                    $leadStatus = \App\Models\LeadStatus::find($item->lead_status_id);
                    return (object)[
                        'lead_status' => $leadStatus,
                        'count' => $item->count,
                    ];
                });

            $performance['leads_by_source'] = Lead::where('assigned_user_id', $user->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->whereNotNull('lead_source_id')
                ->selectRaw('lead_source_id, COUNT(*) as count')
                ->groupBy('lead_source_id')
                ->get()
                ->map(function($item) {
                    $leadSource = \App\Models\LeadSource::find($item->lead_source_id);
                    return (object)[
                        'lead_source' => $leadSource,
                        'count' => $item->count,
                    ];
                });

            $performance['monthly_leads'] = Lead::where('assigned_user_id', $user->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->map(function($item) {
                    return [
                        'month' => Carbon::parse($item->month . '-01')->format('M Y'),
                        'count' => $item->count,
                    ];
                });

            $performance['monthly_visit_reports'] = VisitReport::where('user_id', $user->id)
                ->whereBetween('visit_date', [$startDate, $endDate])
                ->selectRaw('DATE_FORMAT(visit_date, "%Y-%m") as month, COUNT(*) as count')
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->map(function($item) {
                    return [
                        'month' => Carbon::parse($item->month . '-01')->format('M Y'),
                        'count' => $item->count,
                    ];
                });
        }

        return $performance;
    }

    /**
     * Get detailed statistics for a user.
     */
    private function getDetailedStats(User $user, Carbon $startDate, Carbon $endDate)
    {
        return [
            'recent_leads' => Lead::where('assigned_user_id', $user->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->with(['lead_status', 'lead_source'])
                ->latest()
                ->limit(10)
                ->get(),

            'recent_projects' => Project::where('user_id', $user->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->with(['visitReports'])
                ->latest()
                ->limit(10)
                ->get(),

            'recent_visit_reports' => VisitReport::where('user_id', $user->id)
                ->whereBetween('visit_date', [$startDate, $endDate])
                ->with(['project'])
                ->latest('visit_date')
                ->limit(10)
                ->get(),

            'upcoming_follow_ups' => LeadFollowUp::where('created_by', $user->id)
                ->where('status', 'scheduled')
                ->where('scheduled_at', '>=', now())
                ->where('scheduled_at', '<=', now()->addDays(7))
                ->with(['lead'])
                ->orderBy('scheduled_at')
                ->limit(10)
                ->get(),

            'pending_tasks' => Task::where('assigned_to', $user->id)
                ->where('status', '!=', 'completed')
                ->with(['project'])
                ->orderBy('due_date')
                ->limit(10)
                ->get(),
        ];
    }
}

