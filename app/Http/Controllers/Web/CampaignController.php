<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 15);
        $search = $request->input('search');
        
        $campaigns = Campaign::query()
            ->with(['creator', 'leads'])
            ->withCount('leads')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.campaigns.index', [
            'campaigns' => $campaigns,
            'filters' => [
                'search' => $search,
                'per_page' => $perPage,
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.campaigns.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(Campaign::rules());

        $campaign = Campaign::create([
            ...$validated,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('campaigns.index')
            ->with('success', 'Campaign created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign)
    {
        $campaign->load(['creator', 'leads', 'contacts']);
        $campaign->loadCount(['leads', 'contacts']);
        
        return view('admin.campaigns.show', [
            'campaign' => $campaign,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign)
    {
        return view('admin.campaigns.edit', [
            'campaign' => $campaign,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Campaign $campaign)
    {
        $validated = $request->validate(Campaign::rules($campaign->id));

        $campaign->update($validated);

        return redirect()->route('campaigns.index')
            ->with('success', 'Campaign updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign)
    {
        // Check if the campaign can be deleted (add any business logic here)
        if ($campaign->status === Campaign::STATUS_ACTIVE) {
            return back()->with('error', 'Cannot delete an active campaign. Please pause or cancel it first.');
        }

        $campaign->delete();

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Campaign deleted successfully.']);
        }

        return redirect()->route('campaigns.index')
            ->with('success', 'Campaign deleted successfully.');
    }

    /**
     * Delete a campaign contact.
     */
    public function deleteContact(Campaign $campaign, CampaignContact $contact)
    {
        // Verify the contact belongs to this campaign
        if ($contact->campaign_id !== $campaign->id) {
            return back()->with('error', 'Contact not found for this campaign.');
        }

        $contact->delete();

        return back()->with('success', 'Contact deleted successfully.');
    }

    /**
     * Select a campaign contact as winner.
     */
    public function selectWinner(Campaign $campaign, CampaignContact $contact)
    {
        // Verify the contact belongs to this campaign
        if ($contact->campaign_id !== $campaign->id) {
            return back()->with('error', 'Contact not found for this campaign.');
        }

        // First, remove winner status from all other contacts in this campaign
        CampaignContact::where('campaign_id', $campaign->id)
            ->where('id', '!=', $contact->id)
            ->update([
                'is_winner' => false,
                'winner_selected_at' => null,
                'winner_notes' => null
            ]);

        // Set this contact as winner
        $contact->update([
            'is_winner' => true,
            'winner_selected_at' => now(),
            'winner_notes' => 'Selected as winner on ' . now()->format('M d, Y H:i')
        ]);

        return back()->with('success', "{$contact->name} has been selected as the winner!");
    }
}
