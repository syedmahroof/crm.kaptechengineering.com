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
        Schema::create('booking_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('hotel_room_id')->constrained()->onDelete('cascade');
            $table->string('room_number')->nullable();
            $table->string('room_type');
            $table->integer('quantity')->default(1);
            $table->integer('adults')->default(1);
            $table->integer('children')->default(0);
            $table->integer('extra_beds')->default(0);
            $table->decimal('price_per_night', 12, 2);
            $table->decimal('extra_bed_price', 12, 2)->default(0);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('tax_amount', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2);
            $table->string('currency', 3)->default('USD');
            $table->string('status'); // confirmed, cancelled, checked_in, checked_out, no_show
            $table->date('check_in');
            $table->date('check_out');
            $table->time('check_in_time')->nullable();
            $table->time('check_out_time')->nullable();
            $table->text('special_requests')->nullable();
            $table->json('guest_info')->nullable();
            $table->json('cancellation_policy')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->foreignId('cancelled_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_rooms');
    }
};
