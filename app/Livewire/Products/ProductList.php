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
        'deleteProduct' => 'handleDeleteProduct'
    ];

    public function mount(ProductFamily $family = null)
    {
        $this->family = $family;

        // Initialiser les étiquettes des colonnes
        $this->initializeColumnLabels();
        
        if ($family) {
            // Initialiser les colonnes selon la famille
            $this->initializeColumns();
            
            // Charger les préférences de pagination de l'utilisateur
            if (Auth::check()) {
                $paginationKey = 'products.' . $family->code . '.per_page';
                $this->perPage = Auth::user()->getPreference($paginationKey, 10);
            }
        }
    }

    protected function initializeColumnLabels()
    {
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
        $familyCode = $this->family->code;
        
        // Définir toutes les colonnes disponibles pour cette famille
        $this->availableColumns = array_merge(
            $this->defaultColumns[$familyCode] ?? [],
            ['description_olfactive_tete_1', 'description_olfactive_coeur_1', 'description_olfactive_fond_1']
        );
        
        // Charger les colonnes visibles depuis les préférences utilisateur
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

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilters()
    {
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
    
    public function toggleColumnSelector()
    {
        $this->showColumnSelector = !$this->showColumnSelector;
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
    
    public function confirmDelete($productId, $productName)
    {
        if ($this->permUserCan('delete data')) {
            $this->dispatch('openModal', 'products.delete-product-modal', [
                'productId' => $productId,
                'productName' => $productName
            ]);
        }
    }
    
    public function handleDeleteProduct($productId)
    {
        $this->permAuthorize('delete data');
        
        $product = Product::find($productId);
        if ($product) {
            $product->delete();
            session()->flash('success', __('Produit supprimé avec succès.'));
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
                    if (strpos($field, 'specific_attributes->') === 0) {
                        // Pour les attributs spécifiques stockés en JSON
                        $path = str_replace('specific_attributes->', '', $field);
                        $q->orWhereJsonContains('specific_attributes->' . $path, 'LIKE', '%' . $this->search . '%');
                    } else {
                        $q->orWhere($field, 'like', '%' . $this->search . '%');
                    }
                }
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
        $referenceData = [];
        if ($this->family) {
            if (in_array($this->family->code, ['PM', 'D', 'M', 'U'])) {
                $referenceData['zone_geographique'] = ReferenceData::getByType('zone_geo');
                $referenceData['famille_olfactive'] = ReferenceData::getByType('famille_olfactive');
            }
            
            if ($this->family->code === 'PM') {
                $referenceData['application'] = ReferenceData::getByType('application');
            }
            
            if (in_array($this->family->code, ['PM', 'D', 'M', 'U'])) {
                $referenceData['description_olfactive'] = ReferenceData::getByType('description_olfactive');
            }
        }

        return view('livewire.products.product-list', [
            'products' => $query->paginate($this->perPage),
            'referenceData' => $referenceData
        ]);
    }
}