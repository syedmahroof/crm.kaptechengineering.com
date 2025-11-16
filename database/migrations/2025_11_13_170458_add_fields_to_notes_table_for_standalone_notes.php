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
        Schema::table('notes', function (Blueprint $table) {
            // Make polymorphic fields nullable for standalone notes
            if (Schema::hasColumn('notes', 'noteable_id')) {
                $table->unsignedBigInteger('noteable_id')->nullable()->change();
            }
            if (Schema::hasColumn('notes', 'noteable_type')) {
                $table->string('noteable_type')->nullable()->change();
            }
            
            // Add new fields for standalone notes
            if (!Schema::hasColumn('notes', 'title')) {
                $table->string('title')->nullable()->after('id');
            }
            if (!Schema::hasColumn('notes', 'category')) {
                $table->string('category')->nullable()->after('content');
            }
            if (!Schema::hasColumn('notes', 'is_pinned')) {
                $table->boolean('is_pinned')->default(false)->after('category');
            }
            
            // Add index for pinned notes
            if (!Schema::hasIndex('notes', 'notes_is_pinned_index')) {
                $table->index('is_pinned');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            if (Schema::hasColumn('notes', 'title')) {
                $table->dropColumn('title');
            }
            if (Schema::hasColumn('notes', 'category')) {
                $table->dropColumn('category');
            }
            if (Schema::hasColumn('notes', 'is_pinned')) {
                $table->dropColumn('is_pinned');
            }
            
            // Revert polymorphic fields to not null if needed
            // $table->unsignedBigInteger('noteable_id')->nullable(false)->change();
            // $table->string('noteable_type')->nullable(false)->change();
        });
    }
};
