<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lead_product', function (Blueprint $table) {
            $table->integer('quantity')->default(1)->after('product_id');
            $table->text('description')->nullable()->after('quantity');
        });
    }

    public function down(): void
    {
        Schema::table('lead_product', function (Blueprint $table) {
            $table->dropColumn(['quantity', 'description']);
        });
    }
};




