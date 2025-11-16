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
        Schema::create('hotel_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
            $table->string('room_type');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('max_occupancy')->default(2);
            $table->integer('max_adults')->default(2);
            $table->integer('max_children')->default(0);
            $table->integer('size_sqm')->nullable();
            $table->string('bed_type');
            $table->integer('bed_count')->default(1);
            $table->decimal('price_per_night', 12, 2);
            $table->decimal('extra_bed_price', 12, 2)->nullable();
            $table->integer('room_count')->default(1);
            $table->integer('available_rooms')->default(0);
            $table->json('amenities')->nullable();
            $table->json('images')->nullable();
            $table->boolean('is_smoking_allowed')->default(false);
            $table->boolean('is_refundable')->default(true);
            $table->text('cancellation_policy')->nullable();
            $table->integer('min_nights')->default(1);
            $table->integer('max_nights')->nullable();
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_rooms');
    }
};
