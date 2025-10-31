<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Lead;
use App\Models\LeadStatus;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\CategoryBrandSeeder;
use Database\Seeders\LeadStatusSeeder;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LeadTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed required data
        $this->seed([
            RolePermissionSeeder::class,
            LeadStatusSeeder::class,
            CategoryBrandSeeder::class,
        ]);
    }

    /**
     * Test that leads can be created successfully.
     */
    public function test_lead_can_be_created(): void
    {
        $status = LeadStatus::first();
        $branch = Branch::first();
        $product = Product::first();

        $lead = Lead::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+1-555-1234',
            'status_id' => $status->id,
            'branch_id' => $branch->id,
            'product_id' => $product->id,
            'source' => 'Website',
            'lead_type' => 'Hot Lead',
            'notes' => 'Interested in enterprise solution',
        ]);

        $this->assertDatabaseHas('leads', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'lead_type' => 'Hot Lead',
        ]);
    }

    /**
     * Test that lead has a type field.
     */
    public function test_lead_has_lead_type_field(): void
    {
        $status = LeadStatus::first();

        $lead = Lead::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'status_id' => $status->id,
            'lead_type' => 'Warm Lead',
        ]);

        $this->assertEquals('Warm Lead', $lead->lead_type);
    }

    /**
     * Test lead belongs to status relationship.
     */
    public function test_lead_belongs_to_status(): void
    {
        $status = LeadStatus::first();

        $lead = Lead::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'status_id' => $status->id,
            'lead_type' => 'New Inquiry',
        ]);

        $this->assertInstanceOf(LeadStatus::class, $lead->status);
        $this->assertEquals($status->id, $lead->status->id);
    }

    /**
     * Test lead can be assigned to a user.
     */
    public function test_lead_can_be_assigned_to_user(): void
    {
        $user = User::factory()->create();
        $status = LeadStatus::first();

        $lead = Lead::create([
            'name' => 'Assigned Lead',
            'email' => 'assigned@example.com',
            'status_id' => $status->id,
            'assigned_to' => $user->id,
            'lead_type' => 'Qualified',
        ]);

        $this->assertNotNull($lead->assignedUser);
        $this->assertEquals($user->id, $lead->assignedUser->id);
    }

    /**
     * Test lead belongs to product relationship.
     */
    public function test_lead_belongs_to_product(): void
    {
        $status = LeadStatus::first();
        $product = Product::first();

        $lead = Lead::create([
            'name' => 'Product Lead',
            'email' => 'product@example.com',
            'status_id' => $status->id,
            'product_id' => $product->id,
            'lead_type' => 'Hot Lead',
        ]);

        $this->assertInstanceOf(Product::class, $lead->product);
        $this->assertEquals($product->id, $lead->product->id);
    }

    /**
     * Test lead belongs to branch relationship.
     */
    public function test_lead_belongs_to_branch(): void
    {
        $status = LeadStatus::first();
        $branch = Branch::first();

        $lead = Lead::create([
            'name' => 'Branch Lead',
            'email' => 'branch@example.com',
            'status_id' => $status->id,
            'branch_id' => $branch->id,
            'lead_type' => 'Cold Lead',
        ]);

        $this->assertInstanceOf(Branch::class, $lead->branch);
        $this->assertEquals($branch->id, $lead->branch->id);
    }

    /**
     * Test lead can have multiple lead types.
     */
    public function test_lead_types_are_working(): void
    {
        $status = LeadStatus::first();
        $leadTypes = [
            'Hot Lead',
            'Warm Lead',
            'Cold Lead',
            'New Inquiry',
            'Referral',
            'Returning Customer',
            'Qualified',
            'Unqualified',
        ];

        foreach ($leadTypes as $type) {
            $lead = Lead::create([
                'name' => "Test {$type}",
                'email' => strtolower(str_replace(' ', '', $type)).'@example.com',
                'status_id' => $status->id,
                'lead_type' => $type,
            ]);

            $this->assertEquals($type, $lead->lead_type);
        }

        $this->assertEquals(count($leadTypes), Lead::count());
    }

    /**
     * Test lead can have a source.
     */
    public function test_lead_has_source(): void
    {
        $status = LeadStatus::first();

        $lead = Lead::create([
            'name' => 'Source Lead',
            'email' => 'source@example.com',
            'status_id' => $status->id,
            'source' => 'Social Media',
            'lead_type' => 'Referral',
        ]);

        $this->assertEquals('Social Media', $lead->source);
    }

    /**
     * Test lead can have notes.
     */
    public function test_lead_can_have_notes(): void
    {
        $status = LeadStatus::first();
        $notes = 'This is a very important lead from our partner.';

        $lead = Lead::create([
            'name' => 'Notes Lead',
            'email' => 'notes@example.com',
            'status_id' => $status->id,
            'lead_type' => 'Partner Referral',
            'notes' => $notes,
        ]);

        $this->assertEquals($notes, $lead->notes);
    }

    /**
     * Test seeded leads count.
     */
    public function test_can_seed_multiple_leads(): void
    {
        $status = LeadStatus::first();

        // Create 10 test leads
        for ($i = 1; $i <= 10; $i++) {
            Lead::create([
                'name' => "Test Lead {$i}",
                'email' => "testlead{$i}@example.com",
                'status_id' => $status->id,
                'lead_type' => 'Hot Lead',
            ]);
        }

        $this->assertEquals(10, Lead::count());
    }

    /**
     * Test lead timestamps are set.
     */
    public function test_lead_has_timestamps(): void
    {
        $status = LeadStatus::first();

        $lead = Lead::create([
            'name' => 'Timestamp Lead',
            'email' => 'timestamp@example.com',
            'status_id' => $status->id,
            'lead_type' => 'New Inquiry',
        ]);

        $this->assertNotNull($lead->created_at);
        $this->assertNotNull($lead->updated_at);
    }
}
