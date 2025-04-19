<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\ProductFamily;
use App\Models\OlfactiveFamily;
use App\Models\OlfactiveNote;
use App\Models\ZoneGeo;
use App\Models\Application;
use App\Traits\HasPermissions;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination, HasPermissions;
    
    // Filtres de recherche et pagination
    public $search = '';
    public $perPage = 10;
    public $sortField = 'product_type';
    public $sortDirection = 'asc';
    
    // Filtres de familles de produits
    public $selectedFamilies = [];
    
    // État d'affichage des panneaux
    public $showColumnsPanel = false;
    public $showFiltersPanel = false;
    
    // Colonnes visibles
    public $visibleColumns = [
        'product_type' => true,
        'product_name' => true,
        'product_marque' => true,
        'application_id' => true,
        'product_annee_sortie' => true,
        'zone_geo' => false,
        'olfactive_family' => false,
        'product_unisex' => false,
        'product_avatar' => false,
        'product_genre' => false,
        'head_note_1' => false,
        'head_note_2' => false,
        'heart_note_1' => false,
        'heart_note_2' => false,
        'base_note_1' => false,
        'base_note_2' => false,
    ];
    
    // Filtres avancés
    public $filters = [
        'application_id' => null,
        'product_annee_sortie' => null,
        'zone_geo' => null,
        'olfactive_family' => null,
        'product_unisex' => null,
        'product_genre' => null,
        'head_note' => null,
        'heart_note' => null,
        'base_note' => null,
    ];
    
    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'product_type'],
        'sortDirection' => ['except' => 'asc'],
    ];

    public function mount()
    {
        // Initialiser toutes les familles comme sélectionnées par défaut
        $this->selectedFamilies = ProductFamily::where('product_family_active', true)
            ->pluck('id')
            ->toArray();
    }
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        
        $this->sortField = $field;
    }
    
    public function toggleColumnsPanel()
    {
        $this->showColumnsPanel = !$this->showColumnsPanel;
        if ($this->showColumnsPanel) {
            $this->showFiltersPanel = false;
        }
    }
    
    public function toggleFiltersPanel()
    {
        $this->showFiltersPanel = !$this->showFiltersPanel;
        if ($this->showFiltersPanel) {
            $this->showColumnsPanel = false;
        }
    }
    
    public function resetColumns()
    {
        $this->visibleColumns = [
            'product_type' => true,
            'product_name' => true,
            'product_marque' => true,
            'application_id' => true,
            'product_annee_sortie' => true,
            'zone_geo' => false,
            'olfactive_family' => false,
            'product_unisex' => false,
            'product_avatar' => false,
            'product_genre' => false,
            'head_note_1' => false,
            'head_note_2' => false,
            'heart_note_1' => false,
            'heart_note_2' => false,
            'base_note_1' => false,
            'base_note_2' => false,
        ];
    }
    
    public function resetFilters()
    {
        $this->filters = [
            'application_id' => null,
            'product_annee_sortie' => null,
            'zone_geo' => null,
            'olfactive_family' => null,
            'product_unisex' => null,
            'product_genre' => null,
            'head_note' => null,
            'heart_note' => null,
            'base_note' => null,
        ];
    }
    
    public function copyToClipboard($text)
    {
        $this->dispatch('copy-to-clipboard', text: $text);
    }
    
    public function render()
    {
        $this->permAuthorize('view data');
        
        $query = Product::query()
            ->when(count($this->selectedFamilies) > 0, function ($query) {
                return $query->whereIn('product_family_id', $this->selectedFamilies);
            })
            ->when($this->search, function ($query) {
                return $query->where(function ($query) {
                    $query->where('product_type', 'like', '%' . $this->search . '%')
                          ->orWhere('product_name', 'like', '%' . $this->search . '%')
                          ->orWhere('product_marque', 'like', '%' . $this->search . '%');
                });
            });
        
        // Appliquer les filtres avancés
        if ($this->filters['application_id']) {
            $query->where('application_id', $this->filters['application_id']);
        }
        
        if ($this->filters['product_annee_sortie']) {
            $query->where('product_annee_sortie', $this->filters['product_annee_sortie']);
        }
        
        if ($this->filters['zone_geo']) {
            $query->whereHas('zoneGeos', function ($q) {
                $q->where('zone_geo_id', $this->filters['zone_geo']);
            });
        }
        
        if ($this->filters['olfactive_family']) {
            $query->whereHas('olfactiveFamilies', function ($q) {
                $q->where('olfactive_family_id', $this->filters['olfactive_family']);
            });
        }
        
        if ($this->filters['product_unisex'] !== null) {
            $query->where('product_unisex', $this->filters['product_unisex']);
        }
        
        if ($this->filters['product_genre']) {
            $query->where('product_genre', $this->filters['product_genre']);
        }
        
        // Filtres pour les notes olfactives
        foreach (['head', 'heart', 'base'] as $position) {
            if ($this->filters["{$position}_note"]) {
                $query->whereHas('olfactiveNotes', function ($q) use ($position) {
                    $q->where('olfactive_note_id', $this->filters["{$position}_note"])
                      ->where('olfactive_note_position', $position);
                });
            }
        }
        
        // Tri
        $query->orderBy($this->sortField, $this->sortDirection);
        
        // Pagination
        $products = $query->paginate($this->perPage);
        
        // Récupérer les données pour les filtres et dropdowns
        $productFamilies = ProductFamily::where('product_family_active', true)->get();
        $applications = Application::where('application_active', true)->get();
        $zoneGeos = ZoneGeo::where('zone_geo_active', true)->get();
        $olfactiveFamilies = OlfactiveFamily::where('olfactive_family_active', true)->get();
        $olfactiveNotes = OlfactiveNote::where('olfactive_note_active', true)->get();
        
        // Famille affichées (pour les badges)
        $displayedFamilies = ProductFamily::whereIn('id', $this->selectedFamilies)->get();
        
        return view('livewire.products.product-list', [
            'products' => $products,
            'productFamilies' => $productFamilies,
            'applications' => $applications,
            'zoneGeos' => $zoneGeos,
            'olfactiveFamilies' => $olfactiveFamilies,
            'olfactiveNotes' => $olfactiveNotes,
            'displayedFamilies' => $displayedFamilies,
        ]);
    }

    public function importProducts()
    {
        $this->permAuthorize('import data');
        
        // Rediriger vers la page d'importation ou afficher un modal
        $this->redirectRoute('products.import');
    }
    
    public function exportProducts()
    {
        $this->permAuthorize('export data');
        
    }
}