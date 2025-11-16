<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('itinerary_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('itinerary_day_id')->constrained()->cascadeOnDelete();
            $table->string('type')->default('attraction'); // attraction, transportation, activity, hotel, meal
            $table->time('start_time');
            $table->time('end_time')->nullable();
            
            // Polymorphic relationship for the item (attraction, hotel, etc.)
            $table->nullableMorphs('item');
            
            // Custom details in case the item is not from a predefined model
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('location')->nullable();
            
            // Additional metadata
            $table->integer('duration_minutes')->nullable();
            $table->integer('sort_order')->default(0);
            $table->json('metadata')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('itinerary_items');
    }
};
