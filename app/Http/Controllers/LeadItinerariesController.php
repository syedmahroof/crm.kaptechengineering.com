<?php

namespace App\Http\Controllers;

use App\Models\Itinerary;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadItinerariesController extends Controller
{
    public function create(Request $request)
    {
        $leadId = $request->get('lead_id');
        $lead = null;
        
        if ($leadId) {
            $lead = Lead::with(['business_type'])->find($leadId);
        }

        return view('admin.lead-itineraries.create', [
            'lead' => $lead,
            'countries' => \App\Models\Country::select(['id', 'name', 'iso_code', 'flag_image'])->orderBy('name')->get(),
            'destinations' => \App\Models\Destination::select(['id', 'name', 'country_id', 'images', 'slug', 'latitude', 'longitude'])->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'duration_days' => 'required|integer|min:1|max:365',
            'country_id' => 'required|exists:countries,id',
            'destination_ids' => 'array',
            'destination_ids.*' => 'exists:destinations,id',
            'terms_conditions' => 'nullable|string',
            'cancellation_policy' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'array',
            'inclusions' => 'array',
            'exclusions' => 'array',
            'days' => 'array',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'draft';

        // Extract destination_ids before creating (it's not a fillable field)
        $destinationIds = $validated['destination_ids'] ?? [];
        unset($validated['destination_ids']);

        $itinerary = Itinerary::create($validated);

        // Attach destinations if provided
        // Since we don't have days yet, assign all destinations to day 1 by default
        // They can be reassigned later when days are created in the builder
        if (!empty($destinationIds)) {
            $destinationsData = [];
            foreach ($destinationIds as $index => $destinationId) {
                $destinationsData[$destinationId] = [
                    'day_number' => 1, // Default to day 1, can be updated later
                    'order' => $index,
                ];
            }
            $itinerary->destinations()->attach($destinationsData);
        }

        // Create itinerary days if provided
        if (!empty($validated['days'])) {
            foreach ($validated['days'] as $dayData) {
                $day = $itinerary->days()->create([
                    'day_number' => $dayData['day_number'] ?? 1,
                    'title' => $dayData['title'] ?? 'Day ' . ($dayData['day_number'] ?? 1),
                    'description' => $dayData['description'] ?? '',
                ]);

                // Create itinerary items if provided
                if (!empty($dayData['items'])) {
                    foreach ($dayData['items'] as $itemData) {
                        $day->items()->create([
                            'title' => $itemData['title'] ?? '',
                            'description' => $itemData['description'] ?? '',
                            'time' => $itemData['time'] ?? '',
                            'location' => $itemData['location'] ?? '',
                            'type' => $itemData['type'] ?? 'activity',
                        ]);
                    }
                }
            }
        }

        return redirect()->route('itineraries.builder.edit', $itinerary)
            ->with('success', 'Itinerary created successfully. You can now continue building it.');
    }

    public function show(Itinerary $itinerary)
    {
        $itinerary->load(['lead', 'country', 'destinations', 'days.items', 'creator', 'updater']);

        return Inertia::render('LeadItineraries/Show', [
            'itinerary' => $itinerary,
        ]);
    }
}
