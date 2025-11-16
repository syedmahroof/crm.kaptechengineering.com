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
        // Drop existing foreign key constraints if they exist
        Schema::table('bookings', function (Blueprint $table) {
            // Drop foreign keys
            $table->dropForeign(['package_id']);
            $table->dropForeign(['lead_person_id']);
            $table->dropForeign(['cancelled_by']);
            $table->dropForeign(['created_by']);
        });

        // Re-add foreign keys with proper constraints
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreign('package_id')
                ->references('id')
                ->on('packages')
                ->onDelete('cascade');

            $table->foreign('lead_person_id')
                ->references('id')
                ->on('lead_people')
                ->onDelete('set null');

            $table->foreign('cancelled_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign keys if needed when rolling back
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['package_id']);
            $table->dropForeign(['lead_person_id']);
            $table->dropForeign(['cancelled_by']);
            $table->dropForeign(['created_by']);
        });
    }
};
