<?php

namespace App\Livewire\ProductFamilies;

use App\Models\ProductFamily;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Session;

class ManageProductFamilies extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'name';
    public $sortDirection = 'asc';
    
    // État du modal
    public $isModalOpen = false;
    public $modalMode = 'create'; // 'create', 'edit', ou 'delete'
    public $selectedFamily = null;
    
    // Champs du formulaire
    public $familyCode = '';
    public $familyName = '';
    public $familyDescription = '';
    public $familyActive = true;

    protected $listeners = [
        'refreshProductFamilies' => '$refresh',
        'closeModal' => 'closeModal'
    ];

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

    public function openCreateModal()
    {
        $this->resetValidation();
        $this->resetForm();
        $this->modalMode = 'create';
        $this->isModalOpen = true;
    }

    public function openEditModal($familyId)
    {
        $this->resetValidation();
        $this->modalMode = 'edit';
        $this->selectedFamily = ProductFamily::findOrFail($familyId);
        
        $this->familyCode = $this->selectedFamily->code;
        $this->familyName = $this->selectedFamily->name;
        $this->familyDescription = $this->selectedFamily->description;
        $this->familyActive = $this->selectedFamily->active;
        
        $this->isModalOpen = true;
    }

    public function openDeleteModal($familyId)
    {
        $this->modalMode = 'delete';
        $this->selectedFamily = ProductFamily::findOrFail($familyId);
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function resetForm()
    {
        $this->familyCode = '';
        $this->familyName = '';
        $this->familyDescription = '';
        $this->familyActive = true;
        $this->selectedFamily = null;
    }

    public function create()
    {
        $this->validate([
            'familyCode' => 'required|string|max:10|unique:product_families,code',
            'familyName' => 'required|string|max:255',
            'familyDescription' => 'nullable|string',
            'familyActive' => 'boolean'
        ]);

        ProductFamily::create([
            'code' => $this->familyCode,
            'name' => $this->familyName,
            'description' => $this->familyDescription,
            'active' => $this->familyActive
        ]);

        $this->closeModal();
        $this->resetForm();
        session()->flash('success', __('Famille de produits créée avec succès.'));
    }

    public function update()
    {
        $this->validate([
            'familyName' => 'required|string|max:255',
            'familyDescription' => 'nullable|string',
            'familyActive' => 'boolean'
        ]);

        $this->selectedFamily->update([
            'name' => $this->familyName,
            'description' => $this->familyDescription,
            'active' => $this->familyActive
        ]);

        $this->closeModal();
        $this->resetForm();
        session()->flash('success', __('Famille de produits mise à jour avec succès.'));
    }

    public function delete()
    {
        // Vérifier si la famille a des produits associés
        if ($this->selectedFamily->products()->count() > 0) {
            session()->flash('error', __('Impossible de supprimer cette famille car elle contient des produits.'));
            $this->closeModal();
            return;
        }

        $this->selectedFamily->delete();
        $this->closeModal();
        $this->resetForm();
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

        return view('livewire.product-families.manage-product-families', [
            'families' => $families
        ]);
    }
}