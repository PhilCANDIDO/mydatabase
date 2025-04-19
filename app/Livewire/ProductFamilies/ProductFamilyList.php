<?php

namespace App\Livewire\ProductFamilies;

use App\Models\ProductFamily;
use App\Traits\HasPermissions;
use Livewire\Component;
use Livewire\WithPagination;

class ProductFamilyList extends Component
{
    use WithPagination, HasPermissions;
    
    public $search = '';
    public $sortField = 'product_family_name';
    public $sortDirection = 'asc';
    public $perPage = 10;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'product_family_name'],
        'sortDirection' => ['except' => 'asc'],
        'perPage' => ['except' => 10],
    ];

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

    public function render()
    {
        $this->permAuthorize('view data');
        
        $productFamilies = ProductFamily::query()
            ->when($this->search, function ($query) {
                return $query->where('product_family_name', 'like', '%' . $this->search . '%')
                    ->orWhere('product_family_desc', 'like', '%' . $this->search . '%')
                    ->orWhere('product_family_code', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
            
        return view('livewire.product-families.product-family-list', [
            'productFamilies' => $productFamilies
        ]);
    }
}