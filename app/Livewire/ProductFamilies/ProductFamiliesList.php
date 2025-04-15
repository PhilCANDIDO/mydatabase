<?php

namespace App\Livewire\ProductFamilies;

use App\Models\ProductFamily;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Session;

class ProductFamiliesList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'name';
    public $sortDirection = 'asc';

    protected $queryString = ['search', 'sortField', 'sortDirection'];

    public function mount()
    {
        // Restaurer les préférences de pagination depuis la session
        $this->perPage = Session::get('productFamilies.perPage', 10);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage($value)
    {
        Session::put('productFamilies.perPage', $value);
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
    }

    public function deleteConfirm($familyId)
    {
        $this->dispatch('showDeleteConfirmation', familyId: $familyId);
    }

    public function deleteFamily($familyId)
    {
        $family = ProductFamily::findOrFail($familyId);
        
        // Vérifier si la famille a des produits associés
        if ($family->products()->count() > 0) {
            session()->flash('error', __('Impossible de supprimer cette famille car elle contient des produits.'));
            return;
        }

        $family->delete();
        session()->flash('success', __('Famille de produits supprimée avec succès.'));
    }

    public function render()
    {
        $query = ProductFamily::query();
        
        if ($this->search) {
            $query->where(function($q) {
                $q->where('code', 'like', '%' . $this->search . '%')
                  ->orWhere('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }
        
        $families = $query->orderBy($this->sortField, $this->sortDirection)
                          ->paginate($this->perPage);

        return view('livewire.product-families.product-families-list', [
            'families' => $families
        ]);
    }
}