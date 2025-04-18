<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\ProductFamily;
use App\Models\ReferenceData;
use App\Traits\HasPermissions;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination, HasPermissions;

    public $selectedFamilies = [];
    public $allFamilies = [];
    public $family;
    public $search = '';
    public $perPage = 10;
    public $sortField = 'type';
    public $sortDirection = 'asc';
    public $showColumnSelector = false;
    public $filters = [];
    public $visibleColumns = [];
    public $availableColumns = [];
    public $columnLabels = [];

    protected $searchableFields = [
        'W' => ['type', 'nom'],
        'PM' => ['type', 'nom', 'marque', 'zone_geographique', 'famille_olfactive'],
        'D' => ['type', 'nom', 'marque', 'zone_geographique', 'famille_olfactive'],
        'M' => ['type', 'nom', 'marque', 'zone_geographique', 'famille_olfactive'],
        'U' => ['type', 'nom', 'marque', 'zone_geographique', 'famille_olfactive'],
    ];

    protected $defaultColumns = [
        'W' => ['type', 'nom'],
        'PM' => ['type', 'nom', 'marque', 'specific_attributes->application', 'famille_olfactive'],
        'D' => ['type', 'nom', 'marque', 'zone_geographique', 'date_sortie', 'famille_olfactive', 'unisex'],
        'M' => ['type', 'nom', 'marque', 'zone_geographique', 'date_sortie', 'famille_olfactive', 'unisex'],
        'U' => ['type', 'nom', 'marque', 'zone_geographique', 'date_sortie', 'specific_attributes->genre', 'famille_olfactive'],
    ];

    protected $listeners = [
        'refreshProducts' => '$refresh',
        'deleteProduct' => 'handleDeleteProduct',
        'family-toggled' => 'toggleFamily'
    ];

    public function mount($family = null)
    {
        $this->family = $family;
        
        // Charger toutes les familles actives
        $this->allFamilies = ProductFamily::where('active', true)->orderBy('name')->get();
        
        // Initialiser les familles sélectionnées
        if ($family) {
            // Si une famille spécifique est demandée, la sélectionner
            $this->selectedFamilies = [$family->id];
        } else {
            // Essayer de récupérer les préférences de l'utilisateur
            if (Auth::check()) {
                $savedFamilies = Auth::user()->getPreference('products.selected_families');
                if ($savedFamilies && is_array($savedFamilies) && !empty($savedFamilies)) {
                    $this->selectedFamilies = $savedFamilies;
                } else {
                    // Par défaut, toutes les familles sont sélectionnées
                    $this->selectedFamilies = $this->allFamilies->pluck('id')->toArray();
                }
            } else {
                // Pour les utilisateurs non connectés, toutes les familles
                $this->selectedFamilies = $this->allFamilies->pluck('id')->toArray();
            }
        }

        // Initialiser les étiquettes des colonnes
        $this->initializeColumnLabels();
        
        // Initialiser les colonnes
        $this->initializeColumns();
        
        // Charger les préférences de pagination de l'utilisateur
        if (Auth::check()) {
            $this->perPage = Auth::user()->getPreference('products.per_page', 10);
        }
    }

    public function toggleFamily($familyId)
    {
        $familyId = (int) $familyId;
        
        // Si la famille est déjà sélectionnée, on la désélectionne
        if (in_array($familyId, $this->selectedFamilies)) {
            $this->selectedFamilies = array_values(array_diff($this->selectedFamilies, [$familyId]));
        } else {
            // Sinon on l'ajoute aux sélections
            $this->selectedFamilies[] = $familyId;
        }
        
        // Sauvegarder les préférences de l'utilisateur
        if (Auth::check()) {
            Auth::user()->setPreference('products.selected_families', $this->selectedFamilies);
        }
        
        // Réinitialiser la pagination et les colonnes
        $this->resetPage();
        $this->initializeColumns();
    }

    protected function initializeColumnLabels()
    {
        // Code existant inchangé
        $this->columnLabels = [
            'type' => __('Type'),
            'nom' => __('Nom'),
            'marque' => __('Marque'),
            'zone_geographique' => __('Zone géographique'),
            'famille_olfactive' => __('Famille olfactive'),
            'date_sortie' => __('Année'),
            'specific_attributes->application' => __('Application'),
            'specific_attributes->genre' => __('Genre'),
            'unisex' => __('Unisex'),
            'description_olfactive_tete_1' => __('Note de tête 1'),
            'description_olfactive_tete_2' => __('Note de tête 2'),
            'description_olfactive_coeur_1' => __('Note de cœur 1'),
            'description_olfactive_coeur_2' => __('Note de cœur 2'),
            'description_olfactive_fond_1' => __('Note de fond 1'),
            'description_olfactive_fond_2' => __('Note de fond 2'),
        ];
    }

    protected function initializeColumns()
    {
        // Si aucune famille n'est sélectionnée
        if (empty($this->selectedFamilies)) {
            $this->availableColumns = ['type', 'nom', 'marque'];
            $this->visibleColumns = ['type', 'nom', 'marque'];
            return;
        }

        // Déterminer les colonnes communes pour toutes les familles sélectionnées
        $familyCodes = ProductFamily::whereIn('id', $this->selectedFamilies)
                                   ->pluck('code')
                                   ->toArray();
        
        // Colonnes communes à toutes les familles
        $commonColumns = ['type', 'nom', 'marque'];
        
        // Colonnes spécifiques à analyser
        $potentialColumns = [
            'zone_geographique', 'famille_olfactive', 'date_sortie', 
            'unisex', 'specific_attributes->application', 'specific_attributes->genre'
        ];
        
        // Déterminer les colonnes disponibles en fonction des familles sélectionnées
        $availableColumns = $commonColumns;
        
        foreach ($potentialColumns as $column) {
            $applicable = true;
            
            foreach ($familyCodes as $code) {
                if ($column === 'date_sortie' && !in_array($code, ['D', 'M', 'U'])) {
                    $applicable = false;
                    break;
                }
                
                if ($column === 'unisex' && !in_array($code, ['D', 'M'])) {
                    $applicable = false;
                    break;
                }
                
                if ($column === 'specific_attributes->application' && $code !== 'PM') {
                    $applicable = false;
                    break;
                }
                
                if ($column === 'specific_attributes->genre' && $code !== 'U') {
                    $applicable = false;
                    break;
                }
            }
            
            if ($applicable) {
                $availableColumns[] = $column;
            }
        }
        
        $this->availableColumns = $availableColumns;
        
        // Charger les colonnes visibles depuis les préférences utilisateur
        $preferencesKey = 'products.columns.' . implode('_', $familyCodes);
        
        if (Auth::check()) {
            $savedColumns = Auth::user()->getPreference($preferencesKey);
            
            if ($savedColumns) {
                $this->visibleColumns = array_intersect($savedColumns, $this->availableColumns);
            } else {
                // Utiliser les colonnes par défaut ou les colonnes communes
                $this->visibleColumns = $commonColumns;
                
                // Ajouter quelques colonnes supplémentaires pertinentes si disponibles
                foreach (['zone_geographique', 'famille_olfactive'] as $col) {
                    if (in_array($col, $this->availableColumns)) {
                        $this->visibleColumns[] = $col;
                    }
                }
            }
        } else {
            $this->visibleColumns = $commonColumns;
        }
    }

    // Le reste du composant reste similaire, mais avec des adaptations pour gérer les produits de plusieurs familles

    public function render()
    {
        // Si aucune famille n'est sélectionnée, retourner une liste vide
        if (empty($this->selectedFamilies)) {
            return view('livewire.products.product-list', [
                'products' => null,
                'referenceData' => [],
            ]);
        }

        // Construire la requête de base pour les produits des familles sélectionnées
        $query = Product::query()
            ->whereIn('product_family_id', $this->selectedFamilies);

        // Appliquer la recherche si elle est définie
        if (!empty($this->search)) {
            $query->where(function ($q) {
                // Recherche de base sur les champs communs
                $q->where('type', 'like', '%' . $this->search . '%')
                  ->orWhere('nom', 'like', '%' . $this->search . '%')
                  ->orWhere('marque', 'like', '%' . $this->search . '%');
                
                // Recherche sur les attributs spécifiques
                $q->orWhereHas('zoneGeos', function($sq) {
                    $sq->where('zone_geo_value', 'like', '%' . $this->search . '%');
                });
                
                $q->orWhereHas('olfactiveFamilies', function($sq) {
                    $sq->where('famille_value', 'like', '%' . $this->search . '%');
                });
            });
        }

        // Appliquer les filtres avancés s'ils sont définis
        foreach ($this->filters as $field => $value) {
            if (!empty($value)) {
                if (strpos($field, 'specific_attributes->') === 0) {
                    // Pour les attributs spécifiques stockés en JSON
                    $path = str_replace('specific_attributes->', '', $field);
                    $query->whereJsonContains('specific_attributes->' . $path, $value);
                } else if ($field === 'zone_geographique' || $field === 'famille_olfactive') {
                    // Pour les relations many-to-many
                    if ($field === 'zone_geographique') {
                        $query->whereHas('zoneGeos', function($q) use ($value) {
                            $q->where('zone_geo_value', $value);
                        });
                    } else {
                        $query->whereHas('olfactiveFamilies', function($q) use ($value) {
                            $q->where('famille_value', $value);
                        });
                    }
                } else {
                    // Pour les champs simples
                    $query->where($field, $value);
                }
            }
        }

        // Trier les résultats
        if (strpos($this->sortField, 'specific_attributes->') === 0) {
            $path = str_replace('specific_attributes->', '', $this->sortField);
            $query->orderByJson('specific_attributes->' . $path, $this->sortDirection);
        } else {
            $query->orderBy($this->sortField, $this->sortDirection);
        }

        // Récupérer les données de référence pour les filtres
        $referenceData = [
            'zone_geographique' => ReferenceData::getByType('zone_geo'),
            'famille_olfactive' => ReferenceData::getByType('famille_olfactive'),
            'description_olfactive' => ReferenceData::getByType('description_olfactive'),
            'application' => ReferenceData::getByType('application'),
        ];

        return view('livewire.products.product-list', [
            'products' => $query->paginate($this->perPage),
            'referenceData' => $referenceData,
            'families' => $this->allFamilies
        ]);
    }

}