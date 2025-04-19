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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_type')->unique();
            $table->foreignId('product_family_id')->constrained();
            $table->string('product_name');
            $table->string('product_marque')->nullable()->index();
            $table->year('product_annee_sortie')->nullable()->index();
            $table->boolean('product_unisex')->nullable();
            $table->string('product_avatar')->nullable();
            $table->foreignId('application_id')->nullable()->constrained()->index();
            $table->enum('product_genre', ['M', 'F'])->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};