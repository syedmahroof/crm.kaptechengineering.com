<?php

use App\Models\Branch;
use App\Models\Lead;
use App\Models\LeadStatus;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\CategoryBrandSeeder;
use Database\Seeders\LeadStatusSeeder;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed([
        RolePermissionSeeder::class,
        LeadStatusSeeder::class,
        CategoryBrandSeeder::class,
    ]);

    $this->user = User::first();
    $this->actingAs($this->user);
});

test('leads index page loads successfully', function () {
    $response = $this->get(route('leads.index'));

    $response->assertStatus(200);
    $response->assertViewIs('leads.index');
    $response->assertViewHas(['statuses', 'users', 'products', 'branches']);
});

test('leads datatable ajax returns json', function () {
    Lead::factory()->count(5)->create([
        'status_id' => LeadStatus::first()->id,
    ]);

    $response = $this->getJson(route('leads.index'));

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'draw',
        'recordsTotal',
        'recordsFiltered',
        'data',
    ]);
});

test('lead can be created with lead type', function () {
    $status = LeadStatus::first();
    $branch = Branch::first();
    $product = Product::first();

    $leadData = [
        'name' => 'Test Lead',
        'email' => 'test@example.com',
        'phone' => '+1-555-1234',
        'status_id' => $status->id,
        'branch_id' => $branch->id,
        'product_id' => $product->id,
        'source' => 'Website',
        'lead_type' => 'Hot Lead',
        'notes' => 'Test notes',
    ];

    $response = $this->post(route('leads.store'), $leadData);

    $response->assertRedirect(route('leads.index'));
    $this->assertDatabaseHas('leads', [
        'name' => 'Test Lead',
        'email' => 'test@example.com',
        'lead_type' => 'Hot Lead',
    ]);
});

test('lead type field exists in database', function () {
    $status = LeadStatus::first();

    $lead = Lead::create([
        'name' => 'Test Lead',
        'email' => 'test@example.com',
        'status_id' => $status->id,
        'lead_type' => 'Warm Lead',
    ]);

    expect($lead->lead_type)->toBe('Warm Lead');
    expect($lead)->toBeInstanceOf(Lead::class);
});

test('lead has relationships', function () {
    $status = LeadStatus::first();
    $user = User::first();
    $product = Product::first();
    $branch = Branch::first();

    $lead = Lead::create([
        'name' => 'Test Lead',
        'email' => 'test@example.com',
        'status_id' => $status->id,
        'assigned_to' => $user->id,
        'product_id' => $product->id,
        'branch_id' => $branch->id,
        'lead_type' => 'Qualified',
    ]);

    expect($lead->status)->toBeInstanceOf(LeadStatus::class);
    expect($lead->assignedUser)->toBeInstanceOf(User::class);
    expect($lead->product)->toBeInstanceOf(Product::class);
    expect($lead->branch)->toBeInstanceOf(Branch::class);
});

test('lead datatable filters by status', function () {
    $status1 = LeadStatus::where('name', 'New')->first();
    $status2 = LeadStatus::where('name', 'Contacted')->first();

    Lead::create([
        'name' => 'Lead 1',
        'email' => 'lead1@example.com',
        'status_id' => $status1->id,
        'lead_type' => 'Hot Lead',
    ]);

    Lead::create([
        'name' => 'Lead 2',
        'email' => 'lead2@example.com',
        'status_id' => $status2->id,
        'lead_type' => 'Cold Lead',
    ]);

    $response = $this->getJson(route('leads.index', ['status' => 'New']));

    $response->assertStatus(200);
    expect($response->json('recordsFiltered'))->toBeGreaterThanOrEqual(1);
});

test('lead datatable filters by lead type', function () {
    $status = LeadStatus::first();

    Lead::create([
        'name' => 'Hot Lead Test',
        'email' => 'hot@example.com',
        'status_id' => $status->id,
        'lead_type' => 'Hot Lead',
    ]);

    Lead::create([
        'name' => 'Cold Lead Test',
        'email' => 'cold@example.com',
        'status_id' => $status->id,
        'lead_type' => 'Cold Lead',
    ]);

    $response = $this->getJson(route('leads.index', ['lead_type' => 'Hot Lead']));

    $response->assertStatus(200);
    expect($response->json('recordsFiltered'))->toBeGreaterThanOrEqual(1);
});

test('lead can be updated with lead type', function () {
    $lead = Lead::factory()->create([
        'status_id' => LeadStatus::first()->id,
        'lead_type' => 'Cold Lead',
    ]);

    $response = $this->put(route('leads.update', $lead), [
        'name' => $lead->name,
        'email' => $lead->email,
        'phone' => $lead->phone,
        'status_id' => $lead->status_id,
        'lead_type' => 'Hot Lead',
    ]);

    $response->assertRedirect(route('leads.index'));
    $this->assertDatabaseHas('leads', [
        'id' => $lead->id,
        'lead_type' => 'Hot Lead',
    ]);
});

test('lead can be deleted', function () {
    $lead = Lead::factory()->create([
        'status_id' => LeadStatus::first()->id,
    ]);

    $response = $this->delete(route('leads.destroy', $lead));

    $response->assertRedirect(route('leads.index'));
    $this->assertDatabaseMissing('leads', [
        'id' => $lead->id,
    ]);
});

test('lead timestamps are set correctly', function () {
    $lead = Lead::factory()->create([
        'status_id' => LeadStatus::first()->id,
    ]);

    expect($lead->created_at)->not->toBeNull();
    expect($lead->updated_at)->not->toBeNull();
});
