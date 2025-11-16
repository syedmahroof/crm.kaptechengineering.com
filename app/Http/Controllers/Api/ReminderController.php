<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reminder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ReminderController extends Controller
{
    /**
     * Display a listing of reminders.
     */
    public function index(): JsonResponse
    {
        try {
            $reminders = Reminder::with(['user', 'lead'])
                ->orderBy('reminder_at', 'asc')
                ->get();
                
            return response()->json([
                'data' => $reminders,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to fetch reminders', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return response()->json([
                'message' => 'Failed to load reminders. Please try again later.'
            ], 500);
        }
    }

    /**
     * Store a newly created reminder in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'reminder_at' => ['required', 'date', 'after_or_equal:now'],
            'lead_id' => ['nullable', 'integer', Rule::exists('leads', 'id')],
            'type' => ['nullable', 'string', 'max:50'],
            'priority' => ['nullable', 'string', Rule::in(['low', 'medium', 'high'])],
        ]);

        DB::beginTransaction();
        
        try {
            $reminder = new Reminder([
                'user_id' => Auth::id(),
                'lead_id' => $validated['lead_id'] ?? null,
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'reminder_at' => Carbon::parse($validated['reminder_at']),
                'type' => $validated['type'] ?? 'general',
                'priority' => $validated['priority'] ?? 'medium',
                'is_completed' => false,
            ]);
            
            $reminder->save();
            
            // Load relationships for the response
            $reminder->load(['user', 'lead']);
            
            DB::commit();
            
            return response()->json([
                'message' => 'Reminder created successfully',
                'data' => $reminder
            ], 201);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Failed to create reminder', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return response()->json([
                'message' => 'Failed to create reminder. Please try again.'
            ], 500);
        }
    }

    /**
     * Display the specified reminder.
     */
    public function show(Reminder $reminder): JsonResponse
    {
        try {
            $reminder->load(['user', 'lead']);
            
            return response()->json([
                'data' => $reminder
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to fetch reminder', [
                'reminder_id' => $reminder->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return response()->json([
                'message' => 'Failed to load reminder. Please try again later.'
            ], 500);
        }
    }

    /**
     * Update the specified reminder in storage.
     */
    public function update(Request $request, Reminder $reminder): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'reminder_at' => ['sometimes', 'required', 'date', 'after_or_equal:now'],
            'lead_id' => ['nullable', 'integer', Rule::exists('leads', 'id')],
            'type' => ['nullable', 'string', 'max:50'],
            'priority' => ['nullable', 'string', Rule::in(['low', 'medium', 'high'])],
            'is_completed' => ['nullable', 'boolean'],
        ]);

        DB::beginTransaction();
        
        try {
            $reminder->update($validated);
            
            // Load relationships for the response
            $reminder->load(['user', 'lead']);
            
            DB::commit();
            
            return response()->json([
                'message' => 'Reminder updated successfully',
                'data' => $reminder
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Failed to update reminder', [
                'reminder_id' => $reminder->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return response()->json([
                'message' => 'Failed to update reminder. Please try again.'
            ], 500);
        }
    }

    /**
     * Remove the specified reminder from storage.
     */
    public function destroy(Reminder $reminder): JsonResponse
    {
        try {
            $reminder->delete();
            
            return response()->json([
                'message' => 'Reminder deleted successfully'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to delete reminder', [
                'reminder_id' => $reminder->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return response()->json([
                'message' => 'Failed to delete reminder. Please try again.'
            ], 500);
        }
    }
}
