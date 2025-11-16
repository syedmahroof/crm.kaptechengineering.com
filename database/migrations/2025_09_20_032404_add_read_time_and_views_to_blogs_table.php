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
        Schema::table('blogs', function (Blueprint $table) {
            if (!Schema::hasColumn('blogs', 'read_time')) {
                $table->integer('read_time')->default(5)->after('published_at');
            }
            if (!Schema::hasColumn('blogs', 'views')) {
                $table->integer('views')->default(0)->after('read_time');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            if (Schema::hasColumn('blogs', 'read_time')) {
                $table->dropColumn('read_time');
            }
            if (Schema::hasColumn('blogs', 'views')) {
                $table->dropColumn('views');
            }
        });
    }
};