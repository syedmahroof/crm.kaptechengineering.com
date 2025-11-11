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
        // This migration is kept for future use
        // For now, we'll keep lead_type as string in leads table
        // and manage types through lead_types table
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
