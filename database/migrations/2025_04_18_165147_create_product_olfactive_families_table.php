<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Table pour les familles olfactives
        Schema::create('product_olfactive_families', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('famille_value');
            $table->timestamps();
            
            $table->unique(['product_id', 'famille_value']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_olfactive_families');
    }
};