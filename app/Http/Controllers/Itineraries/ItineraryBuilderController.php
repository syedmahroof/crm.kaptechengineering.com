<?php

namespace App\Http\Controllers\Itineraries;

use App\Http\Controllers\Controller;

use App\Models\Itinerary;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ItineraryBuilderController extends Controller
{
    public function create(Request $request)
    {
        $itinerary = $request->user()->itineraries()->create([
            'status' => 'draft',
            'name' => 'New Itinerary',
        ]);

        return redirect()->route('itineraries.builder.edit', $itinerary);
    }

    public function edit(Itinerary $itinerary, Request $request)
    {
        $this->authorize('update', $itinerary);
        
        // Get leads for step 1
        $leads = \App\Models\Lead::select(['id', 'name', 'email'])->orderBy('name')->get();
        
        // Get master itineraries for template import
        $masterItineraries = \App\Models\Itinerary::master()
            ->with(['country', 'destination'])
            ->orderBy('name')
            ->get();
        
        $currentStep = $request->get('step', $this->getCurrentStep($itinerary));
        
        $itinerary->load([
            'country',
            'destination',
            'lead',
            'days.items'
        ]);
        
        // Ensure all attributes are available (handle null values)
        $itinerary = $itinerary->fresh();
        
        // Reload relationships after fresh() since it discards eager-loaded relationships
        $itinerary->load([
            'country',
            'destination',
            'lead',
            'days.items'
        ]);
        
        return view('admin.itineraries.builder.index', [
            'itinerary' => $itinerary,
            'countries' => \App\Models\Country::select(['id', 'name', 'iso_code', 'flag_image'])->orderBy('name')->get(),
            'destinations' => \App\Models\Destination::select(['id', 'name', 'country_id', 'images', 'slug', 'latitude', 'longitude'])->orderBy('name')->get(),
            'leads' => $leads,
            'masterItineraries' => $masterItineraries,
            'currentStep' => $currentStep,
            'completedSteps' => $itinerary->completed_steps ?? [],
        ]);
    }

    public function store(Request $request)
    {
        $itinerary = $request->user()->itineraries()->create([
            'status' => 'draft',
        ]);

        return redirect()->route('itineraries.builder.edit', $itinerary);
    }

    public function update(Itinerary $itinerary, Request $request)
    {
        $this->authorize('update', $itinerary);
        
        $step = $request->input('step', 1);
        
        // Step 6 is preview/publish - no update needed, just redirect
        if ($step == 6) {
            return redirect()
                ->route('itineraries.builder.edit', ['itinerary' => $itinerary->id, 'step' => 6])
                ->with('info', 'Use the publish buttons to save or publish the itinerary');
        }
        
        $method = 'updateStep' . $step;
        
        if (method_exists($this, $method)) {
            try {
                $this->$method($itinerary, $request);
                
            // Reload itinerary with relationships
            $itinerary->refresh();
            $itinerary->load(['country', 'destination', 'lead', 'days.items']);
            
            // Calculate next step
            $nextStep = min($step + 1, 6);
            
            // Redirect back to edit page with next step
            return redirect()->route('itineraries.builder.edit', ['itinerary' => $itinerary->id, 'step' => $nextStep])
                ->with('success', 'Step ' . $step . ' saved successfully');
            } catch (\Illuminate\Validation\ValidationException $e) {
                return back()->withErrors($e->errors());
            } catch (\Exception $e) {
                return back()->with('error', 'Failed to save step: ' . $e->getMessage());
            }
        }
        
        return redirect()->route('itineraries.builder.edit', ['itinerary' => $itinerary->id, 'step' => 1])
            ->with('error', 'Invalid step');
    }

    protected function updateStep1(Itinerary $itinerary, Request $request)
    {
        // Check if this is a master itinerary from the request
        $isMaster = $request->boolean('is_master');
        
        // Lead ID is optional for master itineraries
        $leadValidation = $isMaster 
            ? ['nullable', 'exists:leads,id']
            : ['required', 'exists:leads,id'];
        
        // Date validation - optional for master itineraries
        $startDateValidation = $isMaster 
            ? ['nullable', 'date']
            : ['required', 'date'];
        
        // End date validation - if master, only validate if start_date is provided
        $endDateValidation = $isMaster 
            ? ['nullable', 'date', $request->filled('start_date') ? 'after_or_equal:start_date' : '']
            : ['required', 'date', 'after_or_equal:start_date'];
        
        // Remove empty validation rules
        $endDateValidation = array_filter($endDateValidation);
        
        $data = $request->validate([
            'is_master' => ['nullable', 'boolean'],
            'lead_id' => $leadValidation,
            'name' => ['required', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'duration_days' => ['required', 'integer', 'min:1', 'max:365'],
            'start_date' => $startDateValidation,
            'end_date' => $endDateValidation,
            'country_id' => ['required', 'exists:countries,id'],
            'destination_id' => ['required', 'exists:destinations,id,country_id,' . $request->country_id],
            'adult_count' => ['nullable', 'integer', 'min:0'],
            'child_count' => ['nullable', 'integer', 'min:0'],
            'infant_count' => ['nullable', 'integer', 'min:0'],
            'hotel_category' => ['nullable', 'string', 'max:255'],
            'cover_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
        ]);

        // Convert checkbox value to boolean
        $data['is_master'] = $isMaster;
        
        // If master itinerary, ensure lead_id is null
        if ($isMaster) {
            $data['lead_id'] = null;
        }

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('itineraries/cover', 'public');
        }

        $itinerary->update($data);
        $itinerary->markStepAsCompleted(1);
    }

    protected function updateStep2(Itinerary $itinerary, Request $request)
    {
        $data = $request->validate([
            'days' => ['required', 'array', 'min:1', 'max:' . $itinerary->duration_days],
            'days.*.day_number' => ['required', 'integer', 'min:1', 'max:' . $itinerary->duration_days],
            'days.*.title' => ['required', 'string', 'max:255'],
            'days.*.description' => ['nullable', 'string'],
            'days.*.meals' => ['nullable', 'array'],
            'days.*.meals.*' => ['in:breakfast,lunch,dinner'],
            'days.*.items' => ['required', 'array', 'min:1'],
            'days.*.items.*.type' => ['required', 'in:attraction,transportation,activity,hotel,meal'],
            'days.*.items.*.start_time' => ['required', 'date_format:H:i'],
            'days.*.items.*.end_time' => ['nullable', 'date_format:H:i', 'after:days.*.items.*.start_time'],
            'days.*.items.*.item_id' => ['nullable'],
            'days.*.items.*.title' => ['required_if:days.*.items.*.item_id,null', 'string', 'max:255'],
            'days.*.items.*.description' => ['nullable', 'string'],
            'days.*.items.*.location' => ['nullable', 'string', 'max:255'],
            'days.*.items.*.duration_minutes' => ['nullable', 'integer', 'min:1'],
        ]);

        // Delete existing days and items
        $itinerary->days()->delete();

        // Create new days with items
        foreach ($data['days'] as $dayIndex => $dayData) {
            $day = $itinerary->days()->create([
                'day_number' => $dayData['day_number'],
                'title' => $dayData['title'],
                'description' => $dayData['description'] ?? null,
                'meals' => $dayData['meals'] ?? [],
            ]);

            // Handle images/videos upload for this day
            $dayImages = [];
            $dayVideos = [];
            
            if ($request->hasFile("days.{$dayIndex}.images")) {
                foreach ($request->file("days.{$dayIndex}.images") as $image) {
                    $dayImages[] = $image->store("itineraries/days/{$day->id}/images", 'public');
                }
            }
            
            if ($request->hasFile("days.{$dayIndex}.videos")) {
                foreach ($request->file("days.{$dayIndex}.videos") as $video) {
                    $dayVideos[] = $video->store("itineraries/days/{$day->id}/videos", 'public');
                }
            }
            
            if (!empty($dayImages)) {
                $day->images = $dayImages;
                $day->save();
            }
            
            if (!empty($dayVideos)) {
                $day->videos = $dayVideos;
                $day->save();
            }

            foreach ($dayData['items'] as $itemData) {
                $day->items()->create([
                    'type' => $itemData['type'],
                    'start_time' => $itemData['start_time'],
                    'end_time' => $itemData['end_time'] ?? null,
                    'item_id' => isset($itemData['item_id']) && !empty($itemData['item_id']) ? $itemData['item_id'] : null,
                    'item_type' => (isset($itemData['item_id']) && !empty($itemData['item_id'])) ? 'App\\Models\\Attraction' : null,
                    'title' => $itemData['title'] ?? null,
                    'description' => $itemData['description'] ?? null,
                    'location' => $itemData['location'] ?? null,
                    'duration_minutes' => $itemData['duration_minutes'] ?? null,
                    'sort_order' => $itemData['sort_order'] ?? 0,
                ]);
            }
        }

        $itinerary->markStepAsCompleted(2);
    }

    protected function updateStep3(Itinerary $itinerary, Request $request)
    {
        $data = $request->validate([
            'terms_conditions' => ['required', 'string', 'min:10'],
            'cancellation_policy' => ['required', 'string', 'min:10'],
        ]);

        $itinerary->update($data);
        $itinerary->markStepAsCompleted(3);
    }

    protected function updateStep4(Itinerary $itinerary, Request $request)
    {
        $data = $request->validate([
            'inclusions' => ['required', 'array', 'min:1'],
            'inclusions.*' => ['required', 'string', 'max:255'],
            'exclusions' => ['required', 'array', 'min:1'],
            'exclusions.*' => ['required', 'string', 'max:255'],
        ]);

        $itinerary->update([
            'inclusions' => $data['inclusions'],
            'exclusions' => $data['exclusions'],
        ]);
        
        $itinerary->markStepAsCompleted(4);
    }

    protected function updateStep5(Itinerary $itinerary, Request $request)
    {
        // Check if user wants to skip SEO settings
        if ($request->has('skip_seo')) {
            // Auto-generate slug from itinerary name if not exists
            if (empty($itinerary->slug)) {
                $slug = \Illuminate\Support\Str::slug($itinerary->name);
                
                // Ensure uniqueness
                $originalSlug = $slug;
                $counter = 1;
                while (\App\Models\Itinerary::where('slug', $slug)->where('id', '!=', $itinerary->id)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
                
                $itinerary->update(['slug' => $slug]);
            }
            
            $itinerary->markStepAsCompleted(5);
            return redirect()->route('itineraries.builder.edit', ['itinerary' => $itinerary->id, 'step' => 6])
                ->with('success', 'SEO settings skipped. You can add them later.');
        }

        $data = $request->validate([
            'meta_title' => ['nullable', 'string', 'max:60'],
            'meta_description' => ['nullable', 'string', 'max:160'],
            'meta_keywords' => ['nullable', 'string'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:itineraries,slug,' . $itinerary->id],
            'og_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
        ]);

        // Auto-generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['meta_title'] ?? $itinerary->name);
            
            // Ensure uniqueness
            $originalSlug = $data['slug'];
            $counter = 1;
            while (\App\Models\Itinerary::where('slug', $data['slug'])->where('id', '!=', $itinerary->id)->exists()) {
                $data['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        // Handle OG image upload
        if ($request->hasFile('og_image')) {
            $data['og_image'] = $request->file('og_image')->store('itineraries/og', 'public');
        }

        // Process meta keywords if provided
        $updateData = [
            'meta_title' => $data['meta_title'] ?? null,
            'meta_description' => $data['meta_description'] ?? null,
            'slug' => $data['slug'],
            'og_image' => $data['og_image'] ?? $itinerary->og_image,
        ];

        if (!empty($data['meta_keywords'])) {
            $updateData['meta_keywords'] = array_map('trim', explode(',', $data['meta_keywords']));
        }

        $itinerary->update($updateData);
        
        $itinerary->markStepAsCompleted(5);
    }

    public function publish(Itinerary $itinerary, Request $request)
    {
        $this->authorize('update', $itinerary);
        
        // For master itineraries, only require steps 1, 2, 3, 4, 5 (dates are optional in step 1)
        // For regular itineraries, all 5 steps must be completed
        $requiredSteps = $itinerary->is_master ? 5 : 5; // Same number but validation might differ
        $completedSteps = count($itinerary->completed_steps ?? []);
        
        // Check minimum required steps
        if ($completedSteps < $requiredSteps) {
            return redirect()
                ->route('itineraries.builder.edit', ['itinerary' => $itinerary->id, 'step' => 6])
                ->with('error', 'Please complete all required steps before publishing');
        }

        $action = $request->input('action', 'publish'); // publish, draft, mark_sent

        if ($action === 'publish') {
            $itinerary->update([
                'status' => 'published',
            ]);

            return redirect()
                ->route('itineraries.show', $itinerary)
                ->with('success', 'Itinerary published successfully!');
                
        } elseif ($action === 'draft') {
            $itinerary->update([
                'status' => 'draft',
            ]);

            return redirect()
                ->route('itineraries.builder.edit', ['itinerary' => $itinerary->id, 'step' => 6])
                ->with('success', 'Itinerary saved as draft');
                
        } elseif ($action === 'mark_sent') {
            // Mark itinerary as sent on the lead
            if ($itinerary->lead_id) {
                $itinerary->lead->update([
                    'itinerary_sent_at' => now(),
                ]);
            }

            return redirect()
                ->route('itineraries.builder.edit', ['itinerary' => $itinerary->id, 'step' => 6])
                ->with('success', 'Itinerary marked as sent');
        }

        return redirect()
            ->route('itineraries.builder.edit', ['itinerary' => $itinerary->id, 'step' => 6])
            ->with('success', 'Action completed');
    }
    
    protected function getCurrentStep(Itinerary $itinerary): int
    {
        if (!$itinerary->isStepCompleted(1)) return 1;
        if (!$itinerary->isStepCompleted(2)) return 2;
        if (!$itinerary->isStepCompleted(3)) return 3;
        if (!$itinerary->isStepCompleted(4)) return 4;
        if (!$itinerary->isStepCompleted(5)) return 5;
        return 6; // Preview step
    }
}
