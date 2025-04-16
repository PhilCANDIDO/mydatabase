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
        // Table pour les notes olfactives
        Schema::create('product_olfactive_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->enum('position', ['tete', 'coeur', 'fond']);
            $table->integer('order');
            $table->string('description_value');
            $table->timestamps();
            
            $table->index(['product_id', 'position', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_olfactive_notes');
    }
};
