<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('flight_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained()->onDelete('cascade');
            $table->string('departure_airport');
            $table->string('arrival_airport');
            $table->datetime('departure_date');
            $table->datetime('return_date')->nullable();
            $table->integer('passenger_count')->default(1);
            $table->enum('class_type', ['economy', 'premium_economy', 'business', 'first'])->default('economy');
            $table->string('airline_preference')->nullable();
            $table->enum('budget_range', ['budget', 'mid_range', 'premium', 'luxury'])->default('mid_range');
            $table->text('special_requests')->nullable();
            $table->enum('status', ['pending', 'quoted', 'booked', 'confirmed', 'cancelled'])->default('pending');
            $table->string('booking_reference')->nullable();
            $table->decimal('total_cost', 10, 2)->nullable();
            $table->string('currency', 3)->default('USD');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flight_tickets');
    }
};
