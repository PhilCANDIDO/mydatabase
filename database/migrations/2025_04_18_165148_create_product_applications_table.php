<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Table pour les applications (PM)
        Schema::create('product_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('application_value');
            $table->timestamps();
            
            $table->unique(['product_id', 'application_value']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_applications');
    }
};