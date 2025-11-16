<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReminderController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Reminder::class, 'reminder');
    }

    public function index()
    {
        $user = Auth::user();
        $now = now();
        $endOfWeek = $now->copy()->endOfWeek();

        $reminders = Reminder::where('user_id', $user->id)
            ->where('reminder_at', '>=', $now)
            ->where('is_completed', false)
            ->with('lead')
            ->orderBy('reminder_at')
            ->get();

        $upcoming = $reminders->where('reminder_at', '<=', $endOfWeek);
        $later = $reminders->where('reminder_at', '>', $endOfWeek);

        return view('admin.reminders.index', [
            'upcoming' => $upcoming->values(),
            'later' => $later->values(),
        ]);
    }

    public function create()
    {
        return view('admin.reminders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'reminder_at' => 'required|date|after:now',
            'lead_id' => 'nullable|exists:leads,id',
            'type' => 'nullable|string|max:50',
            'priority' => 'nullable|string|in:low,medium,high',
        ]);

        $reminder = Reminder::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'reminder_at' => Carbon::parse($validated['reminder_at']),
            'user_id' => auth()->id(),
            'lead_id' => $validated['lead_id'] ?? null,
            'type' => $validated['type'] ?? 'general',
            'priority' => $validated['priority'] ?? 'medium',
            'is_completed' => false,
        ]);

        return redirect()
            ->route('reminders.index')
            ->with('success', 'Reminder created successfully.');
    }

    public function edit(Reminder $reminder)
    {
        return view('admin.reminders.edit', [
            'reminder' => $reminder,
        ]);
    }

    public function update(Request $request, Reminder $reminder)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'reminder_at' => 'required|date',
            'lead_id' => 'nullable|exists:leads,id',
            'type' => 'nullable|string|max:50',
            'priority' => 'nullable|string|in:low,medium,high',
            'is_completed' => 'boolean',
        ]);

        $reminder->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'reminder_at' => Carbon::parse($validated['reminder_at']),
            'lead_id' => $validated['lead_id'] ?? null,
            'type' => $validated['type'] ?? $reminder->type ?? 'general',
            'priority' => $validated['priority'] ?? $reminder->priority ?? 'medium',
            'is_completed' => $validated['is_completed'] ?? $reminder->is_completed,
        ]);

        return redirect()
            ->route('reminders.index')
            ->with('success', 'Reminder updated successfully.');
    }

    public function destroy(Reminder $reminder)
    {
        $reminder->delete();

        return redirect()
            ->route('reminders.index')
            ->with('success', 'Reminder deleted successfully.');
    }

    public function complete(Reminder $reminder)
    {
        $this->authorize('update', $reminder);
        
        $reminder->update(['is_completed' => true]);

        return back()->with('success', 'Reminder marked as completed.');
    }
}
