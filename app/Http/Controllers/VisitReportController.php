<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\VisitReport;
use Illuminate\Http\Request;

class VisitReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = VisitReport::with(['project', 'user'])->orderBy('visit_date', 'desc');

        // Filter by project if provided
        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        $visitReports = $query->paginate(15);
        $projects = Project::orderBy('name')->get();

        return view('admin.visit-reports.index', [
            'visitReports' => $visitReports,
            'projects' => $projects,
            'filters' => $request->only(['project_id']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $project = null;
        if ($request->filled('project_id')) {
            $project = Project::findOrFail($request->project_id);
        }

        $projects = Project::orderBy('name')->get();

        return view('admin.visit-reports.create', [
            'projects' => $projects,
            'project' => $project,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'visit_date' => 'required|date',
            'objective' => 'required|string',
            'report' => 'nullable|string',
            'next_meeting_date' => 'nullable|date',
            'next_call_date' => 'nullable|date',
        ]);

        $validated['user_id'] = auth()->id();

        $visitReport = VisitReport::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Visit report created successfully.',
                'visitReport' => $visitReport->load(['project', 'user']),
            ]);
        }

        // Redirect to project page if redirect_to is provided
        if ($request->filled('redirect_to')) {
            return redirect($request->redirect_to)
                        ->with('success', 'Visit report created successfully.');
        }

        return redirect()->route('visit-reports.index')
                        ->with('success', 'Visit report created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(VisitReport $visitReport)
    {
        $visitReport->load(['project', 'user']);

        return view('admin.visit-reports.show', [
            'visitReport' => $visitReport,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VisitReport $visitReport)
    {
        $projects = Project::orderBy('name')->get();

        return view('admin.visit-reports.edit', [
            'visitReport' => $visitReport,
            'projects' => $projects,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VisitReport $visitReport)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'visit_date' => 'required|date',
            'objective' => 'required|string',
            'report' => 'nullable|string',
            'next_meeting_date' => 'nullable|date',
            'next_call_date' => 'nullable|date',
        ]);

        $visitReport->update($validated);

        return redirect()->route('visit-reports.index')
                        ->with('success', 'Visit report updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VisitReport $visitReport)
    {
        $visitReport->delete();

        return redirect()->route('visit-reports.index')
                        ->with('success', 'Visit report deleted successfully.');
    }

    /**
     * Show visit reports analytics dashboard.
     */
    public function analytics(Request $request)
    {
        // Get date range from request or use default (last 365 days)
        $endDate = $request->filled('end_date') 
            ? \Carbon\Carbon::parse($request->end_date)->endOfDay()
            : now();
            
        $startDate = $request->filled('start_date')
            ? \Carbon\Carbon::parse($request->start_date)->startOfDay()
            : $endDate->copy()->subYear();

        $baseQuery = VisitReport::query()
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('visit_date', [$startDate, $endDate]);
            });

        // Overall statistics
        $totalVisits = (clone $baseQuery)->count();
        $totalProjects = (clone $baseQuery)->distinct('project_id')->count('project_id');
        $totalUsers = (clone $baseQuery)->distinct('user_id')->count('user_id');
        $avgVisitsPerProject = $totalProjects > 0 ? round($totalVisits / $totalProjects, 2) : 0;

        // Visits by project
        $visitsByProject = (clone $baseQuery)
            ->select('project_id', \DB::raw('COUNT(*) as visit_count'))
            ->with('project')
            ->groupBy('project_id')
            ->orderByDesc('visit_count')
            ->limit(10)
            ->get();

        // Visits by user
        $visitsByUser = (clone $baseQuery)
            ->select('user_id', \DB::raw('COUNT(*) as visit_count'))
            ->with('user')
            ->groupBy('user_id')
            ->orderByDesc('visit_count')
            ->limit(10)
            ->get();

        // Monthly trends
        $monthlyTrends = (clone $baseQuery)
            ->select(\DB::raw('DATE_FORMAT(visit_date, "%Y-%m") as month'), \DB::raw('COUNT(*) as count'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function($item) {
                return [
                    'month' => \Carbon\Carbon::parse($item->month . '-01')->format('M Y'),
                    'count' => $item->count,
                ];
            });

        // Weekly trends
        $weeklyTrends = (clone $baseQuery)
            ->select(\DB::raw('YEARWEEK(visit_date) as week'), \DB::raw('COUNT(*) as count'))
            ->groupBy('week')
            ->orderBy('week')
            ->get()
            ->map(function($item) {
                $year = substr($item->week, 0, 4);
                $week = substr($item->week, 4);
                $date = \Carbon\Carbon::now()->setISODate($year, $week);
                return [
                    'week' => 'Week ' . $week . ' ' . $year,
                    'count' => $item->count,
                ];
            });

        // Visits by project type
        $visitsByProjectType = (clone $baseQuery)
            ->join('projects', 'visit_reports.project_id', '=', 'projects.id')
            ->select('projects.project_type', \DB::raw('COUNT(*) as visit_count'))
            ->whereNotNull('projects.project_type')
            ->groupBy('projects.project_type')
            ->orderByDesc('visit_count')
            ->get()
            ->map(function($item) {
                return [
                    'type' => \App\Models\Project::getProjectTypes()[$item->project_type] ?? $item->project_type,
                    'count' => $item->visit_count,
                ];
            });

        // Upcoming meetings and calls
        $upcomingMeetings = VisitReport::where('next_meeting_date', '>=', now())
            ->where('next_meeting_date', '<=', now()->addDays(30))
            ->with(['project', 'user'])
            ->orderBy('next_meeting_date')
            ->limit(10)
            ->get();

        $upcomingCalls = VisitReport::where('next_call_date', '>=', now())
            ->where('next_call_date', '<=', now()->addDays(30))
            ->with(['project', 'user'])
            ->orderBy('next_call_date')
            ->limit(10)
            ->get();

        // Recent visits
        $recentVisits = (clone $baseQuery)
            ->with(['project', 'user'])
            ->orderByDesc('visit_date')
            ->limit(10)
            ->get();

        $stats = [
            'total_visits' => $totalVisits,
            'total_projects' => $totalProjects,
            'total_users' => $totalUsers,
            'avg_visits_per_project' => $avgVisitsPerProject,
            'visits_by_project' => $visitsByProject,
            'visits_by_user' => $visitsByUser,
            'monthly_trends' => $monthlyTrends,
            'weekly_trends' => $weeklyTrends,
            'visits_by_project_type' => $visitsByProjectType,
            'upcoming_meetings' => $upcomingMeetings,
            'upcoming_calls' => $upcomingCalls,
            'recent_visits' => $recentVisits,
            'date_range' => [
                'start' => $startDate->toDateString(),
                'end' => $endDate->toDateString(),
            ],
        ];

        return view('admin.visit-reports.analytics', [
            'stats' => $stats,
            'filters' => [
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
            ],
        ]);
    }
}
