<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductFamily;
use App\Models\ReferenceData;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'nom' => $this->faker->words(3, true),
            'marque' => $this->faker->company(),
            'zone_geographique' => $this->faker->randomElement(['europe', 'amerique_nord', 'asie_pacifique', 'moyen_orient']),
            'description_olfactive_tete_1' => $this->faker->word(),
            'description_olfactive_tete_2' => $this->faker->optional(0.7)->word(),
            'description_olfactive_coeur_1' => $this->faker->word(),
            'description_olfactive_coeur_2' => $this->faker->optional(0.7)->word(),
            'description_olfactive_fond_1' => $this->faker->word(),
            'description_olfactive_fond_2' => $this->faker->optional(0.7)->word(),
            'famille_olfactive' => $this->faker->randomElement(['floral', 'boise', 'ambre', 'fruite', 'hesperide']),
            'date_sortie' => $this->faker->numberBetween(2000, 2025),
            // Suppression du champ 'active' qui n'existe pas dans la table
        ];
    }

    // État pour les produits de type W (Solinote)
    public function solinote(): Factory
    {
        return $this->state(function (array $attributes) {
            $family = ProductFamily::where('code', 'W')->first();
            
            return [
                'product_family_id' => $family->id,
                // Pour les Solinotes, on garde uniquement les champs de base
                'zone_geographique' => null,
                'description_olfactive_tete_1' => null,
                'description_olfactive_tete_2' => null,
                'description_olfactive_coeur_1' => null,
                'description_olfactive_coeur_2' => null,
                'description_olfactive_fond_1' => null,
                'description_olfactive_fond_2' => null,
                'famille_olfactive' => null,
                'date_sortie' => null,
                'specific_attributes' => null,
            ];
        });
    }

    // État pour les produits de type PM (Produits du Marché)
    public function productMarket(): Factory
    {
        return $this->state(function (array $attributes) {
            $family = ProductFamily::where('code', 'PM')->first();
            $applications = ReferenceData::where('type', 'application')
                ->where('active', true)
                ->pluck('value')
                ->toArray();
            
            return [
                'product_family_id' => $family->id,
                'specific_attributes' => [
                    'application' => $this->faker->randomElement($applications ?: ['eau_parfum', 'cosmetique', 'bougie']),
                ],
                'date_sortie' => null,
                'unisex' => null,
            ];
        });
    }

    // État pour les produits de type D (Dame)
    public function dame(): Factory
    {
        return $this->state(function (array $attributes) {
            $family = ProductFamily::where('code', 'D')->first();
            
            return [
                'product_family_id' => $family->id,
                'unisex' => $this->faker->boolean(20), // 20% chance d'être unisex
                'specific_attributes' => null,
            ];
        });
    }

    // État pour les produits de type M (Masculin)
    public function masculin(): Factory
    {
        return $this->state(function (array $attributes) {
            $family = ProductFamily::where('code', 'M')->first();
            
            return [
                'product_family_id' => $family->id,
                'unisex' => $this->faker->boolean(20), // 20% chance d'être unisex
                'specific_attributes' => null,
            ];
        });
    }

    // État pour les produits de type U (Unisex)
    public function unisex(): Factory
    {
        return $this->state(function (array $attributes) {
            $family = ProductFamily::where('code', 'U')->first();
            
            return [
                'product_family_id' => $family->id,
                'unisex' => null,
                'specific_attributes' => [
                    'genre' => $this->faker->randomElement(['Masculin', 'Féminin']),
                ],
            ];
        });
    }
}