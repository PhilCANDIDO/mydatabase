<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reference_data', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // Ex: 'application', 'zone_geo', 'famille_olfactive', etc.
            $table->string('value');
            $table->string('label');
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
            
            // Index composé pour la recherche rapide
            $table->unique(['type', 'value']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reference_data');
    }
};