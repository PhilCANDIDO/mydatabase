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
        Schema::create('zone_geos', function (Blueprint $table) {
            $table->id();
            $table->string('zone_geo_name');
            $table->text('zone_geo_desc')->nullable();
            $table->boolean('zone_geo_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zone_geos');
    }
};