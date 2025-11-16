<?php

namespace Tests\Feature;

use App\Models\Itinerary;
use App\Models\Lead;
use App\Models\Country;
use App\Models\Destination;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItineraryBuilderTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Lead $lead;
    protected Country $country;
    protected Destination $destination;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->lead = Lead::factory()->create();
        $this->country = Country::factory()->create();
        $this->destination = Destination::factory()->create([
            'country_id' => $this->country->id,
        ]);
    }

    public function test_user_can_access_itinerary_builder_edit_page(): void
    {
        $itinerary = Itinerary::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'draft',
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('itineraries.builder.edit', ['itinerary' => $itinerary->id]));

        $response->assertStatus(200);
        $response->assertViewIs('admin.itineraries.builder.index');
    }

    public function test_user_can_access_specific_step(): void
    {
        $itinerary = Itinerary::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('itineraries.builder.edit', [
                'itinerary' => $itinerary->id,
                'step' => 2
            ]));

        $response->assertStatus(200);
        $response->assertViewIs('admin.itineraries.builder.index');
    }

    public function test_user_can_save_step1_basic_information(): void
    {
        $itinerary = Itinerary::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'draft',
        ]);

        $response = $this->actingAs($this->user)
            ->put(route('itineraries.builder.update', $itinerary->id), [
                'step' => 1,
                'lead_id' => $this->lead->id,
                'name' => 'Test Itinerary',
                'tagline' => 'Amazing Trip',
                'description' => 'A wonderful journey',
                'duration_days' => 7,
                'start_date' => '2025-12-01',
                'end_date' => '2025-12-07',
                'country_id' => $this->country->id,
                'destination_id' => $this->destination->id,
                'adult_count' => 2,
                'child_count' => 1,
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        
        $itinerary->refresh();
        $this->assertEquals('Test Itinerary', $itinerary->name);
        $this->assertEquals(7, $itinerary->duration_days);
        $this->assertTrue($itinerary->isStepCompleted(1));
    }

    public function test_step1_validates_required_fields(): void
    {
        $itinerary = Itinerary::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)
            ->put(route('itineraries.builder.update', $itinerary->id), [
                'step' => 1,
                // Missing required fields
            ]);

        $response->assertSessionHasErrors(['lead_id', 'name', 'duration_days', 'start_date', 'end_date', 'country_id', 'destination_id']);
    }

    public function test_lead_id_is_optional_for_master_itineraries(): void
    {
        $itinerary = Itinerary::factory()->create([
            'user_id' => $this->user->id,
            'is_master' => true,
        ]);

        $response = $this->actingAs($this->user)
            ->put(route('itineraries.builder.update', $itinerary->id), [
                'step' => 1,
                // No lead_id provided
                'name' => 'Master Itinerary',
                'duration_days' => 5,
                'start_date' => '2025-12-01',
                'end_date' => '2025-12-05',
                'country_id' => $this->country->id,
                'destination_id' => $this->destination->id,
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        
        $itinerary->refresh();
        $this->assertEquals('Master Itinerary', $itinerary->name);
    }

    public function test_user_can_save_step2_day_planner(): void
    {
        $itinerary = Itinerary::factory()->create([
            'user_id' => $this->user->id,
            'duration_days' => 2,
        ]);

        $response = $this->actingAs($this->user)
            ->put(route('itineraries.builder.update', $itinerary->id), [
                'step' => 2,
                'days' => [
                    [
                        'day_number' => 1,
                        'title' => 'Day 1',
                        'description' => 'First day activities',
                        'meals' => ['breakfast', 'lunch'],
                        'items' => [
                            [
                                'type' => 'activity',
                                'start_time' => '09:00',
                                'end_time' => '12:00',
                                'title' => 'Morning Tour',
                                'description' => 'City tour',
                                'location' => 'City Center',
                                'duration_minutes' => 180,
                            ]
                        ]
                    ],
                    [
                        'day_number' => 2,
                        'title' => 'Day 2',
                        'description' => 'Second day activities',
                        'meals' => ['breakfast'],
                        'items' => [
                            [
                                'type' => 'attraction',
                                'start_time' => '10:00',
                                'title' => 'Museum Visit',
                                'description' => 'Historical museum',
                            ]
                        ]
                    ]
                ]
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        
        $itinerary->refresh();
        $this->assertTrue($itinerary->isStepCompleted(2));
        $this->assertCount(2, $itinerary->days);
        $this->assertCount(1, $itinerary->days[0]->items);
    }

    public function test_step2_handles_missing_item_id_gracefully(): void
    {
        $itinerary = Itinerary::factory()->create([
            'user_id' => $this->user->id,
            'duration_days' => 1,
        ]);

        $response = $this->actingAs($this->user)
            ->put(route('itineraries.builder.update', $itinerary->id), [
                'step' => 2,
                'days' => [
                    [
                        'day_number' => 1,
                        'title' => 'Day 1',
                        'items' => [
                            [
                                'type' => 'activity',
                                'start_time' => '09:00',
                                'title' => 'Test Activity',
                                // No item_id provided
                            ]
                        ]
                    ]
                ]
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        
        $itinerary->refresh();
        $this->assertCount(1, $itinerary->days[0]->items);
        $this->assertNull($itinerary->days[0]->items[0]->item_id);
    }

    public function test_user_can_save_step3_terms_and_conditions(): void
    {
        $itinerary = Itinerary::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)
            ->put(route('itineraries.builder.update', $itinerary->id), [
                'step' => 3,
                'terms_conditions' => 'These are the terms and conditions for the itinerary.',
                'cancellation_policy' => 'Cancellation policy details here.',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        
        $itinerary->refresh();
        $this->assertTrue($itinerary->isStepCompleted(3));
        $this->assertNotEmpty($itinerary->terms_conditions);
        $this->assertNotEmpty($itinerary->cancellation_policy);
    }

    public function test_user_can_save_step4_inclusions_exclusions(): void
    {
        $itinerary = Itinerary::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)
            ->put(route('itineraries.builder.update', $itinerary->id), [
                'step' => 4,
                'inclusions' => ['Accommodation', 'Breakfast', 'Transportation'],
                'exclusions' => ['Flight tickets', 'Personal expenses'],
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        
        $itinerary->refresh();
        $this->assertTrue($itinerary->isStepCompleted(4));
        $this->assertCount(3, $itinerary->inclusions);
        $this->assertCount(2, $itinerary->exclusions);
    }

    public function test_user_can_save_step5_seo_settings(): void
    {
        $itinerary = Itinerary::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)
            ->put(route('itineraries.builder.update', $itinerary->id), [
                'step' => 5,
                'meta_title' => 'Amazing Paris Tour',
                'meta_description' => 'Discover the beauty of Paris with our comprehensive tour package.',
                'meta_keywords' => 'paris, tour, travel, vacation',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        
        $itinerary->refresh();
        $this->assertTrue($itinerary->isStepCompleted(5));
        $this->assertEquals('Amazing Paris Tour', $itinerary->meta_title);
        $this->assertNotEmpty($itinerary->meta_description);
    }

    public function test_user_cannot_update_other_users_itinerary(): void
    {
        $otherUser = User::factory()->create();
        $itinerary = Itinerary::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('itineraries.builder.edit', ['itinerary' => $itinerary->id]));

        $response->assertForbidden();
    }

    public function test_step_progression_after_save(): void
    {
        $itinerary = Itinerary::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)
            ->put(route('itineraries.builder.update', $itinerary->id), [
                'step' => 1,
                'lead_id' => $this->lead->id,
                'name' => 'Test Itinerary',
                'duration_days' => 3,
                'start_date' => '2025-12-01',
                'end_date' => '2025-12-03',
                'country_id' => $this->country->id,
                'destination_id' => $this->destination->id,
            ]);

        // Should redirect to step 2
        $response->assertRedirect();
        $this->assertStringContainsString('step=2', $response->getTargetUrl());
    }
}





