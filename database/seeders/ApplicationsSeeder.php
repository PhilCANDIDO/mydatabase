<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApplicationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $applications = [
            [
                'application_name' => 'Fine fragrance',
                'application_desc' => 'Parfumerie fine haut de gamme, comprenant des compositions complexes pour parfums en flacons.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Cosmétique',
                'application_desc' => 'Produits de soins et de beauté, incluant les crèmes, baumes et lotions parfumées.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Ambiance',
                'application_desc' => 'Produits destinés à parfumer les espaces intérieurs comme les bougies ou diffuseurs.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Détergence',
                'application_desc' => 'Produits ménagers et nettoyants parfumés pour un usage domestique ou industriel.',
                'application_active' => true,
            ],
            [
                'application_name' => 'EDT/EDP',
                'application_desc' => 'Eau de toilette et eau de parfum, concentrations classiques en parfumerie personnelle.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Brumes',
                'application_desc' => 'Brumes parfumées légères pour le corps, moins concentrées que les EDT/EDP.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Roll on',
                'application_desc' => 'Applicateurs à bille pour parfums ou déodorants, permettant une application localisée.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Eau de cologne',
                'application_desc' => 'Formulation traditionnelle légère avec concentration plus faible, souvent à base d\'agrumes.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Crème solaire',
                'application_desc' => 'Produits de protection solaire avec parfum intégré, demandant une stabilité aux UV.',
                'application_active' => true,
            ],	
            [
                'application_name' => 'Savon solide',
                'application_desc' => 'Savons sous forme solide nécessitant des parfums résistants à la saponification.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Gel douche',
                'application_desc' => 'Nettoyants liquides pour le corps avec compositions parfumées résistantes à l\'eau.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Shampooing',
                'application_desc' => 'Produits capillaires nécessitant des parfums stables en milieu tensioactif.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Après shampooing',
                'application_desc' => 'Soins capillaires avec des notes parfumées souvent plus douces et persistantes.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Crème/huile/sérum visage',
                'application_desc' => 'Soins du visage parfumés avec contraintes hypoallergéniques et formulations douces.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Crème/huile corps',
                'application_desc' => 'Soins corporels avec parfums intégrés, nécessitant bonne tenue sur la peau.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Gommage',
                'application_desc' => 'Exfoliants parfumés pour le corps ou le visage avec notes rafraîchissantes ou énergisantes.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Déodorant',
                'application_desc' => 'Produits anti-transpirants avec compositions parfumées et propriétés anti-odeurs.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Masque capillaire',
                'application_desc' => 'Soins intensifs pour cheveux avec parfums adaptés aux formules riches.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Mousse à raser',
                'application_desc' => 'Produits de rasage moussants avec parfums souvent frais et masculins.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Crème éclaircissante',
                'application_desc' => 'Soins dépigmentants avec parfums doux compatibles avec les actifs éclaircissants.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Maquillage',
                'application_desc' => 'Produits cosmétiques décoratifs parfumés nécessitant stabilité et hypoallergénicité.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Gel hydroalcoolique',
                'application_desc' => 'Désinfectants pour les mains avec parfums résistants aux fortes concentrations d\'alcool.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Crème mains',
                'application_desc' => 'Soins hydratants spécifiques pour les mains avec parfums souvent gourmands ou floraux.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Produits pour cheveux',
                'application_desc' => 'Gamme complète de soins capillaires incluant gels, laques et cires parfumés.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Talc',
                'application_desc' => 'Poudres absorbantes parfumées pour le corps, souvent avec notes douces et poudrées.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Hairmist',
                'application_desc' => 'Brumes légères pour les cheveux combinant parfum et soins légers.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Gel intime/lubrifiant',
                'application_desc' => 'Produits intimes avec parfums hypoallergéniques adaptés aux zones sensibles.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Bougie',
                'application_desc' => 'Produits de parfumerie d\'ambiance à combustion avec compositions adaptées à la diffusion par chaleur.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Diffuseur capillaire',
                'application_desc' => 'Systèmes de diffusion par mèches pour parfumer l\'air ambiant de façon continue.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Diffuseur par nébulisation',
                'application_desc' => 'Diffuseurs transformant le parfum en micro-gouttelettes sans chauffage, préservant l\'intégrité.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Diffuseur voiture',
                'application_desc' => 'Produits spécifiques pour parfumer l\'habitacle automobile avec tenue longue durée.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Spray d\'ambiance',
                'application_desc' => 'Aérosols parfumés pour rafraîchir rapidement une pièce avec diffusion immédiate.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Désodorisant',
                'application_desc' => 'Produits spécifiquement conçus pour neutraliser les mauvaises odeurs avant de parfumer.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Bakhoor',
                'application_desc' => 'Encens traditionnels du Moyen-Orient à base de copeaux de bois parfumés.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Lessive',
                'application_desc' => 'Détergents pour textiles avec compositions parfumées résistantes au lavage et séchage.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Assouplissant',
                'application_desc' => 'Produits de rinçage du linge avec parfums persistants déposés sur les fibres.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Lave sol',
                'application_desc' => 'Nettoyants pour sols avec parfums puissants diffusant dans toute la pièce.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Lave vitre',
                'application_desc' => 'Nettoyants pour surfaces vitrées avec parfums frais évoquant la propreté.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Liquide vaisselle',
                'application_desc' => 'Détergents pour la vaisselle avec parfums résistants à l\'eau chaude et aux graisses.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Désinfectant',
                'application_desc' => 'Produits nettoyants antibactériens avec parfums évoquant la propreté et l\'hygiène.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Savon liquide', 
                'application_desc' => 'Nettoyants pour les mains en format liquide avec parfums variés et bonne résistance à l\'eau.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Antitranspirant',
                'application_desc' => 'Produits régulant la transpiration avec parfums adaptés aux interactions avec la sueur.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Gel WC',
                'application_desc' => 'Nettoyants pour toilettes avec parfums puissants masquant efficacement les mauvaises odeurs.',
                'application_active' => true,
            ],
            [
                'application_name' => 'Javel',
                'application_desc' => 'Désinfectants chlorés avec parfums masquant l\'odeur chimique du chlore actif.',
                'application_active' => true,
            ],
        ];

        foreach ($applications as $application) {
            // Vérifier si l'application existe déjà pour éviter les doublons
            $exists = DB::table('applications')
                ->where('application_name', $application['application_name'])
                ->exists();
                
            if (!$exists) {
                DB::table('applications')->insert(array_merge($application, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
                $this->command->info("Application \"{$application['application_name']}\" créée.");
            } else {
                $this->command->info("Application \"{$application['application_name']}\" existe déjà.");
            }
        }
    }
}