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
        if (!Schema::hasTable('states')) {
            Schema::create('states', function (Blueprint $table) {
                $table->id();
                $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
                $table->string('name');
                $table->string('code', 10)->nullable(); // State code
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        } else {
            // Add missing columns if table exists
            Schema::table('states', function (Blueprint $table) {
                if (!Schema::hasColumn('states', 'country_id')) {
                    $table->foreignId('country_id')->after('id')->constrained('countries')->onDelete('cascade');
                }
                if (!Schema::hasColumn('states', 'code')) {
                    $table->string('code', 10)->nullable()->after('name');
                }
                if (!Schema::hasColumn('states', 'is_active')) {
                    $table->boolean('is_active')->default(true)->after('code');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('states');
    }
};
