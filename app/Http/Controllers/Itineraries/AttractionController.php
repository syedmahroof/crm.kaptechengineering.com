<?php

namespace App\Http\Controllers\Itineraries;

use App\Actions\Attractions\CreateAttraction;
use App\Actions\Attractions\UpdateAttraction;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttractionRequest;
use App\Http\Requests\UpdateAttractionRequest;
use App\Models\Attraction;
use App\Models\Destination;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response;

class AttractionController extends BaseAttractionController
{
    /**
     * Display a listing of attractions.
     */
    public function index(): Response
    {
        $attractions = Attraction::with(['destination'])
            ->latest()
            ->paginate(10);

        return Inertia::render('Admin/Attractions/Index', [
            'attractions' => $attractions,
        ]);
    }

    /**
     * Show the form for creating a new attraction.
     */
    public function create(): Response
    {
        $destinations = Destination::active()->get(['id', 'name']);
        
        return Inertia::render('Admin/Attractions/Create', [
            'destinations' => $destinations,
        ]);
    }

    /**
     * Store a newly created attraction in storage.
     */
    public function store(
        StoreAttractionRequest $request, 
        CreateAttraction $createAttraction
    ): JsonResponse {
        $attraction = $createAttraction->execute($request->validated());

        return response()->json([
            'message' => 'Attraction created successfully',
            'data' => $attraction,
            'redirect' => route('itineraries.attractions.index'),
        ], 201);
    }

    /**
     * Display the specified attraction.
     */
    public function show(Attraction $attraction): Response
    {
        $attraction->load('destination');
        
        return Inertia::render('Admin/Attractions/Show', [
            'attraction' => $attraction,
        ]);
    }

    /**
     * Show the form for editing the specified attraction.
     */
    public function edit(Attraction $attraction): Response
    {
        $attraction->load('destination');
        $destinations = Destination::active()->get(['id', 'name']);
        
        return Inertia::render('Admin/Attractions/Edit', [
            'attraction' => $attraction,
            'destinations' => $destinations,
        ]);
    }

    /**
     * Update the specified attraction in storage.
     */
    public function update(
        UpdateAttractionRequest $request, 
        Attraction $attraction, 
        UpdateAttraction $updateAttraction
    ): JsonResponse {
        $updatedAttraction = $updateAttraction->execute($attraction, $request->validated());

        return response()->json([
            'message' => 'Attraction updated successfully',
            'data' => $updatedAttraction,
            'redirect' => route('itineraries.attractions.index'),
        ]);
    }

    /**
     * Remove the specified attraction from storage.
     */
    public function destroy(Attraction $attraction): JsonResponse
    {
        $attraction->delete();

        return response()->json([
            'message' => 'Attraction deleted successfully',
            'redirect' => route('itineraries.attractions.index'),
        ]);
    }
}
