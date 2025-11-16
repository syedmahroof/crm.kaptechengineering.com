<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\Project;
use App\Models\Contact;
use App\Models\Country;
use App\Models\State;
use App\Models\District;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Enquiry::with(['project', 'country', 'state', 'district', 'creator', 'contacts'])->orderBy('created_at', 'desc');

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        $enquiries = $query->paginate(15);
        $projects = Project::orderBy('name')->get();
        $totalEnquiries = Enquiry::count();

        return view('admin.enquiries.index', [
            'enquiries' => $enquiries,
            'projects' => $projects,
            'totalEnquiries' => $totalEnquiries,
            'filters' => $request->only(['search', 'status', 'project_id']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::orderBy('name')->get();
        $contacts = Contact::with(['country', 'state', 'district'])->orderBy('name')->get();
        $countries = Country::active()->ordered()->get();
        $india = Country::where('iso_code', 'IN')->first();
        $states = collect();
        $districts = collect();
        
        if ($india) {
            $states = State::where('country_id', $india->id)->active()->ordered()->get();
        }

        return view('admin.enquiries.create', [
            'projects' => $projects,
            'contacts' => $contacts,
            'countries' => $countries,
            'india' => $india,
            'states' => $states,
            'districts' => $districts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'nullable|exists:projects,id',
            'country_id' => 'nullable|exists:countries,id',
            'state_id' => 'nullable|exists:states,id',
            'district_id' => 'nullable|exists:districts,id',
            'status' => 'nullable|in:new,in_progress,quoted,accepted,rejected,completed',
            'contact_ids' => 'required|array|min:1',
            'contact_ids.*' => 'exists:contacts,id',
            'contact_types' => 'nullable|array',
            'contact_notes' => 'nullable|array',
        ]);

        $enquiry = Enquiry::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'project_id' => $validated['project_id'] ?? null,
            'country_id' => $validated['country_id'] ?? null,
            'state_id' => $validated['state_id'] ?? null,
            'district_id' => $validated['district_id'] ?? null,
            'status' => $validated['status'] ?? 'new',
            'created_by' => auth()->id(),
        ]);

        // Attach contacts with their types and notes
        $contactsData = [];
        foreach ($validated['contact_ids'] as $index => $contactId) {
            $contactsData[$contactId] = [
                'contact_type' => $validated['contact_types'][$index] ?? null,
                'notes' => $validated['contact_notes'][$index] ?? null,
            ];
        }
        $enquiry->contacts()->attach($contactsData);

        return redirect()->route('enquiries.index')
                        ->with('success', 'Enquiry created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Enquiry $enquiry)
    {
        $enquiry->load(['project', 'country', 'state', 'district', 'creator', 'contacts']);
        
        return view('admin.enquiries.show', [
            'enquiry' => $enquiry,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enquiry $enquiry)
    {
        $enquiry->load('contacts');
        $projects = Project::orderBy('name')->get();
        $contacts = Contact::with(['country', 'state', 'district'])->orderBy('name')->get();
        $countries = Country::active()->ordered()->get();
        $states = collect();
        $districts = collect();
        
        if ($enquiry->country_id) {
            $states = State::where('country_id', $enquiry->country_id)->active()->ordered()->get();
        }
        
        if ($enquiry->state_id) {
            $districts = District::where('state_id', $enquiry->state_id)->active()->ordered()->get();
        }

        return view('admin.enquiries.edit', [
            'enquiry' => $enquiry,
            'projects' => $projects,
            'contacts' => $contacts,
            'countries' => $countries,
            'states' => $states,
            'districts' => $districts,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Enquiry $enquiry)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'nullable|exists:projects,id',
            'country_id' => 'nullable|exists:countries,id',
            'state_id' => 'nullable|exists:states,id',
            'district_id' => 'nullable|exists:districts,id',
            'status' => 'nullable|in:new,in_progress,quoted,accepted,rejected,completed',
            'contact_ids' => 'required|array|min:1',
            'contact_ids.*' => 'exists:contacts,id',
            'contact_types' => 'nullable|array',
            'contact_notes' => 'nullable|array',
        ]);

        $enquiry->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'project_id' => $validated['project_id'] ?? null,
            'country_id' => $validated['country_id'] ?? null,
            'state_id' => $validated['state_id'] ?? null,
            'district_id' => $validated['district_id'] ?? null,
            'status' => $validated['status'] ?? $enquiry->status,
        ]);

        // Sync contacts with their types and notes
        $contactsData = [];
        foreach ($validated['contact_ids'] as $index => $contactId) {
            $contactsData[$contactId] = [
                'contact_type' => $validated['contact_types'][$index] ?? null,
                'notes' => $validated['contact_notes'][$index] ?? null,
            ];
        }
        $enquiry->contacts()->sync($contactsData);

        return redirect()->route('enquiries.index')
                        ->with('success', 'Enquiry updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enquiry $enquiry)
    {
        $enquiry->delete();

        return redirect()->route('enquiries.index')
                        ->with('success', 'Enquiry deleted successfully.');
    }
}
