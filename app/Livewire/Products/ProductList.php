<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\ProductFamily;
use App\Models\ReferenceData;
use App\Traits\HasPermissions;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ProductList extends Component
{
    use WithPagination, HasPermissions;

    public $family;
    public $search = '';
    public $perPage = 10;
    public $sortField = 'type'; // Tri par défaut sur le champ "Type"
    public $sortDirection = 'asc';
    public $filters = [];
    public $showColumnSelector = false; // Pour montrer/cacher le sélecteur de colonnes
    public $availableColumns = [];
    public $visibleColumns = [];

    // Les champs à rechercher pour chaque famille (code)
    protected $searchableFields = [
        'W' => ['type', 'nom'],
        'PM' => ['type', 'nom', 'marque', 'zone_geographique', 'famille_olfactive'],
        'D' => ['type', 'nom', 'marque', 'zone_geographique', 'famille_olfactive'],
        'M' => ['type', 'nom', 'marque', 'zone_geographique', 'famille_olfactive'],
        'U' => ['type', 'nom', 'marque', 'zone_geographique', 'famille_olfactive'],
    ];

    // Colonnes disponibles par défaut pour chaque famille
    protected $defaultColumns = [
        'W' => ['type', 'nom'],
        'PM' => ['type', 'nom', 'marque', 'specific_attributes->application', 'famille_olfactive'],
        'D' => ['type', 'nom', 'marque', 'zone_geographique', 'date_sortie', 'famille_olfactive'],
        'M' => ['type', 'nom', 'marque', 'zone_geographique', 'date_sortie', 'famille_olfactive'],
        'U' => ['type', 'nom', 'marque', 'zone_geographique', 'date_sortie', 'specific_attributes->genre'],
    ];

    // Noms des colonnes pour l'affichage
    protected $columnLabels = [
        'type' => 'Type',
        'nom' => 'Nom',
        'marque' => 'Marque',
        'zone_geographique' => 'Zone géographique',
        'famille_olfactive' => 'Famille olfactive',
        'date_sortie' => 'Année',
        'specific_attributes->application' => 'Application',
        'specific_attributes->genre' => 'Genre',
        'description_olfactive_tete_1' => 'Note de tête 1',
        'description_olfactive_tete_2' => 'Note de tête 2',
        'description_olfactive_coeur_1' => 'Note de cœur 1',
        'description_olfactive_coeur_2' => 'Note de cœur 2',
        'description_olfactive_fond_1' => 'Note de fond 1',
        'description_olfactive_fond_2' => 'Note de fond 2',
    ];

    protected $listeners = ['refreshProducts' => '$refresh'];

    public function mount(ProductFamily $family = null)
    {
        $this->family = $family;

        // Initialiser les colonnes disponibles en fonction de la famille
        if ($family) {
            $this->initializeColumns();
            
            // Charger la préférence de pagination
            if (Auth::check()) {
                $paginationKey = 'products.' . $family->code . '.per_page';
                $this->perPage = Auth::user()->getPreference($paginationKey, 10);
            }
        }
    }

    protected function initializeColumns()
    {
        $familyCode = $this->family->code;
        
        // Définir toutes les colonnes disponibles pour cette famille
        $this->availableColumns = array_merge(
            $this->defaultColumns[$familyCode] ?? [],
            // Ajouter d'autres colonnes spécifiques si nécessaire
            ['description_olfactive_tete_1', 'description_olfactive_coeur_1', 'description_olfactive_fond_1']
        );
        
        // Charger les colonnes visibles depuis les préférences de l'utilisateur
        if (Auth::check()) {
            $columnsKey = 'products.' . $familyCode . '.columns';
            $savedColumns = Auth::user()->getPreference($columnsKey);
            
            if ($savedColumns) {
                $this->visibleColumns = $savedColumns;
            } else {
                // Utiliser les colonnes par défaut si aucune préférence n'est définie
                $this->visibleColumns = $this->defaultColumns[$familyCode] ?? [];
            }
        } else {
            // Utiliser les colonnes par défaut pour les utilisateurs non connectés
            $this->visibleColumns = $this->defaultColumns[$familyCode] ?? [];
        }
    }

    public function updatedPerPage($value)
    {
        if ($this->family && Auth::check()) {
            $paginationKey = 'products.' . $this->family->code . '.per_page';
            Auth::user()->setPreference($paginationKey, $value);
        }
        
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilters()
    {
        $this->resetPage();
    }
    
    public function toggleColumnVisibility($column)
    {
        $index = array_search($column, $this->visibleColumns);
        
        if ($index !== false) {
            // Retirer la colonne si elle est visible
            unset($this->visibleColumns[$index]);
            $this->visibleColumns = array_values($this->visibleColumns); // Réindexer le tableau
        } else {
            // Ajouter la colonne si elle n'est pas visible
            $this->visibleColumns[] = $column;
        }
        
        // Sauvegarder les préférences
        if ($this->family && Auth::check()) {
            $columnsKey = 'products.' . $this->family->code . '.columns';
            Auth::user()->setPreference($columnsKey, $this->visibleColumns);
        }
    }
    
    public function toggleColumnSelector()
    {
        $this->showColumnSelector = !$this->showColumnSelector;
    }
    
    public function resetColumns()
    {
        if ($this->family) {
            $familyCode = $this->family->code;
            $this->visibleColumns = $this->defaultColumns[$familyCode] ?? [];
            
            // Sauvegarder les préférences
            if (Auth::check()) {
                $columnsKey = 'products.' . $familyCode . '.columns';
                Auth::user()->setPreference($columnsKey, $this->visibleColumns);
            }
        }
    }
    
    public function render()
    {
        // Si aucune famille n'est sélectionnée, afficher un message
        if (!$this->family) {
            return view('livewire.products.product-list', [
                'products' => null,
                'referenceData' => [],
            ]);
        }

        // Construire la requête de base pour les produits de cette famille
        $query = Product::query()
            ->where('product_family_id', $this->family->id);

        // Appliquer la recherche si elle est définie
        if (!empty($this->search)) {
            $searchableFields = $this->searchableFields[$this->family->code] ?? ['type', 'nom'];
            
            $query->where(function ($q) use ($searchableFields) {
                foreach ($searchableFields as $field) {
                    $q->orWhere($field, 'like', '%' . $this->search . '%');
                }
            });
        }

        // Appliquer les filtres s'ils sont définis
        foreach ($this->filters as $field => $value) {
            if (!empty($value)) {
                if ($field === 'zone_geographique') {
                    // Pour les champs multi-sélection stockés sous forme de JSON
                    $query->where($field, 'like', '%' . $value . '%');
                } else if (strpos($field, 'specific_attributes->') === 0) {
                    // Pour les attributs spécifiques stockés en JSON
                    $path = str_replace('specific_attributes->', '', $field);
                    $query->whereJsonContains('specific_attributes->' . $path, $value);
                } else {
                    $query->where($field, $value);
                }
            }
        }
        
        // Trier les résultats
        $query->orderBy($this->sortField, $this->sortDirection);
        
        // Récupérer les données de référence nécessaires pour les filtres
        $referenceData = [];
        if ($this->family) {
            // Récupérer les différentes listes selon la famille
            if (in_array($this->family->code, ['PM', 'D', 'M', 'U'])) {
                $referenceData['zone_geographique'] = ReferenceData::getByType('zone_geo');
                $referenceData['famille_olfactive'] = ReferenceData::getByType('famille_olfactive');
            }
            
            // Pour la famille PM uniquement
            if ($this->family->code === 'PM') {
                $referenceData['application'] = ReferenceData::getByType('application');
            }
            
            // Pour les descriptions olfactives
            if (in_array($this->family->code, ['PM', 'D', 'M', 'U'])) {
                $referenceData['description_olfactive'] = ReferenceData::getByType('description_olfactive');
            }
        }
        
        return view('livewire.products.product-list', [
            'products' => $query->paginate($this->perPage),
            'referenceData' => $referenceData,
            'columnLabels' => $this->columnLabels,
        ]);
    }

    public function viewProduct($productId)
    {
        $this->dispatch('openModal', [
            'component' => 'products.product-detail-modal',
            'arguments' => [
                'productId' => $productId
            ]
        ]);
    }

    public function confirmDelete($productId, $productName)
    {
        $this->dispatch('openModal', [
            'component' => 'products.delete-product-modal',
            'arguments' => [
                'productId' => $productId,
                'productName' => $productName
            ]
        ]);
    }

}