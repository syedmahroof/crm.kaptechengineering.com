<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\LeadFollowUp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class LeadFollowUpController extends Controller
{
    /**
     * Display a listing of the follow-ups for a lead.
     */
    public function index(Lead $lead): JsonResponse
    {
        $this->authorize('view', $lead);
        
        try {
            $followUps = $lead->follow_ups()
                ->with(['creator', 'assignedTo'])
                ->orderBy('scheduled_at', 'desc')
                ->get();
                
            return response()->json([
                'data' => $followUps,
                'meta' => [
                    'types' => LeadFollowUp::getTypes(),
                    'statuses' => LeadFollowUp::getStatuses(),
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to fetch lead follow-ups', [
                'lead_id' => $lead->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return response()->json([
                'message' => 'Failed to load follow-ups. Please try again later.'
            ], 500);
        }
    }

    /**
     * Display a listing of all follow-ups (for calendar).
     */
    public function indexAll(): JsonResponse
    {
        try {
            $followUps = LeadFollowUp::with(['creator', 'assignedTo', 'lead'])
                ->orderBy('scheduled_at', 'desc')
                ->get();
                
            return response()->json([
                'data' => $followUps,
                'meta' => [
                    'types' => LeadFollowUp::getTypes(),
                    'statuses' => LeadFollowUp::getStatuses(),
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to fetch all follow-ups', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return response()->json([
                'message' => 'Failed to load follow-ups. Please try again later.'
            ], 500);
        }
    }

    /**
     * Store a newly created follow-up globally (for calendar).
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeGlobal(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'type' => [
                'required',
                'string',
                Rule::in(array_keys(LeadFollowUp::getTypes()))
            ],
            'description' => ['nullable', 'string'],
            'scheduled_at' => ['required', 'date', 'after_or_equal:now'],
            'reminder_at' => ['nullable', 'date', 'after_or_equal:now', 'before_or_equal:scheduled_at'],
            'assigned_to' => [
                'nullable',
                'integer',
                Rule::exists('users', 'id')
            ],
            'location' => ['nullable', 'string', 'max:255'],
            'status' => [
                'nullable',
                'string',
                Rule::in(array_keys(LeadFollowUp::getStatuses()))
            ],
            'lead_id' => ['nullable', 'integer', Rule::exists('leads', 'id')],
        ]);

        DB::beginTransaction();
        
        try {
            $followUp = new LeadFollowUp([
                'lead_id' => $validated['lead_id'] ?? null,
                'title' => $validated['title'],
                'type' => $validated['type'],
                'description' => $validated['description'] ?? null,
                'scheduled_at' => Carbon::parse($validated['scheduled_at']),
                'reminder_at' => isset($validated['reminder_at']) ? Carbon::parse($validated['reminder_at']) : null,
                'assigned_to' => $validated['assigned_to'] ?? null,
                'location' => $validated['location'] ?? null,
                'status' => $validated['status'] ?? LeadFollowUp::STATUS_SCHEDULED,
                'created_by' => Auth::id(),
            ]);
            
            $followUp->save();
            
            // Load relationships for the response
            $followUp->load(['creator', 'assignedTo', 'lead']);
            
            DB::commit();
            
            return response()->json([
                'message' => 'Follow-up created successfully',
                'data' => $followUp
            ], 201);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Failed to create global follow-up', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return response()->json([
                'message' => 'Failed to create follow-up. Please try again.'
            ], 500);
        }
    }

    /**
     * Store a newly created follow-up in storage.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, Lead $lead): JsonResponse
    {
        $this->authorize('update', $lead);
        
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'type' => [
                'required',
                'string',
                Rule::in(array_keys(LeadFollowUp::getTypes()))
            ],
            'description' => ['nullable', 'string'],
            'scheduled_at' => ['required', 'date', 'after_or_equal:now'],
            'reminder_at' => ['nullable', 'date', 'after_or_equal:now', 'before_or_equal:scheduled_at'],
            'assigned_to' => [
                'nullable',
                'integer',
                Rule::exists('users', 'id')
            ],
            'location' => ['nullable', 'string', 'max:255'],
            'status' => [
                'nullable',
                'string',
                Rule::in(array_keys(LeadFollowUp::getStatuses()))
            ],
        ]);

        DB::beginTransaction();
        
        try {
            $followUp = new LeadFollowUp([
                'lead_id' => $lead->id,
                'title' => $validated['title'],
                'type' => $validated['type'],
                'description' => $validated['description'] ?? null,
                'scheduled_at' => Carbon::parse($validated['scheduled_at']),
                'reminder_at' => isset($validated['reminder_at']) ? Carbon::parse($validated['reminder_at']) : null,
                'assigned_to' => $validated['assigned_to'] ?? null,
                'location' => $validated['location'] ?? null,
                'status' => $validated['status'] ?? LeadFollowUp::STATUS_SCHEDULED,
                'created_by' => Auth::id(),
            ]);
            
            $followUp->save();
            
            // Load relationships for the response
            $followUp->load(['creator', 'assignedTo']);
            
            DB::commit();
            
            return response()->json([
                'message' => 'Follow-up created successfully',
                'data' => $followUp
            ], 201);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Failed to create lead follow-up', [
                'lead_id' => $lead->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return response()->json([
                'message' => 'Failed to create follow-up. Please try again.'
            ], 500);
        }
    }

    /**
     * Display the specified follow-up.
     */
    public function show(Lead $lead, LeadFollowUp $followUp): JsonResponse
    {
        $this->authorize('view', $lead);
        
        if ($followUp->lead_id !== $lead->id) {
            abort(404, 'Follow-up not found for this lead.');
        }
        
        $followUp->load(['creator', 'assignedTo']);
        
        return response()->json([
            'data' => $followUp,
            'meta' => [
                'types' => LeadFollowUp::getTypes(),
                'statuses' => LeadFollowUp::getStatuses(),
            ]
        ]);
    }

    /**
     * Update the specified follow-up in storage.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Lead $lead, LeadFollowUp $followUp): JsonResponse
    {
        $this->authorize('update', $lead);
        
        if ($followUp->lead_id !== $lead->id) {
            abort(404, 'Follow-up not found for this lead.');
        }
        
        $validated = $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'type' => [
                'sometimes',
                'required',
                'string',
                Rule::in(array_keys(LeadFollowUp::getTypes()))
            ],
            'description' => ['nullable', 'string'],
            'scheduled_at' => ['sometimes', 'required', 'date', 'after_or_equal:now'],
            'reminder_at' => [
                'nullable', 
                'date', 
                'after_or_equal:now', 
                Rule::when($request->has('scheduled_at'), [
                    'before_or_equal:scheduled_at'
                ])
            ],
            'assigned_to' => [
                'nullable',
                'integer',
                Rule::exists('users', 'id')
            ],
            'location' => ['nullable', 'string', 'max:255'],
            'status' => [
                'sometimes',
                'required',
                'string',
                Rule::in(array_keys(LeadFollowUp::getStatuses()))
            ],
        ]);

        DB::beginTransaction();
        
        try {
            // Handle status change to completed
            if (isset($validated['status']) && $validated['status'] === LeadFollowUp::STATUS_COMPLETED) {
                $validated['completed_at'] = now();
            }
            
            $followUp->update($validated);
            
            // Reload relationships for the response
            $followUp->load(['creator', 'assignedTo']);
            
            DB::commit();
            
            return response()->json([
                'message' => 'Follow-up updated successfully',
                'data' => $followUp
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Failed to update lead follow-up', [
                'follow_up_id' => $followUp->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return response()->json([
                'message' => 'Failed to update follow-up. Please try again.'
            ], 500);
        }
    }

    /**
     * Remove the specified follow-up from storage.
     */
    public function destroy(Lead $lead, LeadFollowUp $followUp): JsonResponse
    {
        $this->authorize('update', $lead);
        
        if ($followUp->lead_id !== $lead->id) {
            abort(404, 'Follow-up not found for this lead.');
        }
        
        try {
            $followUp->delete();
            
            return response()->json([
                'message' => 'Follow-up deleted successfully'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to delete lead follow-up', [
                'follow_up_id' => $followUp->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return response()->json([
                'message' => 'Failed to delete follow-up. Please try again.'
            ], 500);
        }
    }

    /**
     * Mark a follow-up as completed.
     */
    public function complete(Lead $lead, LeadFollowUp $followUp): JsonResponse
    {
        $this->authorize('update', $lead);
        
        if ($followUp->lead_id !== $lead->id) {
            abort(404, 'Follow-up not found for this lead.');
        }
        
        try {
            $followUp->markAsCompleted();
            $followUp->load(['creator', 'assignedTo']);
            
            return response()->json([
                'message' => 'Follow-up marked as completed',
                'data' => $followUp
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to mark follow-up as completed', [
                'follow_up_id' => $followUp->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return response()->json([
                'message' => 'Failed to update follow-up status. Please try again.'
            ], 500);
        }
    }

    /**
     * Cancel a scheduled follow-up.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function cancel(Request $request, Lead $lead, LeadFollowUp $followUp): JsonResponse
    {
        $this->authorize('update', $lead);
        
        if ($followUp->lead_id !== $lead->id) {
            abort(404, 'Follow-up not found for this lead.');
        }
        
        $validated = $request->validate([
            'reason' => ['nullable', 'string', 'max:1000']
        ]);
        
        try {
            $followUp->markAsCanceled($validated['reason'] ?? null);
            $followUp->load(['creator', 'assignedTo']);
            
            return response()->json([
                'message' => 'Follow-up has been canceled',
                'data' => $followUp
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to cancel follow-up', [
                'follow_up_id' => $followUp->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return response()->json([
                'message' => 'Failed to cancel follow-up. Please try again.'
            ], 500);
        }
    }
}
