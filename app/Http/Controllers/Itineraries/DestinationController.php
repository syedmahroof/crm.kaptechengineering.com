<?php

namespace App\Http\Controllers\Itineraries;

use App\Actions\Destinations\CreateDestination;
use App\Actions\Destinations\UpdateDestination;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Http\Requests\StoreDestinationRequest;
use App\Http\Requests\UpdateDestinationRequest;
use App\Models\Destination;
use App\Models\Itinerary;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DestinationController extends BaseDestinationController
{
    /**
     * Display a listing of destinations.
     * Can be accessed via /itineraries/{itinerary}/destinations or /itineraries/destinations
     */
    public function index(Request $request, Itinerary $itinerary = null)
    {
        // Check if user is authenticated
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        if ($itinerary) {
            $this->authorize('view', $itinerary);
            $destinations = $itinerary->destinations()
                ->with('country')
                ->get();
        } else {
            // For global destinations listing (from master menu)
            $this->authorize('viewAny', Destination::class);
            $destinations = Destination::with('country')
                ->latest()
                ->paginate(15);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'data' => $destinations
            ]);
        }

        // For web requests (Inertia)
        return Inertia::render('Itineraries/Destinations/Index', [
            'destinations' => $destinations,
            'filters' => $request->all(['search', 'country_id']),
            'can' => [
                'create' => $request->user()?->can('create', Destination::class),
            ]
        ]);
    }

    /**
     * Show the form for creating a new destination.
     */
    public function create(): Response
    {
        $countries = Country::all(['id', 'name']);
        
        return Inertia::render('Itineraries/Destinations/Create', [
            'countries' => $countries
        ]);
    }

    /**
     * Store a newly created destination for an itinerary.
     */
    public function store(Itinerary $itinerary, Request $request): JsonResponse
    {
        $this->authorize('update', $itinerary);
        
        $validated = $request->validate([
            'destination_id' => 'required|exists:destinations,id'
        ]);
        
        $itinerary->destinations()->syncWithoutDetaching([$validated['destination_id']]);
        
        return response()->json([
            'message' => 'Destination added to itinerary successfully',
            'destination' => $itinerary->destinations()->find($validated['destination_id'])
        ]);
    }

    /**
     * Display the specified destination.
     */
    public function show(Destination $destination): Response
    {
        $destination->load('country');
        
        return Inertia::render('Itineraries/Destinations/Show', [
            'destination' => $destination,
        ]);
    }

    /**
     * Show the form for editing the specified destination.
     */
    public function edit(Destination $destination): Response
    {
        $destination->load('country');
        
        return Inertia::render('Itineraries/Destinations/Edit', [
            'destination' => $destination,
        ]);
    }

    /**
     * Update the specified destination in storage.
     */
    public function update(
        UpdateDestinationRequest $request, 
        Destination $destination, 
        UpdateDestination $updateDestination
    ) {
        $updateDestination->execute($destination, $request->validated());

        return redirect()->route('itineraries.destinations.index')
            ->with('success', 'Destination updated successfully');
    }

    /**
     * Remove the specified destination from storage.
     */
    public function destroy(Destination $destination)
    {
        $destination->delete();

        return redirect()->route('itineraries.destinations.index')
            ->with('success', 'Destination deleted successfully');
    }

    /**
     * Remove the specified destination from the itinerary.
     */
    public function destroyItineraryDestination(Itinerary $itinerary, Destination $destination): JsonResponse
    {
        $this->authorize('update', $itinerary);
        
        $itinerary->destinations()->detach($destination->id);
        
        return response()->json([
            'message' => 'Destination removed from itinerary successfully'
        ]);
    }
}
