<?php

namespace App\Http\Controllers\Leads;

use App\Models\Lead;
use App\Models\LeadSource;
use App\Models\LeadPriority;
use App\Models\User;
use App\Models\LeadLossReason;
use App\Models\LeadStatus;
use App\Models\File;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Requests\Leads\StoreLeadRequest;
use App\Http\Requests\Leads\UpdateLeadRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\ValidationException;
use App\Actions\Leads\StoreLeadAction;

class LeadsController 
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Lead::class);
        
        $query = Lead::with(['lead_source', 'lead_priority', 'assigned_user', 'lead_status', 'business_type', 'projects', 'customers', 'contacts']);
        
        // Apply visibility rules based on user role
        $user = Auth::user();
        $this->applyLeadVisibility($query, $user);
        
        // Apply status filter
        if ($request->filled('status')) {
            $query->whereHas('lead_status', function($q) use ($request) {
                $q->where('slug', $request->status);
            });
        }
        
        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        // Apply lead source filter
        if ($request->filled('lead_source_id')) {
            $query->where('lead_source_id', $request->lead_source_id);
        }
        
        // Apply lead priority filter
        if ($request->filled('lead_priority_id')) {
            $query->where('lead_priority_id', $request->lead_priority_id);
        }
        
        // Apply assigned user filter
        if ($request->filled('assigned_user_id')) {
            if ($user->hasRole('super-admin')) {
                // Super-admin can filter by any user
                $query->where('assigned_user_id', $request->assigned_user_id);
            } elseif ($user->hasRole('manager')) {
                // Manager can filter by users in their branches or themselves
                $branchIds = $user->branches()->pluck('branches.id');
                $branchUserIds = \App\Models\User::whereHas('branches', function($q) use ($branchIds) {
                    $q->whereIn('branches.id', $branchIds);
                })->pluck('id')->push($user->id);
                
                if ($branchUserIds->contains($request->assigned_user_id)) {
                    $query->where('assigned_user_id', $request->assigned_user_id);
                }
            } elseif ($user->hasRole('team-lead')) {
                // Team lead can filter by team members or themselves
                $teamMemberIds = collect([$user->id]);
                $ledTeams = $user->ledTeams()->with('users')->get();
                foreach ($ledTeams as $team) {
                    $teamMemberIds = $teamMemberIds->merge($team->users->pluck('id'));
                }
                $teamMemberIds = $teamMemberIds->unique();
                
                if ($teamMemberIds->contains($request->assigned_user_id)) {
                    $query->where('assigned_user_id', $request->assigned_user_id);
                }
            } else {
                // Agents can only filter by their own ID
                $query->where('assigned_user_id', $user->id);
            }
        }
        
        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        // Validate sort_by to prevent SQL injection
        $allowedSortFields = ['created_at', 'name', 'email', 'status', 'updated_at', 'converted_at'];
        if (!in_array($sortBy, $allowedSortFields)) {
            $sortBy = 'created_at';
        }
        
        // Validate sort_order
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'desc';
        }
        
        $query->orderBy($sortBy, $sortOrder);
        
        $leads = $query->paginate(15)->withQueryString();

        // Base query for stats to apply the same filters
        $baseQuery = Lead::query();
        
        // Apply visibility rules based on user role
        $this->applyLeadVisibility($baseQuery, $user);
        
        if ($request->filled('search')) {
            $search = $request->search;
            $baseQuery->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('lead_source_id')) {
            $baseQuery->where('lead_source_id', $request->lead_source_id);
        }
        
        if ($request->filled('lead_priority_id')) {
            $baseQuery->where('lead_priority_id', $request->lead_priority_id);
        }
        
        // Apply assigned user filter (same logic as main query)
        if ($request->filled('assigned_user_id')) {
            if ($user->hasRole('super-admin')) {
                $baseQuery->where('assigned_user_id', $request->assigned_user_id);
            } elseif ($user->hasRole('manager')) {
                $branchIds = $user->branches()->pluck('branches.id');
                $branchUserIds = \App\Models\User::whereHas('branches', function($q) use ($branchIds) {
                    $q->whereIn('branches.id', $branchIds);
                })->pluck('id')->push($user->id);
                
                if ($branchUserIds->contains($request->assigned_user_id)) {
                    $baseQuery->where('assigned_user_id', $request->assigned_user_id);
                }
            } elseif ($user->hasRole('team-lead')) {
                $teamMemberIds = collect([$user->id]);
                $ledTeams = $user->ledTeams()->with('users')->get();
                foreach ($ledTeams as $team) {
                    $teamMemberIds = $teamMemberIds->merge($team->users->pluck('id'));
                }
                $teamMemberIds = $teamMemberIds->unique();
                
                if ($teamMemberIds->contains($request->assigned_user_id)) {
                    $baseQuery->where('assigned_user_id', $request->assigned_user_id);
                }
            } else {
                $baseQuery->where('assigned_user_id', $user->id);
            }
        }

        // Get status counts using lead_status relationship
        $stats = [
            'total' => (clone $baseQuery)->count(),
            'new' => (clone $baseQuery)->whereHas('lead_status', function($q) {
                $q->where('slug', 'new');
            })->count(),
            'hot_lead' => (clone $baseQuery)->whereHas('lead_status', function($q) {
                $q->where('slug', 'hot_lead');
            })->count(),
            'convert_this_week' => (clone $baseQuery)->whereHas('lead_status', function($q) {
                $q->where('slug', 'convert_this_week');
            })->count(),
            'cold_lead' => (clone $baseQuery)->whereHas('lead_status', function($q) {
                $q->where('slug', 'cold_lead');
            })->count(),
            'converted' => (clone $baseQuery)->whereHas('lead_status', function($q) {
                $q->where('slug', 'converted');
            })->count(),
            'lost' => (clone $baseQuery)->whereHas('lead_status', function($q) {
                $q->where('slug', 'lost');
            })->count(),
        ];

        // Get filter options
        $leadSources = LeadSource::where('is_active', true)->orderBy('name')->get();
        $leadPriorities = LeadPriority::orderBy('level')->get();
        $users = User::select(['id', 'name', 'email'])
            ->orderBy('name')
            ->get()
            ->map(function($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                ];
            });

        return view('admin.leads.index', [
            'leads' => $leads,
            'filters' => [
                'status' => request('status', ''),
                'search' => request('search', ''),
                'lead_source_id' => request('lead_source_id', ''),
                'lead_priority_id' => request('lead_priority_id', ''),
                'assigned_user_id' => request('assigned_user_id', ''),
            ],
            'stats' => $stats,
            'leadSources' => $leadSources,
            'leadPriorities' => $leadPriorities,
            'users' => $users,
        ]);
    }

    public function create()
    {
        $this->authorize('create', Lead::class);
        
        $sources = LeadSource::where('is_active', true)->get();
        $priorities = LeadPriority::orderBy('level')->get();
        $users = User::select(['id', 'name', 'email'])
            ->orderBy('name')
            ->get();
        $leadStatuses = \App\Models\LeadStatus::active()->ordered()->get();
        $businessTypes = \App\Models\BusinessType::active()->ordered()->get();
        $countries = \App\Models\Country::where('is_active', true)->select(['id', 'name', 'iso_code', 'flag_image', 'phone_code'])->orderBy('name')->get();
        
        // Get India's ID and states for default selection
        $india = \App\Models\Country::where('iso_code', 'IN')->first();
        $indiaStates = $india ? \App\Models\State::where('country_id', $india->id)->with('country')->orderBy('name')->get() : collect();
        
        $branches = \App\Models\Branch::where('is_active', true)->orderBy('name')->get();
        $projects = \App\Models\Project::orderBy('name')->get();
        $customers = \App\Models\Customer::orderBy('first_name')->orderBy('last_name')->get();
        $contacts = \App\Models\Contact::orderBy('name')->get();
        $products = \App\Models\Product::where('is_active', true)->orderBy('name')->get();

        return view('admin.leads.create', [
            'sources' => $sources,
            'priorities' => $priorities,
            'users' => $users,
            'leadStatuses' => $leadStatuses,
            'businessTypes' => $businessTypes,
            'countries' => $countries,
            'india' => $india,
            'indiaStates' => $indiaStates,
            'branches' => $branches,
            'projects' => $projects,
            'customers' => $customers,
            'contacts' => $contacts,
            'products' => $products,
        ]);
    }

    public function store(StoreLeadRequest $request, StoreLeadAction $action)
    {
        try {
            $lead = $action->execute($request->validated());
            
            // Always return an Inertia response for web requests
            return redirect()->route('leads.index')
                ->with('success', 'Lead created successfully.')
                ->with('created_lead', $lead);
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create lead: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Lead $lead)
    {
        $this->authorize('view', $lead);
        
        // Log the lead ID being requested
        \Log::info('Showing lead', ['lead_id' => $lead->id]);
        
        // Eager load relationships and counts
        $lead->load([
            'lead_source',
            'lead_priority',
            'assigned_user',
            'lead_status',
            'lossReason',
            'business_type',
            'creator',
            'updater',
            'persons',
            'follow_ups',
            'notes',
            'notes.creator',
            'leadProducts.product',
            'files.user',
            'projects',
            'customers',
            'contacts',
        ])->loadCount([
            'persons',
            'follow_ups',
            'notes',
           
            'files',
        ]);

        // Get all activities for comprehensive timeline
        $activities = $lead->activities()
            ->with('causer')
            ->latest()
            ->get();

        // Get follow-ups as timeline items
        $followUps = $lead->follow_ups()
            ->with(['creator', 'assignedTo'])
            ->latest('created_at')
            ->get()
            ->map(function($followUp) {
                return (object)[
                    'type' => 'follow_up',
                    'subtype' => $followUp->status === 'completed' ? 'follow_up_completed' : ($followUp->status === 'canceled' ? 'follow_up_canceled' : 'follow_up_created'),
                    'created_at' => $followUp->created_at,
                    'scheduled_at' => $followUp->scheduled_at,
                    'completed_at' => $followUp->completed_at,
                    'user' => $followUp->creator,
                    'data' => $followUp,
                ];
            });

        // Get notes as timeline items
        $notes = $lead->notes()
            ->with('creator')
            ->latest('created_at')
            ->get()
            ->map(function($note) {
                return (object)[
                    'type' => 'note',
                    'subtype' => 'note_created',
                    'created_at' => $note->created_at,
                    'updated_at' => $note->updated_at,
                    'user' => $note->creator,
                    'data' => $note,
                ];
            });

        // Get files as timeline items
        $files = $lead->files()
            ->with('user')
            ->latest('created_at')
            ->get()
            ->map(function($file) {
                return (object)[
                    'type' => 'file',
                    'subtype' => 'file_uploaded',
                    'created_at' => $file->created_at,
                    'user' => $file->user,
                    'data' => $file,
                ];
            });

        // Combine all timeline items
        $timelineItems = collect()
            ->merge($activities->map(function($activity) {
                return (object)[
                    'type' => 'activity',
                    'subtype' => $activity->type,
                    'created_at' => $activity->created_at,
                    'user' => $activity->causer,
                    'data' => $activity,
                ];
            }))
            ->merge($followUps)
            ->merge($notes)
            ->merge($files)
            ->sortByDesc('created_at')
            ->values();

        // Log the data being sent to the view
        \Log::info('Lead data prepared for view', [
            'lead_id' => $lead->id,
            'lead_name' => $lead->name,
            'has_source' => !is_null($lead->lead_source),
            'has_priority' => !is_null($lead->lead_priority),
            'has_assigned_user' => !is_null($lead->assigned_user),
            'persons_count' => $lead->persons_count ?? 0,
            'follow_ups_count' => $lead->follow_ups_count ?? 0,
            'notes_count' => $lead->notes_count ?? 0,
            'activities_count' => $activities->count(),
        ]);

        

        $leadStatuses = LeadStatus::active()->ordered()->get();
        $lossReasons = LeadLossReason::active()->ordered()->get();

        // Gather analytics data
        $analytics = $this->getLeadAnalytics($lead);

        return view('admin.leads.show', [
            'lead' => $lead,
            'activities' => $activities,
            'timelineItems' => $timelineItems,
            'leadStatuses' => $leadStatuses,
            'lossReasons' => $lossReasons,
            'analytics' => $analytics,
        ]);
    }

    public function edit(Lead $lead)
    {
        $this->authorize('update', $lead);
        
        $sources = LeadSource::where('is_active', true)->get();
        $priorities = LeadPriority::orderBy('level')->get();
        $users = User::select(['id', 'name', 'email'])
            ->orderBy('name')
            ->get();
        $leadStatuses = \App\Models\LeadStatus::active()->ordered()->get();
        $businessTypes = \App\Models\BusinessType::active()->ordered()->get();
        $countries = \App\Models\Country::where('is_active', true)->select(['id', 'name', 'iso_code', 'flag_image', 'phone_code'])->orderBy('name')->get();
        $states = \App\Models\State::with('country')->orderBy('name')->get();
        $branches = \App\Models\Branch::where('is_active', true)->orderBy('name')->get();
        $projects = \App\Models\Project::orderBy('name')->get();
        $customers = \App\Models\Customer::orderBy('first_name')->orderBy('last_name')->get();
        $contacts = \App\Models\Contact::orderBy('name')->get();
        
        // Load existing relationships
        $lead->load(['projects', 'customers', 'contacts']);

        return view('admin.leads.edit', [
            'lead' => $lead,
            'sources' => $sources,
            'priorities' => $priorities,
            'users' => $users,
            'leadStatuses' => $leadStatuses,
            'businessTypes' => $businessTypes,
            'countries' => $countries,
            'states' => $states,
            'branches' => $branches,
            'projects' => $projects,
            'customers' => $customers,
            'contacts' => $contacts,
        ]);
    }

    public function update(UpdateLeadRequest $request, Lead $lead)
    {
        $validated = $request->validated();
        
        // Extract entity IDs for polymorphic relationships
        $projectIds = $validated['project_ids'] ?? [];
        $customerIds = $validated['customer_ids'] ?? [];
        $contactIds = $validated['contact_ids'] ?? [];
        unset($validated['project_ids'], $validated['customer_ids'], $validated['contact_ids']);

        $lead->update(array_merge($validated, [
            'updated_by' => Auth::id(),
        ]));
        
        // Sync polymorphic relationships
        $lead->projects()->sync($projectIds);
        $lead->customers()->sync($customerIds);
        $lead->contacts()->sync($contactIds);

        return redirect()->route('leads.show', $lead)
            ->with('success', 'Lead updated successfully.');
    }

    public function destroy(Lead $lead)
    {
        $this->authorize('delete', $lead);
        
        $lead->delete();

        return redirect()->route('leads.index')
            ->with('success', 'Lead deleted successfully.');
    }

    public function sendItinerary(Lead $lead)
    {
        $this->authorize('update', $lead);

        try {
            // Update itinerary_sent_at timestamp (status update removed per user request)
            $lead->update(['itinerary_sent_at' => now()]);

            // Here you can add logic to actually send the itinerary
            // For example: send email, generate PDF, etc.
            
            return response()->json([
                'success' => true,
                'message' => 'Itinerary sent successfully',
                'lead' => $lead->fresh(['lead_status', 'business_type'])
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send itinerary: ' . $e->getMessage()
            ], 500);
        }
    }

    public function storeFollowUp(Request $request, Lead $lead)
    {
        $this->authorize('update', $lead);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:call,email,meeting,other',
            'description' => 'nullable|string',
            'scheduled_at' => 'required|date|after_or_equal:now',
            'reminder_at' => 'nullable|date',
            'status' => 'required|in:scheduled,completed,canceled,no_show',
            'location' => 'nullable|string|max:255',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $followUp = $lead->follow_ups()->create(array_merge($validated, [
            'created_by' => Auth::id(),
        ]));

        return response()->json($followUp->load('creator'));
    }

    public function storeNote(Request $request, Lead $lead)
    {
        $this->authorize('update', $lead);

        try {
            $validated = $request->validate([
                'content' => 'required|string|max:10000',
            ]);

            $note = $lead->notes()->create([
                'content' => $validated['content'],
                'created_by' => Auth::id(),
            ]);

            return response()->json($note->load('creator'), 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error storing note: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to create note. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function convert(Lead $lead)
    {
        $this->authorize('update', $lead);

        $lead->markAsConverted();

        return back()->with('success', 'Lead marked as converted.');
    }

    public function markAsLost(Request $request, Lead $lead)
    {
        $this->authorize('update', $lead);

        $validated = $request->validate([
            'loss_reason_id' => 'required|exists:lead_loss_reasons,id',
            'remarks' => 'required|string|max:1000',
        ]);

        $lead->markAsLost((int) $validated['loss_reason_id'], $validated['remarks']);

        return back()->with('success', 'Lead marked as lost.');
    }

    public function updateStatus(Request $request, Lead $lead)
    {
        $this->authorize('update', $lead);

        $validated = $request->validate([
            'status_id' => ['required', 'exists:lead_statuses,id'],
            'loss_reason_id' => ['nullable', 'exists:lead_loss_reasons,id'],
            'remarks' => ['nullable', 'string', 'max:1000'],
        ]);

        $status = LeadStatus::findOrFail($validated['status_id']);

        if ($status->slug === Lead::STATUS_LOST) {
            if (empty($validated['loss_reason_id'])) {
                throw ValidationException::withMessages([
                    'loss_reason_id' => 'A loss reason is required when marking a lead as lost.',
                ]);
            }

            if (!$request->filled('remarks')) {
                throw ValidationException::withMessages([
                    'remarks' => 'Please provide remarks when marking a lead as lost.',
                ]);
            }
        }

        $updateData = [
            'lead_status_id' => $status->id,
            'status' => $status->slug,
            'updated_by' => Auth::id(),
        ];

        if ($status->slug === Lead::STATUS_LOST) {
            $updateData['lead_loss_reason_id'] = (int) $validated['loss_reason_id'];
            $updateData['lost_reason'] = $request->input('remarks');
            $updateData['lost_at'] = now();
            $updateData['converted_at'] = null;
        } else {
            $updateData['lead_loss_reason_id'] = null;
            $updateData['lost_reason'] = null;
            $updateData['lost_at'] = null;

            if ($status->slug === Lead::STATUS_CONVERTED) {
                $updateData['converted_at'] = $lead->converted_at ?? now();
            } else {
                $updateData['converted_at'] = null;
            }
        }

        $lead->update($updateData);

        $lead->recordActivity('status_updated', [
            'status' => $status->slug,
            'status_name' => $status->name,
            'loss_reason_id' => $updateData['lead_loss_reason_id'] ?? null,
        ]);

        return response()->json([
            'message' => 'Lead status updated successfully.',
            'lead' => $lead->fresh(['lead_status', 'lossReason'])
        ]);
    }


    public function markItinerarySent(Request $request, Lead $lead)
    {
        $this->authorize('update', $lead);

        $lead->update([
            'itinerary_sent_at' => now(),
        ]);

        // Status update removed per user request - only tracking timestamp

        $lead->recordActivity('itinerary_sent', [
            'sent_at' => now()->toDateTimeString(),
        ]);

        return back()->with('success', 'Itinerary marked as sent.');
    }

    public function markFlightDetailsSent(Request $request, Lead $lead)
    {
        $this->authorize('update', $lead);

        $lead->update([
            'flight_details_sent_at' => now(),
        ]);

        $lead->recordActivity('flight_details_sent', [
            'sent_at' => now()->toDateTimeString(),
        ]);

        return back()->with('success', 'Flight details marked as sent.');
    }

    public function storeFile(Request $request, Lead $lead)
    {
        $this->authorize('update', $lead);

        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
            'description' => 'nullable|string|max:255',
        ]);

        $uploadedFile = $request->file('file');
        $path = $uploadedFile->store('leads/files', 'public');

        $file = $lead->files()->create([
            'name' => $uploadedFile->getClientOriginalName(),
            'description' => $request->input('description'),
            'path' => $path,
            'mime_type' => $uploadedFile->getMimeType(),
            'size' => $uploadedFile->getSize(),
            'user_id' => Auth::id(),
        ]);

        $lead->recordActivity('file_uploaded', [
            'file_name' => $file->name,
            'file_id' => $file->id,
        ]);

        return response()->json([
            'success' => true,
            'file' => $file->load('user'),
            'message' => 'File uploaded successfully.',
        ]);
    }

    public function deleteFile(Lead $lead, File $file)
    {
        $this->authorize('update', $lead);

        // Verify the file belongs to this lead
        if ($file->fileable_type !== Lead::class || $file->fileable_id !== $lead->id) {
            return response()->json([
                'success' => false,
                'message' => 'File not found.',
            ], 404);
        }

        // Delete the physical file
        if (Storage::disk('public')->exists($file->path)) {
            Storage::disk('public')->delete($file->path);
        }

        $fileName = $file->name;
        $file->delete();

        $lead->recordActivity('file_deleted', [
            'file_name' => $fileName,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'File deleted successfully.',
        ]);
    }

    /**
     * Get comprehensive analytics for a lead
     */
    private function getLeadAnalytics(Lead $lead): array
    {
        // Lost reason analytics (business insights)
        $lostReasonStats = \App\Models\Lead::where('status', Lead::STATUS_LOST)
            ->whereNotNull('lead_loss_reason_id')
            ->selectRaw('lead_loss_reason_id, COUNT(*) as count')
            ->groupBy('lead_loss_reason_id')
            ->get()
            ->map(function ($item) {
                $lossReason = \App\Models\LeadLossReason::find($item->lead_loss_reason_id);
                return [
                    'reason' => $lossReason->name ?? 'Unknown',
                    'icon' => $lossReason->icon ?? 'fa-exclamation-triangle',
                    'color' => $lossReason->color ?? '#ef4444',
                    'count' => $item->count,
                ];
            })
            ->sortByDesc('count')
            ->values();

       

        // Overall lead statistics
        $totalLeads = Lead::count();
        $convertedLeads = Lead::where('status', Lead::STATUS_CONVERTED)->count();
        $lostLeads = Lead::where('status', Lead::STATUS_LOST)->count();
        $conversionRate = $totalLeads > 0 ? round(($convertedLeads / $totalLeads) * 100, 2) : 0;
        $lossRate = $totalLeads > 0 ? round(($lostLeads / $totalLeads) * 100, 2) : 0;

        // Status distribution
        $statusDistribution = Lead::selectRaw('lead_status_id, COUNT(*) as count')
            ->whereNotNull('lead_status_id')
            ->groupBy('lead_status_id')
            ->with('lead_status')
            ->get()
            ->map(function ($item) {
                return [
                    'status' => $item->lead_status->name ?? 'Unknown',
                    'slug' => $item->lead_status->slug ?? 'unknown',
                    'color' => $item->lead_status->color ?? '#6b7280',
                    'count' => $item->count,
                ];
            });

        // Source performance
        $sourcePerformance = Lead::selectRaw('lead_source_id, COUNT(*) as count')
            ->whereNotNull('lead_source_id')
            ->groupBy('lead_source_id')
            ->with('lead_source')
            ->get()
            ->map(function ($item) {
                return [
                    'source' => $item->lead_source->name ?? 'Unknown',
                    'count' => $item->count,
                ];
            })
            ->sortByDesc('count')
            ->values();

        // User performance
        $userPerformance = Lead::selectRaw('assigned_user_id, COUNT(*) as total, 
                SUM(CASE WHEN status = "' . Lead::STATUS_CONVERTED . '" THEN 1 ELSE 0 END) as converted')
            ->whereNotNull('assigned_user_id')
            ->groupBy('assigned_user_id')
            ->with('assigned_user')
            ->get()
            ->map(function ($item) {
                $conversionRate = $item->total > 0 ? round(($item->converted / $item->total) * 100, 2) : 0;
                return [
                    'user' => $item->assigned_user->name ?? 'Unknown',
                    'total' => $item->total,
                    'converted' => $item->converted,
                    'conversion_rate' => $conversionRate,
                ];
            })
            ->sortByDesc('conversion_rate')
            ->values();

        // Average time to conversion
        $avgTimeToConversion = Lead::where('status', Lead::STATUS_CONVERTED)
            ->whereNotNull('converted_at')
            ->whereNotNull('created_at')
            ->get()
            ->map(function ($lead) {
                return $lead->created_at->diffInDays($lead->converted_at);
            })
            ->avg();

        // Average time to loss
        $avgTimeToLoss = Lead::where('status', Lead::STATUS_LOST)
            ->whereNotNull('lost_at')
            ->whereNotNull('created_at')
            ->get()
            ->map(function ($lead) {
                return $lead->created_at->diffInDays($lead->lost_at);
            })
            ->avg();

        // Recent activity trends (last 30 days)
        $recentActivityTrends = Lead::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Priority distribution
        $priorityDistribution = Lead::selectRaw('lead_priority_id, COUNT(*) as count')
            ->whereNotNull('lead_priority_id')
            ->groupBy('lead_priority_id')
            ->with('lead_priority')
            ->get()
            ->map(function ($item) {
                return [
                    'priority' => $item->lead_priority->name ?? 'Unknown',
                    'color' => $item->lead_priority->color ?? '#6b7280',
                    'count' => $item->count,
                ];
            });

        return [
            'lost_reason_stats' => $lostReasonStats,
            'overall_stats' => [
                'total_leads' => $totalLeads,
                'converted_leads' => $convertedLeads,
                'lost_leads' => $lostLeads,
                'conversion_rate' => $conversionRate,
                'loss_rate' => $lossRate,
                'avg_time_to_conversion' => round($avgTimeToConversion ?? 0, 1),
                'avg_time_to_loss' => round($avgTimeToLoss ?? 0, 1),
            ],
            'status_distribution' => $statusDistribution,
            'source_performance' => $sourcePerformance,
            'user_performance' => $userPerformance,
            'recent_activity_trends' => $recentActivityTrends,
            'priority_distribution' => $priorityDistribution,
        ];
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
            // Get all team members from teams where this user is a team lead
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

    /**
     * Export leads to CSV/Excel
     */
    public function export(Request $request)
    {
        $this->authorize('viewAny', Lead::class);
        
        $query = Lead::with(['lead_source', 'lead_priority', 'assigned_user', 'lead_status', 'business_type', 'project']);
        
        // Apply visibility rules
        $user = Auth::user();
        $this->applyLeadVisibility($query, $user);
        
        // Apply filters
        if ($request->filled('status')) {
            $query->whereHas('lead_status', function($q) use ($request) {
                $q->where('slug', $request->status);
            });
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        if ($request->filled('lead_source_id')) {
            $query->where('lead_source_id', $request->lead_source_id);
        }
        if ($request->filled('lead_priority_id')) {
            $query->where('lead_priority_id', $request->lead_priority_id);
        }
        if ($request->filled('assigned_user_id')) {
            $query->where('assigned_user_id', $request->assigned_user_id);
        }

        $leads = $query->orderBy('created_at', 'desc')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=leads_' . now()->format('Y-m-d') . '.csv',
        ];

        $callback = function() use ($leads) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'ID',
                'Name',
                'Email',
                'Phone',
                'Lead Source',
                'Priority',
                'Status',
                'Business Type',
                'Assigned To',
                'Project',
                'Value',
                'Created At',
                'Updated At'
            ]);

            // CSV data
            foreach ($leads as $lead) {
                fputcsv($file, [
                    $lead->id,
                    $lead->name,
                    $lead->email ?? '',
                    $lead->phone ?? '',
                    $lead->lead_source->name ?? '',
                    $lead->lead_priority->name ?? '',
                    $lead->lead_status->name ?? '',
                    $lead->business_type->name ?? '',
                    $lead->assigned_user->name ?? '',
                    $lead->project->name ?? '',
                    $lead->value ?? '',
                    $lead->created_at->format('Y-m-d H:i:s'),
                    $lead->updated_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

}
