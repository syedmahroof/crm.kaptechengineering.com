<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Contact::with(['repliedBy', 'project', 'country', 'state', 'district']);

        // Apply filters
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        if ($request->filled('contact_type')) {
            $query->where('contact_type', $request->contact_type);
        }

        if ($request->filled('country_id')) {
            $query->where('country_id', $request->country_id);
        }

        if ($request->filled('state_id')) {
            $query->where('state_id', $request->state_id);
        }

        if ($request->filled('district_id')) {
            $query->where('district_id', $request->district_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $contacts = $query->paginate(15);

        // Statistics - apply same filters (except search for performance)
        $statsQuery = Contact::query();
        
        if ($request->filled('priority')) {
            $statsQuery->where('priority', $request->priority);
        }
        
        if ($request->filled('project_id')) {
            $statsQuery->where('project_id', $request->project_id);
        }
        
        if ($request->filled('contact_type')) {
            $statsQuery->where('contact_type', $request->contact_type);
        }
        
        if ($request->filled('country_id')) {
            $statsQuery->where('country_id', $request->country_id);
        }
        
        if ($request->filled('state_id')) {
            $statsQuery->where('state_id', $request->state_id);
        }
        
        if ($request->filled('district_id')) {
            $statsQuery->where('district_id', $request->district_id);
        }
        
        // Apply search filter to stats as well
        if ($request->filled('search')) {
            $search = $request->search;
            $statsQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Get projects by type statistics
        $projectsByType = \App\Models\Project::query()
            ->selectRaw('project_type, COUNT(*) as count')
            ->whereNotNull('project_type')
            ->groupBy('project_type')
            ->orderByDesc('count')
            ->pluck('count', 'project_type')
            ->toArray();

        // First get all active contact type slugs
        $activeContactTypeSlugs = \App\Models\ContactType::active()
            ->pluck('slug')
            ->toArray();
            
        $stats = [
            'total' => $statsQuery->count(),
            'by_type' => (clone $statsQuery)
                ->selectRaw('contact_type, COUNT(*) as count')
                ->whereNotNull('contact_type')
                ->whereIn('contact_type', $activeContactTypeSlugs)
                ->groupBy('contact_type')
                ->pluck('count', 'contact_type')
                ->toArray(),
            'projects_by_type' => $projectsByType,
        ];

        $projects = \App\Models\Project::orderBy('name')->get();
        $contactTypes = \App\Models\ContactType::active()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->pluck('name', 'slug')
            ->toArray();
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

        $projectTypes = \App\Models\Project::getProjectTypes();
        
        // Get user preferences for dashboard cards visibility
        $userPreferences = auth()->user()->preferences ?? [];
        $showProjectsByType = $userPreferences['show_projects_by_type_card'] ?? true;

        return view('admin.contacts.index', [
            'contacts' => $contacts,
            'stats' => $stats,
            'projects' => $projects,
            'projectTypes' => $projectTypes,
            'contactTypes' => $contactTypes,
            'countries' => $countries,
            'states' => $states,
            'districts' => $districts,
            'filters' => $request->only(['priority', 'search', 'project_id', 'contact_type', 'country_id', 'state_id', 'district_id', 'sort_by', 'sort_direction']),
            'showProjectsByType' => $showProjectsByType,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = \App\Models\Project::orderBy('name')->get();
        $contactTypes = \App\Models\ContactType::active()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->pluck('name', 'slug')
            ->toArray();
        $countries = \App\Models\Country::active()->ordered()->get();
        $india = \App\Models\Country::where('iso_code', 'IN')->first();
        $states = collect();
        $districts = collect();
        $branches = \App\Models\Branch::active()->get();
        
        // If India exists, load its states
        if ($india) {
            $states = \App\Models\State::where('country_id', $india->id)->active()->ordered()->get();
        }
        
        return view('admin.contacts.create', [
            'projects' => $projects,
            'contactTypes' => $contactTypes,
            'countries' => $countries,
            'india' => $india,
            'states' => $states,
            'districts' => $districts,
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
            'company_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'contact_type' => 'nullable|string',
            'country_id' => 'nullable|exists:countries,id',
            'state_id' => 'nullable|exists:states,id',
            'district_id' => 'nullable|exists:districts,id',
            'address' => 'nullable|string',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'nullable|in:low,medium,high,urgent',
            'priority' => 'nullable|in:low,medium,high,urgent',
            'project_id' => 'nullable|exists:projects,id',
            'branch_id' => 'nullable|exists:branches,id',
        ]);

        Contact::create($validated);

        return redirect()->route('admin.contacts.index')
                        ->with('success', 'Contact created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        $contact->load(['repliedBy', 'project', 'country', 'state', 'district']);

        // Find projects where this contact appears as a project contact (matching by name, email, or phone)
        $projectContacts = \App\Models\ProjectContact::where(function($query) use ($contact) {
            if ($contact->name) {
                $query->where('name', 'like', '%' . $contact->name . '%');
            }
            if ($contact->email) {
                $query->orWhere('email', $contact->email);
            }
            if ($contact->phone) {
                $query->orWhere('phone', $contact->phone);
            }
        })->with('project')->get();

        $relatedProjects = $projectContacts->pluck('project')->filter()->unique('id');

        return view('admin.contacts.show', [
            'contact' => $contact,
            'relatedProjects' => $relatedProjects,
            'projectContacts' => $projectContacts,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        $contact->load('repliedBy');
        $projects = \App\Models\Project::orderBy('name')->get();
        $contactTypes = \App\Models\ContactType::active()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->pluck('name', 'slug')
            ->toArray();
        $branches = \App\Models\Branch::active()->get();
        $countries = \App\Models\Country::active()->ordered()->get();
        $states = collect();
        $districts = collect();
        
        if ($contact->country_id) {
            $states = \App\Models\State::where('country_id', $contact->country_id)->active()->ordered()->get();
        }
        
        if ($contact->state_id) {
            $districts = \App\Models\District::where('state_id', $contact->state_id)->active()->ordered()->get();
        }

        return view('admin.contacts.edit', [
            'contact' => $contact,
            'projects' => $projects,
            'contactTypes' => $contactTypes,
            'countries' => $countries,
            'states' => $states,
            'states' => $states,
            'districts' => $districts,
            'branches' => $branches,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'company_name' => 'nullable|string|max:255',
            'priority' => 'required|in:low,medium,high,urgent',
            'admin_notes' => 'nullable|string',
            'project_id' => 'nullable|exists:projects,id',
            'contact_type' => 'nullable|string',
            'country_id' => 'nullable|exists:countries,id',
            'state_id' => 'nullable|exists:states,id',
            'country_id' => 'nullable|exists:countries,id',
            'state_id' => 'nullable|exists:states,id',
            'district_id' => 'nullable|exists:districts,id',
            'branch_id' => 'nullable|exists:branches,id',
        ]);

        $data = $request->only(['company_name', 'priority', 'admin_notes', 'project_id', 'contact_type', 'country_id', 'state_id', 'district_id', 'branch_id']);

        $contact->update($data);

        return redirect()->route('admin.contacts.show', $contact)
                        ->with('success', 'Contact updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')
                        ->with('success', 'Contact deleted successfully.');
    }


    /**
     * Update contact priority.
     */
    public function updatePriority(Request $request, Contact $contact)
    {
        $request->validate([
            'priority' => 'required|in:low,medium,high,urgent',
        ]);

        $contact->update(['priority' => $request->priority]);

        return response()->json([
            'success' => true,
            'priority' => $contact->priority,
        ]);
    }

    /**
     * Bulk update contacts.
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'contact_ids' => 'required|array',
            'contact_ids.*' => 'exists:contacts,id',
            'action' => 'required|in:delete',
        ]);

        $contacts = Contact::whereIn('id', $request->contact_ids);

        switch ($request->action) {
            case 'delete':
                $contacts->delete();
                break;
        }

        return response()->json([
            'success' => true,
            'message' => 'Contacts updated successfully.',
        ]);
    }

    /**
     * Export contacts to CSV/Excel
     */
    public function export(Request $request)
    {
        $query = Contact::with(['repliedBy', 'project', 'country', 'state', 'district']);

        // Apply same filters as index
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }
        if ($request->filled('contact_type')) {
            $query->where('contact_type', $request->contact_type);
        }
        if ($request->filled('country_id')) {
            $query->where('country_id', $request->country_id);
        }
        if ($request->filled('state_id')) {
            $query->where('state_id', $request->state_id);
        }
        if ($request->filled('district_id')) {
            $query->where('district_id', $request->district_id);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $contacts = $query->orderBy('created_at', 'desc')->get();
        $contactTypes = \App\Models\ContactType::active()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->pluck('name', 'slug')
            ->toArray();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="contacts_' . now()->format('Y-m-d') . '.csv"',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Pragma' => 'public',
        ];

        $callback = function() use ($contacts, $contactTypes) {
            $file = fopen('php://output', 'w');
            // Write UTF-8 BOM for Excel compatibility
            fwrite($file, "\xEF\xBB\xBF");

            // CSV headers
            fputcsv($file, [
                'ID',
                'Name',
                'Company Name',
                'Email',
                'Phone',
                'Contact Type',
                'Subject',
                'Message',
                'Priority',
                'Country',
                'State',
                'District',
                'Project',
                'Admin Notes',
                'Replied At',
                'Replied By',
                'Created At',
                'Updated At'
            ]);

            // CSV data
            foreach ($contacts as $contact) {
                fputcsv($file, [
                    $contact->id,
                    $contact->name,
                    $contact->company_name ?? '',
                    $contact->email,
                    $contact->phone ?? '',
                    $contact->contact_type ? ($contactTypes[$contact->contact_type] ?? $contact->contact_type) : '',
                    $contact->subject,
                    $contact->message,
                    ucfirst($contact->priority ?? ''),
                    $contact->country->name ?? '',
                    $contact->state->name ?? '',
                    $contact->district->name ?? '',
                    $contact->project->name ?? '',
                    $contact->admin_notes ?? '',
                    $contact->replied_at?->format('Y-m-d H:i:s'),
                    $contact->repliedBy->name ?? '',
                    $contact->created_at->format('Y-m-d H:i:s'),
                    $contact->updated_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Update user preference for dashboard cards
     */
    public function updatePreference(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
            'value' => 'required',
        ]);

        $user = auth()->user();
        $preferences = $user->preferences ?? [];
        
        // Convert boolean strings to actual booleans
        $value = $request->value;
        if ($value === 'true' || $value === true) {
            $value = true;
        } elseif ($value === 'false' || $value === false) {
            $value = false;
        }
        
        $preferences[$request->key] = $value;
        
        $user->update(['preferences' => $preferences]);

        return response()->json([
            'success' => true,
            'message' => 'Preference updated successfully.',
        ]);
    }
}
