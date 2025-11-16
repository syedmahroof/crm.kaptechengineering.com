<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lead_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('color')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        // Insert default lead types
        DB::table('lead_types')->insert([
            ['name' => 'B2B', 'slug' => 'b2b', 'description' => 'Business to Business', 'color' => '#3b82f6', 'icon' => 'fa-building', 'is_active' => true, 'order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'B2C', 'slug' => 'b2c', 'description' => 'Business to Consumer', 'color' => '#10b981', 'icon' => 'fa-users', 'is_active' => true, 'order' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Normal', 'slug' => 'normal', 'description' => 'Normal Lead', 'color' => '#6b7280', 'icon' => 'fa-user', 'is_active' => true, 'order' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('lead_types');
    }
};
