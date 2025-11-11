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
        if (!Schema::hasTable('countries')) {
            Schema::create('countries', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('code', 3)->unique()->nullable(); // ISO country code
                $table->string('phone_code', 5)->nullable(); // Phone country code
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        } else {
            // Add missing columns if table exists
            Schema::table('countries', function (Blueprint $table) {
                if (!Schema::hasColumn('countries', 'code')) {
                    $table->string('code', 3)->unique()->nullable()->after('name');
                }
                if (!Schema::hasColumn('countries', 'phone_code')) {
                    $table->string('phone_code', 5)->nullable()->after('code');
                }
                if (!Schema::hasColumn('countries', 'is_active')) {
                    $table->boolean('is_active')->default(true)->after('phone_code');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
