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
        Schema::table('leads', function (Blueprint $table) {
            $table->foreignId('lead_status_id')->nullable()->constrained('lead_statuses')->onDelete('set null');
            $table->foreignId('business_type_id')->nullable()->constrained('business_types')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropForeign(['lead_status_id']);
            $table->dropForeign(['business_type_id']);
            $table->dropColumn(['lead_status_id', 'business_type_id']);
        });
    }
};
