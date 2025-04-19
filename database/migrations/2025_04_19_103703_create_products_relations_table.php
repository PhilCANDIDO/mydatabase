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
        // Relation entre Product et ZoneGeo (N:M)
        Schema::create('product_zone_geos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('zone_geo_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['product_id', 'zone_geo_id']);
        });

        // Relation entre Product et OlfactiveFamily (N:M)
        Schema::create('product_olfactive_families', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('olfactive_family_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['product_id', 'olfactive_family_id']);
        });

        // Relation entre Product et OlfactiveNote (N:M) avec attributs supplémentaires
        Schema::create('product_olfactive_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('olfactive_note_id')->constrained()->onDelete('cascade');
            $table->enum('olfactive_note_position', ['head', 'heart', 'base']);
            $table->tinyInteger('olfactive_note_order');
            $table->timestamps();
            
            $table->unique(['product_id', 'olfactive_note_position', 'olfactive_note_order'], 'unique_product_note_position');
        });

        // Relation entre Product et File (N:M)
        Schema::create('product_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('file_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['product_id', 'file_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_files');
        Schema::dropIfExists('product_olfactive_notes');
        Schema::dropIfExists('product_olfactive_families');
        Schema::dropIfExists('product_zone_geos');
    }
};