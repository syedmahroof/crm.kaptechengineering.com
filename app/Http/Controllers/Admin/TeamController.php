<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Team::with(['teamLeads', 'users']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $status = $request->get('status');
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $teams = $query->latest()->paginate(15)->withQueryString();

        return view('admin.teams.index', [
            'teams' => $teams,
            'filters' => $request->only(['search', 'status']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // Get all users with team-lead role for team leads selection
        $teamLeads = User::whereHas('roles', function($query) {
            $query->where('name', 'team-lead');
        })->orderBy('name')->get();

        // Get all users for team members selection
        $users = User::orderBy('name')->get();

        return view('admin.teams.create', [
            'teamLeads' => $teamLeads,
            'users' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:teams,name',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'team_lead_ids' => 'nullable|array',
            'team_lead_ids.*' => 'exists:users,id',
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $team = Team::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        // Sync team leads
        if (isset($validated['team_lead_ids'])) {
            $team->teamLeads()->sync($validated['team_lead_ids']);
        }

        // Sync team members
        if (isset($validated['user_ids'])) {
            $team->users()->sync($validated['user_ids']);
        }

        return redirect()->route('teams.index')
            ->with('success', 'Team created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team): View
    {
        $team->load(['teamLeads', 'users']);
        
        return view('admin.teams.show', [
            'team' => $team,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team): View
    {
        $team->load(['teamLeads', 'users']);

        // Get all users with team-lead role for team leads selection
        $teamLeads = User::whereHas('roles', function($query) {
            $query->where('name', 'team-lead');
        })->orderBy('name')->get();

        // Get all users for team members selection
        $users = User::orderBy('name')->get();

        return view('admin.teams.edit', [
            'team' => $team,
            'teamLeads' => $teamLeads,
            'users' => $users,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:teams,name,' . $team->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'team_lead_ids' => 'nullable|array',
            'team_lead_ids.*' => 'exists:users,id',
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $team->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        // Sync team leads
        if (isset($validated['team_lead_ids'])) {
            $team->teamLeads()->sync($validated['team_lead_ids']);
        } else {
            $team->teamLeads()->sync([]);
        }

        // Sync team members
        if (isset($validated['user_ids'])) {
            $team->users()->sync($validated['user_ids']);
        } else {
            $team->users()->sync([]);
        }

        return redirect()->route('teams.index')
            ->with('success', 'Team updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team): RedirectResponse
    {
        $team->delete();

        return redirect()->route('teams.index')
            ->with('success', 'Team deleted successfully.');
    }

    /**
     * Toggle team active status.
     */
    public function toggleStatus(Team $team): RedirectResponse
    {
        $team->update([
            'is_active' => !$team->is_active,
        ]);

        $status = $team->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Team {$status} successfully.");
    }
}
