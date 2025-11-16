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
        Schema::table('campaign_contacts', function (Blueprint $table) {
            $table->boolean('is_winner')->default(false)->after('terms_accepted');
            $table->timestamp('winner_selected_at')->nullable()->after('is_winner');
            $table->text('winner_notes')->nullable()->after('winner_selected_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaign_contacts', function (Blueprint $table) {
            $table->dropColumn(['is_winner', 'winner_selected_at', 'winner_notes']);
        });
    }
};