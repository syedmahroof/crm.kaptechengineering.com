<?php

namespace App\Http\Controllers;

use App\Models\Itinerary;
use App\Models\Lead;
use Illuminate\Http\Request;

class MasterItinerariesController extends Controller
{
    public function index()
    {
        $masterItineraries = Itinerary::master()
            ->with(['country', 'destinations', 'days.items'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('admin.itineraries.master-index', [
            'masterItineraries' => $masterItineraries,
        ]);
    }

    public function show(Itinerary $itinerary)
    {
        $itinerary->load(['country', 'destinations', 'days.items', 'user']);

        return view('admin.itineraries.master-show', [
            'itinerary' => $itinerary,
        ]);
    }

    public function createCustom(Request $request, Itinerary $masterItinerary)
    {
        $leadId = $request->get('lead_id');
        $lead = null;
        
        if ($leadId) {
            $lead = Lead::find($leadId);
        }

        $customItinerary = $masterItinerary->createCustomFromMaster($masterItinerary, $leadId);

        return redirect()->route('itineraries.builder.edit', $customItinerary)
            ->with('success', 'Custom itinerary created from master template. You can now customize it.');
    }

    public function markAsMaster(Itinerary $itinerary)
    {
        $itinerary->update([
            'is_master' => true,
            'status' => 'published',
        ]);

        return redirect()->back()
            ->with('success', 'Itinerary marked as master template.');
    }

    public function unmarkAsMaster(Itinerary $itinerary)
    {
        $itinerary->update([
            'is_master' => false,
        ]);

        return redirect()->back()
            ->with('success', 'Itinerary unmarked as master template.');
    }
}
