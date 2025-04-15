<?php

namespace App\Livewire\ReferenceData;

use App\Models\ReferenceData;
use Livewire\Component;
use Livewire\WithPagination;

class ReferenceDataList extends Component
{
    use WithPagination;

    public $search = '';
    public $typeFilter = 'all';
    public $perPage = 10;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingTypeFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $types = ReferenceData::select('type')->distinct()->orderBy('type')->pluck('type');
        
        $query = ReferenceData::query();
        
        if ($this->typeFilter !== 'all') {
            $query->where('type', $this->typeFilter);
        }
        
        if ($this->search) {
            $query->where(function($q) {
                $q->where('type', 'like', '%' . $this->search . '%')
                  ->orWhere('value', 'like', '%' . $this->search . '%')
                  ->orWhere('label', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }
        
        $referenceData = $query->orderBy('type')
                              ->orderBy('order')
                              ->orderBy('label')
                              ->paginate($this->perPage);
        
        return view('livewire.reference-data.reference-data-list', [
            'referenceData' => $referenceData,
            'types' => $types
        ]);
    }
}