<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Table pour les zones géographiques
        Schema::create('product_zone_geos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('zone_geo_value');
            $table->timestamps();
            
            $table->unique(['product_id', 'zone_geo_value']);
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('product_zone_geos');
    }
};