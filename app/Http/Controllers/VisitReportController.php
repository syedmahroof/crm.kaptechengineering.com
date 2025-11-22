<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Customer;
use App\Models\Contact;
use App\Models\VisitReport;
use Illuminate\Http\Request;

class VisitReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = VisitReport::with(['projects', 'customers', 'contacts', 'user'])->orderBy('visit_date', 'desc');

        // Filter by project if provided
        if ($request->filled('project_id')) {
            $query->forProject($request->project_id);
        }

        // Filter by customer if provided
        if ($request->filled('customer_id')) {
            $query->forCustomer($request->customer_id);
        }

        // Filter by contact if provided
        if ($request->filled('contact_id')) {
            $query->forContact($request->contact_id);
        }

        $visitReports = $query->paginate(15);
        $projects = Project::orderBy('name')->get();
        $customers = Customer::orderBy('first_name')->orderBy('last_name')->get();
        $contacts = Contact::orderBy('name')->get();

        return view('admin.visit-reports.index', [
            'visitReports' => $visitReports,
            'projects' => $projects,
            'customers' => $customers,
            'contacts' => $contacts,
            'filters' => $request->only(['project_id', 'customer_id', 'contact_id']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $project = null;
        $customer = null;
        $contact = null;

        if ($request->filled('project_id')) {
            $project = Project::findOrFail($request->project_id);
        }
        if ($request->filled('customer_id')) {
            $customer = Customer::findOrFail($request->customer_id);
        }
        if ($request->filled('contact_id')) {
            $contact = Contact::findOrFail($request->contact_id);
        }

        $projects = Project::orderBy('name')->get();
        $customers = Customer::orderBy('first_name')->orderBy('last_name')->get();
        $contacts = Contact::orderBy('name')->get();

        return view('admin.visit-reports.create', [
            'projects' => $projects,
            'customers' => $customers,
            'contacts' => $contacts,
            'project' => $project,
            'customer' => $customer,
            'contact' => $contact,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'visit_date' => 'required|date',
            'objective' => 'required|string',
            'report' => 'nullable|string',
            'next_meeting_date' => 'nullable|date',
            'next_call_date' => 'nullable|date',
            'project_ids' => 'nullable|array',
            'project_ids.*' => 'exists:projects,id',
            'customer_ids' => 'nullable|array',
            'customer_ids.*' => 'exists:customers,id',
            'contact_ids' => 'nullable|array',
            'contact_ids.*' => 'exists:contacts,id',
        ]);

        // Ensure at least one entity is selected
        if (empty($validated['project_ids']) && empty($validated['customer_ids']) && empty($validated['contact_ids'])) {
            return back()->withErrors(['entity' => 'Please select at least one project, customer, or contact.'])->withInput();
        }

        $validated['user_id'] = auth()->id();

        // Extract entity IDs
        $projectIds = $validated['project_ids'] ?? [];
        $customerIds = $validated['customer_ids'] ?? [];
        $contactIds = $validated['contact_ids'] ?? [];

        // Remove from validated array
        unset($validated['project_ids'], $validated['customer_ids'], $validated['contact_ids']);

        $visitReport = VisitReport::create($validated);

        // Attach projects
        if (!empty($projectIds)) {
            $visitReport->projects()->attach($projectIds);
        }

        // Attach customers
        if (!empty($customerIds)) {
            $visitReport->customers()->attach($customerIds);
        }

        // Attach contacts
        if (!empty($contactIds)) {
            $visitReport->contacts()->attach($contactIds);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Visit report created successfully.',
                'visitReport' => $visitReport->load(['projects', 'customers', 'contacts', 'user']),
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
        $visitReport->load(['projects', 'customers', 'contacts', 'user']);

        return view('admin.visit-reports.show', [
            'visitReport' => $visitReport,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VisitReport $visitReport)
    {
        $visitReport->load(['projects', 'customers', 'contacts']);
        $projects = Project::orderBy('name')->get();
        $customers = Customer::orderBy('first_name')->orderBy('last_name')->get();
        $contacts = Contact::orderBy('name')->get();

        return view('admin.visit-reports.edit', [
            'visitReport' => $visitReport,
            'projects' => $projects,
            'customers' => $customers,
            'contacts' => $contacts,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VisitReport $visitReport)
    {
        $validated = $request->validate([
            'visit_date' => 'required|date',
            'objective' => 'required|string',
            'report' => 'nullable|string',
            'next_meeting_date' => 'nullable|date',
            'next_call_date' => 'nullable|date',
            'project_ids' => 'nullable|array',
            'project_ids.*' => 'exists:projects,id',
            'customer_ids' => 'nullable|array',
            'customer_ids.*' => 'exists:customers,id',
            'contact_ids' => 'nullable|array',
            'contact_ids.*' => 'exists:contacts,id',
        ]);

        // Ensure at least one entity is selected
        if (empty($validated['project_ids']) && empty($validated['customer_ids']) && empty($validated['contact_ids'])) {
            return back()->withErrors(['entity' => 'Please select at least one project, customer, or contact.'])->withInput();
        }

        // Extract entity IDs
        $projectIds = $validated['project_ids'] ?? [];
        $customerIds = $validated['customer_ids'] ?? [];
        $contactIds = $validated['contact_ids'] ?? [];

        // Remove from validated array
        unset($validated['project_ids'], $validated['customer_ids'], $validated['contact_ids']);

        $visitReport->update($validated);

        // Sync relationships
        $visitReport->projects()->sync($projectIds);
        $visitReport->customers()->sync($customerIds);
        $visitReport->contacts()->sync($contactIds);

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
        $totalProjects = \DB::table('visit_reportables')
            ->where('visit_reportable_type', 'App\Models\Project')
            ->distinct('visit_reportable_id')
            ->count('visit_reportable_id');
        $totalUsers = (clone $baseQuery)->distinct('user_id')->count('user_id');
        $avgVisitsPerProject = $totalProjects > 0 ? round($totalVisits / $totalProjects, 2) : 0;

        // Visits by project
        $visitsByProject = \DB::table('visit_reportables')
            ->join('visit_reports', 'visit_reportables.visit_report_id', '=', 'visit_reports.id')
            ->where('visit_reportables.visit_reportable_type', 'App\Models\Project')
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('visit_reports.visit_date', [$startDate, $endDate]);
            })
            ->select('visit_reportables.visit_reportable_id as project_id', \DB::raw('COUNT(*) as visit_count'))
            ->groupBy('visit_reportables.visit_reportable_id')
            ->orderByDesc('visit_count')
            ->limit(10)
            ->get()
            ->map(function($item) {
                $project = Project::find($item->project_id);
                return (object)[
                    'project_id' => $item->project_id,
                    'visit_count' => $item->visit_count,
                    'project' => $project,
                ];
            });

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
        $visitsByProjectType = \DB::table('visit_reportables')
            ->join('visit_reports', 'visit_reportables.visit_report_id', '=', 'visit_reports.id')
            ->join('projects', 'visit_reportables.visit_reportable_id', '=', 'projects.id')
            ->where('visit_reportables.visit_reportable_type', 'App\Models\Project')
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('visit_reports.visit_date', [$startDate, $endDate]);
            })
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
            ->with(['projects', 'customers', 'contacts', 'user'])
            ->orderBy('next_meeting_date')
            ->limit(10)
            ->get();

        $upcomingCalls = VisitReport::where('next_call_date', '>=', now())
            ->where('next_call_date', '<=', now()->addDays(30))
            ->with(['projects', 'customers', 'contacts', 'user'])
            ->orderBy('next_call_date')
            ->limit(10)
            ->get();

        // Recent visits
        $recentVisits = (clone $baseQuery)
            ->with(['projects', 'customers', 'contacts', 'user'])
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
