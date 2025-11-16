<?php

namespace App\Http\Controllers\Leads;
  
use App\Models\LeadPriority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeadPriorityController  
{
    public function index()
    {
        $priorities = LeadPriority::orderBy('level')->get();
        
        return view('admin.lead-priorities.index', [
            'leadPriorities' => $priorities,
        ]);
    }

    public function create()
    {
        return view('admin.lead-priorities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'level' => 'required|integer|min:1',
            'color' => 'required|string|max:20',
            'is_default' => 'boolean',
        ]);

        // Ensure only one default priority
        if ($validated['is_default'] ?? false) {
            LeadPriority::where('is_default', true)->update(['is_default' => false]);
        }

        LeadPriority::create($validated);

        return redirect()->route('lead-priorities.index')
            ->with('success', 'Lead priority created successfully.');
    }

    public function edit(LeadPriority $leadPriority)
    {
        return view('admin.lead-priorities.edit', [
            'priority' => $leadPriority,
        ]);
    }

    public function update(Request $request, LeadPriority $leadPriority)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'level' => 'required|integer|min:1',
            'color' => 'required|string|max:20',
            'is_default' => 'boolean',
        ]);

        // Ensure only one default priority
        if (($validated['is_default'] ?? false) && !$leadPriority->is_default) {
            LeadPriority::where('is_default', true)->update(['is_default' => false]);
        }

        $leadPriority->update($validated);

        return redirect()->route('lead-priorities.index')
            ->with('success', 'Lead priority updated successfully.');
    }

    public function destroy(LeadPriority $leadPriority)
    {
        if ($leadPriority->leads()->exists()) {
            return back()->with('error', 'Cannot delete priority with associated leads.');
        }

        if ($leadPriority->is_default) {
            return back()->with('error', 'Cannot delete the default priority.');
        }

        $leadPriority->delete();

        return redirect()->route('lead-priorities.index')
            ->with('success', 'Lead priority deleted successfully.');
    }

    public function moveUp(LeadPriority $leadPriority)
    {
        $previous = LeadPriority::where('level', '<', $leadPriority->level)
            ->orderBy('level', 'desc')
            ->first();

        if ($previous) {
            DB::transaction(function () use ($leadPriority, $previous) {
                $currentLevel = $leadPriority->level;
                $leadPriority->update(['level' => $previous->level]);
                $previous->update(['level' => $currentLevel]);
            });

            return back()->with('success', 'Priority moved up successfully.');
        }

        return back()->with('info', 'Priority is already at the top.');
    }

    public function moveDown(LeadPriority $leadPriority)
    {
        $next = LeadPriority::where('level', '>', $leadPriority->level)
            ->orderBy('level')
            ->first();

        if ($next) {
            DB::transaction(function () use ($leadPriority, $next) {
                $currentLevel = $leadPriority->level;
                $leadPriority->update(['level' => $next->level]);
                $next->update(['level' => $currentLevel]);
            });

            return back()->with('success', 'Priority moved down successfully.');
        }

        return back()->with('info', 'Priority is already at the bottom.');
    }
}
