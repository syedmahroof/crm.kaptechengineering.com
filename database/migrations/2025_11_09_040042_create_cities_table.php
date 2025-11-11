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
        if (!Schema::hasTable('cities')) {
            Schema::create('cities', function (Blueprint $table) {
                $table->id();
                $table->foreignId('state_id')->constrained('states')->onDelete('cascade');
                $table->string('name');
                $table->string('district')->nullable(); // District name
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        } else {
            // Add missing columns if table exists
            Schema::table('cities', function (Blueprint $table) {
                if (!Schema::hasColumn('cities', 'state_id')) {
                    $table->foreignId('state_id')->after('id')->constrained('states')->onDelete('cascade');
                }
                if (!Schema::hasColumn('cities', 'district')) {
                    $table->string('district')->nullable()->after('name');
                }
                if (!Schema::hasColumn('cities', 'is_active')) {
                    $table->boolean('is_active')->default(true)->after('district');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
