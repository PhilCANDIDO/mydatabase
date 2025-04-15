<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\ProductFamily;
use App\Models\ReferenceData;
use App\Traits\HasPermissions;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination, HasPermissions;

    public $family;
    public $search = '';
    public $perPage = 10;
    public $sortField = 'type'; // Tri par défaut sur le champ "Type"
    public $sortDirection = 'asc';
    public $filters = [];

    // Les champs à rechercher pour chaque famille (code)
    protected $searchableFields = [
        'W' => ['type', 'nom'],
        'PM' => ['type', 'nom', 'marque', 'zone_geographique', 'famille_olfactive'],
        'D' => ['type', 'nom', 'marque', 'zone_geographique', 'famille_olfactive'],
        'M' => ['type', 'nom', 'marque', 'zone_geographique', 'famille_olfactive'],
        'U' => ['type', 'nom', 'marque', 'zone_geographique', 'famille_olfactive'],
    ];

    public function mount(ProductFamily $family = null)
    {
        $this->family = $family;
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
        ]);
    }
}