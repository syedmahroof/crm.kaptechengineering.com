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
        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedBigInteger('state_id')->nullable()->after('project_type');
            $table->unsignedBigInteger('district_id')->nullable()->after('state_id');
            $table->string('location')->nullable()->after('district_id');
            $table->string('pincode')->nullable()->after('location');
            $table->date('expected_maturity_date')->nullable()->after('pincode');
            
            $table->foreign('state_id')->references('id')->on('states')->nullOnDelete();
            $table->foreign('district_id')->references('id')->on('districts')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['state_id']);
            $table->dropForeign(['district_id']);
            $table->dropColumn(['state_id', 'district_id', 'location', 'pincode', 'expected_maturity_date']);
        });
    }
};
