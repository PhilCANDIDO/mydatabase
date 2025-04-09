<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('type')->unique(); // Identifiant unique: code famille + numéro 6 chiffres
            $table->foreignId('product_family_id')->constrained()->onDelete('cascade');
            $table->string('nom');
            $table->string('marque')->nullable();
            
            // Champs communs aux familles PM, D, M, U
            $table->string('zone_geographique')->nullable();
            $table->string('description_olfactive_tete_1')->nullable();
            $table->string('description_olfactive_tete_2')->nullable();
            $table->string('description_olfactive_coeur_1')->nullable();
            $table->string('description_olfactive_coeur_2')->nullable();
            $table->string('description_olfactive_fond_1')->nullable();
            $table->string('description_olfactive_fond_2')->nullable();
            $table->string('famille_olfactive')->nullable();
            
            // Champs spécifiques stockés dans une colonne JSON
            $table->json('specific_attributes')->nullable();
            
            // Champs variables mais communs à plusieurs familles
            $table->year('date_sortie')->nullable();  // Utilisé pour D, M, U
            $table->boolean('unisex')->nullable();    // Utilisé pour D, M
            
            // Gestion des fichiers
            $table->string('avatar')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};