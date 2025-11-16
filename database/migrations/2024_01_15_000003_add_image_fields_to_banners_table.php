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
        Schema::table('banners', function (Blueprint $table) {
            if (!Schema::hasColumn('banners', 'mobile_image')) {
                $table->string('mobile_image')->nullable()->after('image');
            }
            if (!Schema::hasColumn('banners', 'desktop_image')) {
                $table->string('desktop_image')->nullable()->after('mobile_image');
            }
            if (!Schema::hasColumn('banners', 'alt_tag')) {
                $table->string('alt_tag')->nullable()->after('desktop_image');
            }
            if (!Schema::hasColumn('banners', 'image_position')) {
                $table->string('image_position')->default('center')->after('alt_tag');
            }
            if (!Schema::hasColumn('banners', 'overlay_opacity')) {
                $table->integer('overlay_opacity')->default(40)->after('image_position');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn([
                'mobile_image',
                'desktop_image', 
                'alt_tag',
                'image_position',
                'overlay_opacity'
            ]);
        });
    }
};
