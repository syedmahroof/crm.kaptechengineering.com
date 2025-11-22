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
        Schema::table('states', function (Blueprint $table) {
            // Drop the unique constraint first
            $table->dropUnique(['code']);
        });

        Schema::table('states', function (Blueprint $table) {
            // Modify the column to allow 10 characters and make it nullable
            $table->string('code', 10)->nullable()->change();
        });

        Schema::table('states', function (Blueprint $table) {
            // Re-add the unique constraint (nullable columns can have multiple NULLs)
            $table->unique('code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('states', function (Blueprint $table) {
            // Drop the unique constraint
            $table->dropUnique(['code']);
        });

        Schema::table('states', function (Blueprint $table) {
            // Revert back to 3 characters and make it NOT nullable
            $table->string('code', 3)->nullable(false)->change();
        });

        Schema::table('states', function (Blueprint $table) {
            // Re-add the unique constraint
            $table->unique('code');
        });
    }
};
