<?php

namespace App\Http\Controllers\AI;

use App\Http\Controllers\Controller;
use App\Models\Itinerary;
use App\Models\Country;
use App\Models\Destination;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class AIItineraryController extends Controller
{
    public function index()
    {
        $countries = Country::select(['id', 'name', 'iso_code', 'flag_image'])->orderBy('name')->get();
        $destinations = Destination::select(['id', 'name', 'country_id', 'images', 'slug', 'latitude', 'longitude'])->orderBy('name')->get();

        return Inertia::render('AI/ItineraryBuilder', [
            'countries' => $countries,
            'destinations' => $destinations,
        ]);
    }

    public function generateItinerary(Request $request)
    {
        try {
            $validated = $request->validate([
                'customer_name' => 'required|string|max:255',
                'customer_email' => 'nullable|email|max:255',
                'customer_phone' => 'nullable|string|max:20',
                'destination' => 'nullable|string|max:255',
                'country_id' => 'required|exists:countries,id',
                'days' => 'required|integer|min:1|max:30',
                'nights' => 'integer|min:0|max:29',
                'travel_style' => 'required|string|in:leisure,adventure,luxury,budget,family,romantic',
                'budget_range' => 'required|string|in:low,medium,high,luxury',
                'group_size' => 'integer|min:1|max:50',
                'special_requirements' => 'nullable|string|max:1000',
                'interests' => 'array',
                'interests.*' => 'string|max:50',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after:start_date',
            ]);

            // Get country and destination info
            $country = Country::find($validated['country_id']);
            if (!$country) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected country not found.',
                    'error' => 'Invalid country selection'
                ], 400);
            }

            $destination = $validated['destination'] ?: $country->name;

            // Prepare data for AI generation
            $aiPrompt = $this->buildAIPrompt($validated, $country, $destination);

            // Call MCP server for AI generation
            $itinerary = $this->callMCPForItinerary($aiPrompt, $validated);

            return response()->json([
                'success' => true,
                'itinerary' => $itinerary,
                'message' => 'Itinerary generated successfully!'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('AI Itinerary Validation Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Validation failed. Please check your input.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('AI Itinerary Generation Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate itinerary. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : 'An unexpected error occurred.'
            ], 500);
        }
    }

    public function saveItinerary(Request $request)
    {
        $validated = $request->validate([
            'itinerary_data' => 'required|array',
            'customer_data' => 'required|array',
            'customer_data.name' => 'required|string|max:255',
            'customer_data.email' => 'nullable|email|max:255',
            'customer_data.phone' => 'nullable|string|max:20',
        ]);

        try {
            $itineraryData = $validated['itinerary_data'];
            $customerData = $validated['customer_data'];

            // Create the itinerary
            $itinerary = Itinerary::create([
                'name' => $itineraryData['name'],
                'tagline' => $itineraryData['tagline'] ?? null,
                'description' => $itineraryData['description'] ?? null,
                'duration_days' => $itineraryData['duration_days'],
                'country_id' => $itineraryData['country_id'] ?? null,
                'status' => 'draft',
                'is_master' => false,
                'is_custom' => true,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
                'meta_title' => $itineraryData['meta_title'] ?? null,
                'meta_description' => $itineraryData['meta_description'] ?? null,
                'meta_keywords' => $itineraryData['meta_keywords'] ?? [],
                'inclusions' => $itineraryData['inclusions'] ?? [],
                'exclusions' => $itineraryData['exclusions'] ?? [],
                'terms_conditions' => $itineraryData['terms_conditions'] ?? null,
                'cancellation_policy' => $itineraryData['cancellation_policy'] ?? null,
            ]);

            // Create days and items
            if (isset($itineraryData['days']) && is_array($itineraryData['days'])) {
                foreach ($itineraryData['days'] as $dayData) {
                    $day = $itinerary->days()->create([
                        'day_number' => $dayData['day_number'],
                        'title' => $dayData['title'],
                        'description' => $dayData['description'] ?? null,
                    ]);

                    if (isset($dayData['items']) && is_array($dayData['items'])) {
                        foreach ($dayData['items'] as $itemData) {
                            $day->items()->create([
                                'title' => $itemData['title'],
                                'description' => $itemData['description'] ?? null,
                                'location' => $itemData['location'] ?? null,
                                'start_time' => $itemData['start_time'] ?? null,
                                'end_time' => $itemData['end_time'] ?? null,
                                'duration_minutes' => $itemData['duration_minutes'] ?? null,
                                'type' => $itemData['type'] ?? 'activity',
                                'order' => $itemData['order'] ?? 0,
                            ]);
                        }
                    }
                }
            }

            // Attach destinations if provided
            if (isset($itineraryData['destination_ids']) && is_array($itineraryData['destination_ids'])) {
                $destinationData = [];
                foreach ($itineraryData['destination_ids'] as $index => $destinationId) {
                    $destinationData[$destinationId] = [
                        'day_number' => $index + 1,
                        'order' => $index,
                    ];
                }
                $itinerary->destinations()->attach($destinationData);
            }

            return redirect()->route('itineraries.show', $itinerary)
                ->with('success', 'AI-generated itinerary saved successfully!');

        } catch (\Exception $e) {
            Log::error('AI Itinerary Save Error: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to save itinerary. Please try again.');
        }
    }

    private function buildAIPrompt($data, $country, $destination)
    {
        $prompt = "Create a detailed travel itinerary with the following specifications:\n\n";
        $prompt .= "Customer: {$data['customer_name']}\n";
        $prompt .= "Destination: {$destination}, {$country->name}\n";
        $prompt .= "Duration: {$data['days']} days, {$data['nights']} nights\n";
        $prompt .= "Travel Style: {$data['travel_style']}\n";
        $prompt .= "Budget Range: {$data['budget_range']}\n";
        $prompt .= "Group Size: {$data['group_size']} people\n";
        
        if (!empty($data['interests'])) {
            $prompt .= "Interests: " . implode(', ', $data['interests']) . "\n";
        }
        
        if (!empty($data['special_requirements'])) {
            $prompt .= "Special Requirements: {$data['special_requirements']}\n";
        }

        $prompt .= "\nPlease create a comprehensive itinerary including:\n";
        $prompt .= "- Day-by-day activities with specific times\n";
        $prompt .= "- Restaurant recommendations\n";
        $prompt .= "- Hotel suggestions\n";
        $prompt .= "- Transportation details\n";
        $prompt .= "- Inclusions and exclusions\n";
        $prompt .= "- Terms and conditions\n";
        $prompt .= "- Cancellation policy\n";

        return $prompt;
    }

    private function callMCPForItinerary($prompt, $data)
    {
        try {
            // For now, we'll create a mock itinerary structure
            // In production, this would call your MCP server
            $itinerary = [
                'name' => "AI-Generated {$data['travel_style']} Trip to {$data['destination']}",
                'tagline' => "Personalized {$data['travel_style']} experience in {$data['destination']}",
                'description' => "An AI-crafted itinerary designed specifically for {$data['customer_name']} featuring {$data['travel_style']} activities and experiences.",
                'duration_days' => $data['days'],
                'country_id' => $data['country_id'],
                'destination' => $data['destination'],
                'days' => $this->generateMockDays($data),
                'inclusions' => [
                    'Hotel accommodation',
                    'Daily breakfast',
                    'Airport transfers',
                    'Local transportation',
                    'Guided tours',
                    'Entrance fees to attractions'
                ],
                'exclusions' => [
                    'International flights',
                    'Personal expenses',
                    'Travel insurance',
                    'Visa fees',
                    'Meals not specified'
                ],
                'terms_conditions' => 'Standard terms and conditions apply. Please review all details before booking.',
                'cancellation_policy' => 'Free cancellation up to 24 hours before travel date.',
                'meta_title' => "AI-Generated {$data['travel_style']} Itinerary for {$data['destination']}",
                'meta_description' => "Personalized travel itinerary created by AI for {$data['customer_name']}",
                'meta_keywords' => array_merge([$data['travel_style'], $data['destination']], $data['interests'] ?? [])
            ];

            return $itinerary;

        } catch (\Exception $e) {
            Log::error('MCP Itinerary Generation Error: ' . $e->getMessage());
            throw new \Exception('Failed to generate itinerary content: ' . $e->getMessage());
        }
    }

    private function generateMockDays($data)
    {
        $days = [];
        $activities = $this->getActivitiesByStyle($data['travel_style']);
        
        for ($i = 1; $i <= $data['days']; $i++) {
            $dayActivities = array_slice($activities, ($i - 1) * 3, 3);
            
            $day = [
                'day_number' => $i,
                'title' => "Day {$i}: Exploring {$data['destination']}",
                'description' => "A full day of {$data['travel_style']} activities in {$data['destination']}",
                'items' => []
            ];
            
            foreach ($dayActivities as $index => $activity) {
                $day['items'][] = [
                    'title' => $activity['title'],
                    'description' => $activity['description'],
                    'start_time' => $activity['time'],
                    'duration' => $activity['duration'],
                    'type' => $activity['type']
                ];
            }
            
            $days[] = $day;
        }
        
        return $days;
    }

    private function getActivitiesByStyle($style)
    {
        $activities = [
            'leisure' => [
                ['title' => 'Morning Coffee & City Walk', 'description' => 'Start your day with a leisurely coffee and explore the city center', 'time' => '09:00', 'duration' => '2 hours', 'type' => 'sightseeing'],
                ['title' => 'Lunch at Local Restaurant', 'description' => 'Enjoy authentic local cuisine', 'time' => '12:00', 'duration' => '1.5 hours', 'type' => 'dining'],
                ['title' => 'Relaxing Spa Treatment', 'description' => 'Unwind with a traditional spa experience', 'time' => '15:00', 'duration' => '2 hours', 'type' => 'wellness'],
                ['title' => 'Evening Stroll', 'description' => 'Take a peaceful walk through the city', 'time' => '18:00', 'duration' => '1 hour', 'type' => 'sightseeing'],
                ['title' => 'Dinner at Rooftop Restaurant', 'description' => 'Fine dining with city views', 'time' => '19:30', 'duration' => '2 hours', 'type' => 'dining'],
                ['title' => 'Sunset Photography', 'description' => 'Capture beautiful sunset moments', 'time' => '17:30', 'duration' => '1 hour', 'type' => 'photography']
            ],
            'adventure' => [
                ['title' => 'Early Morning Hike', 'description' => 'Challenging mountain trail with scenic views', 'time' => '07:00', 'duration' => '4 hours', 'type' => 'hiking'],
                ['title' => 'Rock Climbing Session', 'description' => 'Professional guided rock climbing', 'time' => '12:00', 'duration' => '3 hours', 'type' => 'climbing'],
                ['title' => 'White Water Rafting', 'description' => 'Exciting river rafting adventure', 'time' => '15:00', 'duration' => '3 hours', 'type' => 'water_sports'],
                ['title' => 'Zip-lining Experience', 'description' => 'Thrilling zip-line through the forest', 'time' => '10:00', 'duration' => '2 hours', 'type' => 'adventure'],
                ['title' => 'Mountain Biking', 'description' => 'Challenging mountain bike trails', 'time' => '14:00', 'duration' => '3 hours', 'type' => 'cycling'],
                ['title' => 'Campfire & Stargazing', 'description' => 'Evening campfire with stargazing', 'time' => '20:00', 'duration' => '2 hours', 'type' => 'nature']
            ],
            'luxury' => [
                ['title' => 'Private City Tour', 'description' => 'Exclusive guided tour with private transport', 'time' => '10:00', 'duration' => '4 hours', 'type' => 'sightseeing'],
                ['title' => 'Michelin Star Lunch', 'description' => 'Fine dining at award-winning restaurant', 'time' => '13:00', 'duration' => '2 hours', 'type' => 'dining'],
                ['title' => 'Private Wine Tasting', 'description' => 'Exclusive wine tasting with sommelier', 'time' => '16:00', 'duration' => '2 hours', 'type' => 'culinary'],
                ['title' => 'Luxury Spa Experience', 'description' => 'Premium spa treatment with personal therapist', 'time' => '18:00', 'duration' => '3 hours', 'type' => 'wellness'],
                ['title' => 'Private Helicopter Tour', 'description' => 'Aerial views of the city and landmarks', 'time' => '11:00', 'duration' => '1 hour', 'type' => 'sightseeing'],
                ['title' => 'Gourmet Dinner Cruise', 'description' => 'Luxury dinner cruise with live entertainment', 'time' => '19:30', 'duration' => '3 hours', 'type' => 'dining']
            ],
            'budget' => [
                ['title' => 'Free Walking Tour', 'description' => 'Explore the city with local guides', 'time' => '10:00', 'duration' => '2 hours', 'type' => 'sightseeing'],
                ['title' => 'Local Market Visit', 'description' => 'Experience local culture and buy souvenirs', 'time' => '12:00', 'duration' => '1.5 hours', 'type' => 'shopping'],
                ['title' => 'Street Food Adventure', 'description' => 'Taste authentic local street food', 'time' => '13:30', 'duration' => '1 hour', 'type' => 'dining'],
                ['title' => 'Free Museum Day', 'description' => 'Visit museums with free admission', 'time' => '15:00', 'duration' => '2 hours', 'type' => 'culture'],
                ['title' => 'Public Park Relaxation', 'description' => 'Relax in beautiful public gardens', 'time' => '17:00', 'duration' => '1 hour', 'type' => 'nature'],
                ['title' => 'Local Pub Experience', 'description' => 'Enjoy drinks at a local pub', 'time' => '19:00', 'duration' => '2 hours', 'type' => 'nightlife']
            ],
            'family' => [
                ['title' => 'Family-Friendly Museum', 'description' => 'Interactive museum perfect for all ages', 'time' => '10:00', 'duration' => '2 hours', 'type' => 'culture'],
                ['title' => 'Zoo or Aquarium Visit', 'description' => 'Fun animal encounters for the whole family', 'time' => '12:00', 'duration' => '3 hours', 'type' => 'nature'],
                ['title' => 'Family Picnic', 'description' => 'Relaxing picnic in a beautiful park', 'time' => '15:00', 'duration' => '1.5 hours', 'type' => 'nature'],
                ['title' => 'Amusement Park', 'description' => 'Thrilling rides and games for all ages', 'time' => '16:30', 'duration' => '3 hours', 'type' => 'entertainment'],
                ['title' => 'Family Cooking Class', 'description' => 'Learn to cook local dishes together', 'time' => '11:00', 'duration' => '2 hours', 'type' => 'culinary'],
                ['title' => 'Evening Family Show', 'description' => 'Entertaining show suitable for families', 'time' => '19:00', 'duration' => '2 hours', 'type' => 'entertainment']
            ],
            'romantic' => [
                ['title' => 'Sunrise Breakfast', 'description' => 'Romantic breakfast with city views', 'time' => '07:00', 'duration' => '1.5 hours', 'type' => 'dining'],
                ['title' => 'Couples Spa Treatment', 'description' => 'Relaxing spa experience for two', 'time' => '10:00', 'duration' => '2 hours', 'type' => 'wellness'],
                ['title' => 'Romantic Garden Walk', 'description' => 'Stroll through beautiful botanical gardens', 'time' => '14:00', 'duration' => '1.5 hours', 'type' => 'nature'],
                ['title' => 'Wine Tasting for Two', 'description' => 'Intimate wine tasting experience', 'time' => '16:00', 'duration' => '1.5 hours', 'type' => 'culinary'],
                ['title' => 'Sunset Photography Session', 'description' => 'Capture romantic moments together', 'time' => '18:00', 'duration' => '1 hour', 'type' => 'photography'],
                ['title' => 'Romantic Dinner Cruise', 'description' => 'Intimate dinner with beautiful views', 'time' => '19:30', 'duration' => '3 hours', 'type' => 'dining']
            ]
        ];
        
        return $activities[$style] ?? $activities['leisure'];
    }

}
