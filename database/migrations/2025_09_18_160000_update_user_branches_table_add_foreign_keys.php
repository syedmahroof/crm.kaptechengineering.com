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
        Schema::table('user_branches', function (Blueprint $table) {
            if (!Schema::hasColumn('user_branches', 'user_id')) {
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('user_branches', 'branch_id')) {
                $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('user_branches', 'is_primary')) {
                $table->boolean('is_primary')->default(false);
            }
            
            // Add unique constraint only if it doesn't exist
            if (!Schema::hasIndex('user_branches', 'user_branches_user_id_branch_id_unique')) {
                $table->unique(['user_id', 'branch_id']);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_branches', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['branch_id']);
            $table->dropUnique(['user_id', 'branch_id']);
            $table->dropColumn(['user_id', 'branch_id', 'is_primary']);
        });
    }
};



