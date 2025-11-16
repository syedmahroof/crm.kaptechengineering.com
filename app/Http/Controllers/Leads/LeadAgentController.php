<?php

namespace App\Http\Controllers\Leads;

use App\Http\Controllers\Controller;
use App\Models\LeadAgent;
use App\Models\User;
use Illuminate\Http\Request;

class LeadAgentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Remove the authorizeResource middleware as it's causing 403 errors
        // $this->authorizeResource(LeadAgent::class, 'agent');
    }

    public function index()
    {
        $this->authorize('viewAny', LeadAgent::class);
        
        $agents = LeadAgent::with(['user'])
            ->withCount(['leads', 'leads as converted_leads_count' => function($query) {
                $query->where('status', 'converted');
            }])
            ->get();

        $availableUsers = User::whereDoesntHave('leadAgent')
            ->whereHas('roles', function($query) {
                $query->where('name', 'agent');
            })
            ->select(['id', 'name', 'email'])
            ->get();

        return view('admin.lead-agents.index', [
            'agents' => $agents,
            'availableUsers' => $availableUsers,
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', LeadAgent::class);
        
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id|unique:lead_agents,user_id',
        ]);

        $user = User::findOrFail($validated['user_id']);
        
        // Ensure the user has the agent role
        if (!$user->hasRole('agent')) {
            $user->assignRole('agent');
        }

        LeadAgent::create([
            'user_id' => $user->id,
            'is_active' => true,
        ]);

        return redirect()->route('lead-agents.index')
            ->with('success', 'Lead agent added successfully.');
    }

    public function show(LeadAgent $agent)
    {
        $this->authorize('view', $agent);
        
        $agent->load(['user', 'leads' => function($query) {
            $query->orderBy('created_at', 'desc')->limit(10);
        }]);

        $stats = [
            'total_leads' => $agent->leads()->count(),
            'converted_leads' => $agent->leads()->where('status', 'converted')->count(),
            'active_leads' => $agent->leads()->whereNotIn('status', ['converted', 'lost'])->count(),
            'conversion_rate' => $agent->leads_count > 0 
                ? round(($agent->leads()->where('status', 'converted')->count() / $agent->leads_count) * 100, 2)
                : 0,
        ];

        return view('admin.lead-agents.show', [
            'agent' => $agent,
            'stats' => $stats,
            'recentLeads' => $agent->leads,
        ]);
    }

    public function toggleStatus(LeadAgent $agent)
    {
        $this->authorize('update', $agent);
        
        $agent->update([
            'is_active' => !$agent->is_active,
        ]);

        $status = $agent->is_active ? 'activated' : 'deactivated';
        
        return back()->with('success', "Agent {$status} successfully.");
    }

    public function destroy(LeadAgent $agent)
    {
        $this->authorize('delete', $agent);
        
        if ($agent->leads()->exists()) {
            // Reassign leads to another active agent or set to null
            $newAgent = LeadAgent::where('id', '!=', $agent->id)
                ->where('is_active', true)
                ->first();

            if ($newAgent) {
                $agent->leads()->update(['lead_agent_id' => $newAgent->id]);
            } else {
                $agent->leads()->update(['lead_agent_id' => null]);
            }
        }

        $agent->delete();

        return redirect()->route('lead-agents.index')
            ->with('success', 'Lead agent removed successfully.');
    }
}
