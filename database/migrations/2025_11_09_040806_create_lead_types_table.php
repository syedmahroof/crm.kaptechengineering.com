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
        if (!Schema::hasTable('lead_types')) {
            Schema::create('lead_types', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->string('color_code', 7)->nullable(); // Hex color code
                $table->text('description')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        } else {
            // Add missing columns if table exists
            Schema::table('lead_types', function (Blueprint $table) {
                if (!Schema::hasColumn('lead_types', 'name')) {
                    $table->string('name')->unique()->after('id');
                }
                if (!Schema::hasColumn('lead_types', 'color_code')) {
                    $table->string('color_code', 7)->nullable()->after('name');
                }
                if (!Schema::hasColumn('lead_types', 'description')) {
                    $table->text('description')->nullable()->after('color_code');
                }
                if (!Schema::hasColumn('lead_types', 'is_active')) {
                    $table->boolean('is_active')->default(true)->after('description');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_types');
    }
};
