<?php

namespace App\Http\Controllers\Itineraries;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Itinerary;
use App\Models\Destination;
use App\Models\Attraction;
use Illuminate\Support\Facades\Auth;

class ItineraryController extends Controller
{
    public function index()
    {
        $itineraries = Itinerary::latest()
            ->paginate(10);

        return view('admin.itineraries.index', [
            'itineraries' => $itineraries
        ]);
    }
    
    public function create()
    {
        return redirect()->route('itineraries.builder.create');
    }

    public function show(Itinerary $itinerary)
    {
        // Eager load relationships to avoid N+1 queries
        $itinerary->load([
            'destinations',
            'attractions',
            'user:id,name,email',
            'country',
            'destination',
            'lead',
            'days.items'
        ]);

        return view('admin.itineraries.show', [
            'itinerary' => $itinerary
        ]);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_public' => 'boolean',
            'status' => 'required|in:draft,published,archived',
            'destinations' => 'required|array|min:1',
            'destinations.*.id' => 'required|exists:destinations,id',
            'destinations.*.day_number' => 'required|integer|min:1',
            'destinations.*.notes' => 'nullable|string',
            'attractions' => 'array',
            'attractions.*.id' => 'required_with:attractions|exists:attractions,id',
            'attractions.*.day_number' => 'required_with:attractions|integer|min:1',
            'attractions.*.start_time' => 'nullable|date_format:H:i',
            'attractions.*.end_time' => 'nullable|date_format:H:i|after:attractions.*.start_time',
            'attractions.*.notes' => 'nullable|string',
        ]);

        try {
            $itinerary = new Itinerary([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'is_public' => $validated['is_public'] ?? false,
                'status' => $validated['status'],
                'user_id' => Auth::id(),
            ]);

            $itinerary->save();

            // Attach destinations with pivot data
            $destinationsData = collect($validated['destinations'])->mapWithKeys(function ($destination) {
                return [
                    $destination['id'] => [
                        'day_number' => $destination['day_number'],
                        'notes' => $destination['notes'] ?? null,
                        'order' => $destination['order'] ?? 0,
                    ]
                ];
            })->toArray();

            $itinerary->destinations()->attach($destinationsData);

            // Attach attractions with pivot data if provided
            if (!empty($validated['attractions'])) {
                $attractionsData = collect($validated['attractions'])->mapWithKeys(function ($attraction) {
                    return [
                        $attraction['id'] => [
                            'day_number' => $attraction['day_number'],
                            'start_time' => $attraction['start_time'] ?? null,
                            'end_time' => $attraction['end_time'] ?? null,
                            'notes' => $attraction['notes'] ?? null,
                            'order' => $attraction['order'] ?? 0,
                        ]
                    ];
                })->toArray();

                $itinerary->attractions()->attach($attractionsData);
            }

            return redirect()->route('itineraries.index')
                ->with('success', 'Itinerary created successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create itinerary: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(Itinerary $itinerary)
    {
        return redirect()->route('itineraries.builder.edit', $itinerary);
    }

    public function export()
    {
        $itineraries = Itinerary::all();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=itineraries_' . now()->format('Y-m-d') . '.csv',
        ];

        $callback = function() use ($itineraries) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, ['ID', 'Name', 'Description', 'Start Date', 'End Date', 'Status', 'Created At']);
            
            // Add data rows
            foreach ($itineraries as $itinerary) {
                fputcsv($itinerary, [
                    $itinerary->id,
                    $itinerary->name,
                    $itinerary->description,
                    $itinerary->start_date,
                    $itinerary->end_date,
                    $itinerary->status,
                    $itinerary->created_at,
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function update(Request $request, Itinerary $itinerary)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:pending,completed',
        ]);

        $itinerary->update($validated);

        return redirect()->route('itineraries.index')
            ->with('success', 'itineraries updated successfully.');
    }

    public function destroy(Itinerary $itinerary)
    {
        $itinerary->delete();

        return redirect()->route('itineraries.index')
            ->with('success', 'itineraries deleted successfully.');
    }

    /**
     * Export destinations to CSV
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportDestinations()
    {
        $destinations = Destination::with(['country', 'state'])->get();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=destinations_' . now()->format('Y-m-d') . '.csv',
        ];

        $callback = function() use ($destinations) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'ID', 
                'Name', 
                'Slug', 
                'Description', 
                'Country', 
                'State', 
                'Location', 
                'Latitude', 
                'Longitude',
                'Is Featured',
                'Is Active',
                'Created At'
            ]);
            
            // Add data rows
            foreach ($destinations as $destination) {
                fputcsv($file, [
                    $destination->id,
                    $destination->name,
                    $destination->slug,
                    $destination->short_description,
                    $destination->country ? $destination->country->name : '',
                    $destination->state ? $destination->state->name : '',
                    $destination->location,
                    $destination->latitude,
                    $destination->longitude,
                    $destination->is_featured ? 'Yes' : 'No',
                    $destination->is_active ? 'Yes' : 'No',
                    $destination->created_at,
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export attractions to CSV
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportAttractions()
    {
        $attractions = Attraction::with(['destination', 'attractionType'])->get();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=attractions_' . now()->format('Y-m-d') . '.csv',
        ];

        $callback = function() use ($attractions) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'ID', 
                'Name', 
                'Type',
                'Destination',
                'Description', 
                'Location', 
                'Latitude', 
                'Longitude',
                'Entry Fee',
                'Opening Hours',
                'Is Active',
                'Created At'
            ]);
            
            // Add data rows
            foreach ($attractions as $attraction) {
                fputcsv($file, [
                    $attraction->id,
                    $attraction->name,
                    $attraction->attractionType ? $attraction->attractionType->name : '',
                    $attraction->destination ? $attraction->destination->name : '',
                    $attraction->short_description,
                    $attraction->location,
                    $attraction->latitude,
                    $attraction->longitude,
                    $attraction->entry_fee,
                    $attraction->opening_hours,
                    $attraction->is_active ? 'Yes' : 'No',
                    $attraction->created_at,
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export hotels to CSV
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportHotels()
    {
        $hotels = \App\Models\Hotel::with(['destination'])->get();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=hotels_' . now()->format('Y-m-d') . '.csv',
        ];

        $callback = function() use ($hotels) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'ID', 
                'Name', 
                'Destination',
                'Description', 
                'Location', 
                'Star Rating',
                'Amenities',
                'Is Active',
                'Created At'
            ]);
            
            // Add data rows
            foreach ($hotels as $hotel) {
                fputcsv($file, [
                    $hotel->id,
                    $hotel->name,
                    $hotel->destination ? $hotel->destination->name : '',
                    $hotel->short_description,
                    $hotel->location,
                    $hotel->star_rating,
                    is_array($hotel->amenities) ? implode(', ', $hotel->amenities) : $hotel->amenities,
                    $hotel->is_active ? 'Yes' : 'No',
                    $hotel->created_at,
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export transportation to CSV
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportTransportation()
    {
        $transportations = \App\Models\Transportation::all();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=transportation_' . now()->format('Y-m-d') . '.csv',
        ];

        $callback = function() use ($transportations) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'ID', 
                'Type', 
                'Name',
                'Description', 
                'Capacity',
                'Is Active',
                'Created At'
            ]);
            
            // Add data rows
            foreach ($transportations as $transport) {
                fputcsv($file, [
                    $transport->id,
                    $transport->type,
                    $transport->name,
                    $transport->description,
                    $transport->capacity,
                    $transport->is_active ? 'Yes' : 'No',
                    $transport->created_at,
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
