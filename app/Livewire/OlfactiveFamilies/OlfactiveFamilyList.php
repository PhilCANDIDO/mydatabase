<?php

namespace App\Livewire\OlfactiveFamilies;

use App\Models\OlfactiveFamily;
use App\Traits\HasPermissions;
use Livewire\Component;
use Livewire\WithPagination;

class OlfactiveFamilyList extends Component
{
    use WithPagination, HasPermissions;
    
    public $search = '';
    public $sortField = 'olfactive_family_name';
    public $sortDirection = 'asc';
    public $perPage = 10;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'olfactive_family_name'],
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
        
        $olfactiveFamilies = OlfactiveFamily::query()
            ->when($this->search, function ($query) {
                return $query->where('olfactive_family_name', 'like', '%' . $this->search . '%')
                    ->orWhere('olfactive_family_desc', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
            
        return view('livewire.olfactive-families.olfactive-family-list', [
            'olfactiveFamilies' => $olfactiveFamilies
        ]);
    }
}