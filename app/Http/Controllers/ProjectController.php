<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Project::with(['user'])->withCount(['contacts', 'visitReports'])->orderBy('created_at', 'desc');
        
        // Get total project count and counts by type
        $totalProjects = Project::count();
        
        // Get project type counts from database
        $dbProjectTypeCounts = Project::selectRaw('project_type, COUNT(*) as count')
            ->whereNotNull('project_type')
            ->groupBy('project_type')
            ->pluck('count', 'project_type')
            ->toArray();
        
        // Get all project types from database and merge with counts
        $allProjectTypes = \App\Models\ProjectType::active()->ordered()->get();
        $projectTypeCounts = [];
        foreach ($allProjectTypes as $type) {
            $projectTypeCounts[$type->name] = [
                'count' => $dbProjectTypeCounts[$type->name] ?? 0,
                'type' => $type,
            ];
        }

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('project_type')) {
            $query->where('project_type', $request->project_type);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by location through contacts
        if ($request->filled('country_id')) {
            $query->whereHas('contacts', function($q) use ($request) {
                $q->where('country_id', $request->country_id);
            });
        }

        if ($request->filled('state_id')) {
            $query->whereHas('contacts', function($q) use ($request) {
                $q->where('state_id', $request->state_id);
            });
        }

        if ($request->filled('district_id')) {
            $query->whereHas('contacts', function($q) use ($request) {
                $q->where('district_id', $request->district_id);
            });
        }

        $projects = $query->paginate(15);

        $users = \App\Models\User::orderBy('name')->get();
        $projectTypes = \App\Models\ProjectType::active()->ordered()->get()->pluck('name', 'name')->toArray();
        $countries = \App\Models\Country::active()->ordered()->get();
        $states = collect();
        $districts = collect();
        
        // Load states if country is selected
        if ($request->filled('country_id')) {
            $states = \App\Models\State::where('country_id', $request->country_id)->active()->ordered()->get();
        }
        
        // Load districts if state is selected
        if ($request->filled('state_id')) {
            $districts = \App\Models\District::where('state_id', $request->state_id)->active()->ordered()->get();
        }

        return view('admin.projects.index', [
            'projects' => $projects,
            'users' => $users,
            'totalProjects' => $totalProjects,
            'projectTypeCounts' => $projectTypeCounts,
            'projectTypes' => $projectTypes,
            'countries' => $countries,
            'states' => $states,
            'districts' => $districts,
            'filters' => $request->only(['search', 'status', 'project_type', 'user_id', 'country_id', 'state_id', 'district_id']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = \App\Models\User::orderBy('name')->get();
        $india = \App\Models\Country::where('iso_code', 'IN')->first();
        $projectTypes = \App\Models\ProjectType::active()->ordered()->get();
        $branches = \App\Models\Branch::active()->get();

        $states = \App\Models\State::where('country_id', $india?->id)->active()->ordered()->get();

        return view('admin.projects.create', [
            'users' => $users,
            'india' => $india,
            'projectTypes' => $projectTypes,
            'states' => $states,
            'branches' => $branches,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'owner_name' => 'nullable|string|max:255',
            'owner_phone' => 'nullable|string|max:20',
            'owner_email' => 'nullable|email|max:255',
            'contacts' => 'nullable|array',
            'contacts.*.name' => 'required|string|max:255',
            'contacts.*.role' => 'nullable|string|max:50',
            'contacts.*.phone' => 'nullable|string|max:20',
            'contacts.*.email' => 'nullable|email|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'state_id' => 'nullable|exists:states,id',
            'district_id' => 'nullable|exists:districts,id',
            'location' => 'nullable|string',
            'pincode' => 'nullable|string',
            'expected_maturity_date' => 'nullable|date',
            'user_id' => 'nullable|exists:users,id',
            'status' => 'nullable|in:planning,in_progress,on_hold,completed,cancelled',
            'project_type' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'branch_id' => 'nullable|exists:branches,id',
            'preferred_material' => 'nullable|string',
        ]);

        $projectData = \Illuminate\Support\Arr::except($validated, ['owner_phone', 'owner_email', 'contacts']);
        $project = Project::create($projectData);

        // Handle Owner Contact
        if ($request->filled('owner_name') || $request->filled('owner_phone') || $request->filled('owner_email')) {
            $project->projectContacts()->create([
                'name' => $request->owner_name ?? 'Owner',
                'role' => 'owner',
                'phone' => $request->owner_phone,
                'email' => $request->owner_email,
                'is_primary' => true,
            ]);
        }

        // Handle Team Contacts
        if ($request->has('contacts') && is_array($request->contacts)) {
            foreach ($request->contacts as $contact) {
                if (!empty($contact['name'])) {
                    $project->projectContacts()->create([
                        'name' => $contact['name'],
                        'role' => $contact['role'] ?? 'other',
                        'phone' => $contact['phone'] ?? null,
                        'email' => $contact['email'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('projects.index')
                        ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load([
            'user',
            'contacts',
            'visitReports.user',
            'projectContacts' => fn ($query) => $query->orderByDesc('is_primary')->orderBy('role')->orderBy('name'),
        ]);
        
        // Get latest visit report for next meeting/call dates
        $latestVisitReport = $project->visitReports()->latest('visit_date')->first();
        
        return view('admin.projects.show', [
            'project' => $project,
            'latestVisitReport' => $latestVisitReport,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $users = \App\Models\User::orderBy('name')->get();
        $projectTypes = \App\Models\ProjectType::active()->ordered()->get();

        $states = \App\Models\State::where('country_id', 1)->active()->ordered()->get(); // Assuming India (1) for now or load based on dependency
        // Better: Load all active states or based on project's country if we had it. For now, let's load active states.
        $states = \App\Models\State::active()->ordered()->get();
        // Even better, reuse the logic from contact controller? 
        // Let's just load all active states to be safe, or just Indian states if that's the primary use case. 
        // Given '$india' usage in create, let's fetch India's ID or just all.
        // Let's go with all active states to be safe.
        $states = \App\Models\State::active()->ordered()->get();
        $districts = $project->state_id ? \App\Models\District::where('state_id', $project->state_id)->active()->ordered()->get() : collect();
        $branches = \App\Models\Branch::active()->get();

        return view('admin.projects.edit', [
            'project' => $project,
            'users' => $users,
            'projectTypes' => $projectTypes,
            'states' => $states,
            'districts' => $districts,
            'branches' => $branches,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'owner_name' => 'nullable|string|max:255',
            'owner_phone' => 'nullable|string|max:20',
            'owner_email' => 'nullable|email|max:255',
            'contacts' => 'nullable|array',
            'contacts.*.name' => 'required|string|max:255',
            'contacts.*.role' => 'nullable|string|max:50',
            'contacts.*.phone' => 'nullable|string|max:20',
            'contacts.*.email' => 'nullable|email|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'state_id' => 'nullable|exists:states,id',
            'district_id' => 'nullable|exists:districts,id',
            'location' => 'nullable|string',
            'pincode' => 'nullable|string',
            'expected_maturity_date' => 'nullable|date',
            'user_id' => 'nullable|exists:users,id',
            'status' => 'nullable|in:planning,in_progress,on_hold,completed,cancelled',
            'project_type' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'branch_id' => 'nullable|exists:branches,id',
        ]);

        $projectData = \Illuminate\Support\Arr::except($validated, ['owner_phone', 'owner_email', 'contacts']);
        $project->update($projectData);

        // Update Owner Contact
        if ($request->filled('owner_name') || $request->filled('owner_phone') || $request->filled('owner_email')) {
            $ownerContact = $project->projectContacts()->where('role', 'owner')->first();
            if ($ownerContact) {
                $ownerContact->update([
                    'name' => $request->owner_name ?? $ownerContact->name, // Keep existing name if not cleared? Or allow clearing? User request implies fields are present.
                    'phone' => $request->owner_phone,
                    'email' => $request->owner_email,
                ]);
            } else {
                $project->projectContacts()->create([
                    'name' => $request->owner_name ?? 'Owner',
                    'role' => 'owner',
                    'phone' => $request->owner_phone,
                    'email' => $request->owner_email,
                    'is_primary' => true,
                ]);
            }
        }

        // Sync Team Contacts (non-owner)
        // Simplest approach: Delete all non-owner/non-primary contacts and recreate? 
        // Or better: keep existing IDs if we were passing them. Since we are using a simple repeater without IDs in create/edit for now, 
        // and 'show' page handles management better, maybe we only ADD new ones here or replace list.
        // User asked to "add multiple team contacts". 
        // Let's implement a "Replace All Non-Owner Contacts" strategy for the Edit page input if provided, 
        // OR just append. 
        // Given the request "also when create and edit project need to add multiple team contacts", 
        // usually implies a full management capability. 
        // I will clear non-owner contacts and recreate from the list if 'contacts' is present in request.
        // This assumes the Edit form sends ALL contacts.
        
        if ($request->has('contacts')) {
            // Remove existing non-owner contacts
            $project->projectContacts()->where('role', '!=', 'owner')->delete();
            
            if (is_array($request->contacts)) {
                foreach ($request->contacts as $contact) {
                    if (!empty($contact['name'])) {
                        $project->projectContacts()->create([
                            'name' => $contact['name'],
                            'role' => $contact['role'] ?? 'other',
                            'phone' => $contact['phone'] ?? null,
                            'email' => $contact['email'] ?? null,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('projects.index')
                        ->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')
                        ->with('success', 'Project deleted successfully.');
    }

    /**
     * Export projects to CSV/Excel
     */
    public function export(Request $request)
    {
        $query = Project::with(['user'])->withCount(['contacts', 'visitReports', 'projectContacts']);

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('project_type')) {
            $query->where('project_type', $request->project_type);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by location through contacts
        if ($request->filled('country_id')) {
            $query->whereHas('contacts', function($q) use ($request) {
                $q->where('country_id', $request->country_id);
            });
        }

        if ($request->filled('state_id')) {
            $query->whereHas('contacts', function($q) use ($request) {
                $q->where('state_id', $request->state_id);
            });
        }

        if ($request->filled('district_id')) {
            $query->whereHas('contacts', function($q) use ($request) {
                $q->where('district_id', $request->district_id);
            });
        }

        $projects = $query->orderBy('created_at', 'desc')->get();
        $projectTypes = Project::getProjectTypes();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="projects_' . now()->format('Y-m-d') . '.csv"',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Pragma' => 'public',
        ];

        $callback = function() use ($projects, $projectTypes) {
            $file = fopen('php://output', 'w');
            // Write UTF-8 BOM for Excel compatibility
            fwrite($file, "\xEF\xBB\xBF");

            // CSV headers
            fputcsv($file, [
                'ID',
                'Name',
                'Description',
                'Project Type',
                'Status',
                'Owner',
                'Start Date',
                'End Date',
                'Contacts Count',
                'Visit Reports Count',
                'Team Contacts Count',
                'Created At',
                'Updated At'
            ]);

            // CSV data
            foreach ($projects as $project) {
                fputcsv($file, [
                    $project->id,
                    $project->name,
                    $project->description ?? '',
                    $project->project_type ? ($projectTypes[$project->project_type] ?? $project->project_type) : '',
                    ucfirst(str_replace('_', ' ', $project->status ?? '')),
                    $project->user->name ?? '',
                    $project->start_date?->format('Y-m-d'),
                    $project->end_date?->format('Y-m-d'),
                    $project->contacts_count ?? 0,
                    $project->visit_reports_count ?? 0,
                    $project->project_contacts_count ?? 0,
                    $project->created_at->format('Y-m-d H:i:s'),
                    $project->updated_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

