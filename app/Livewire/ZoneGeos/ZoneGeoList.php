<?php

namespace App\Livewire\ZoneGeos;

use App\Models\ZoneGeo;
use App\Traits\HasPermissions;
use Livewire\Component;
use Livewire\WithPagination;

class ZoneGeoList extends Component
{
    use WithPagination, HasPermissions;
    
    public $search = '';
    public $sortField = 'zone_geo_name';
    public $sortDirection = 'asc';
    public $perPage = 10;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'zone_geo_name'],
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
        
        $zoneGeos = ZoneGeo::query()
            ->when($this->search, function ($query) {
                return $query->where('zone_geo_name', 'like', '%' . $this->search . '%')
                    ->orWhere('zone_geo_desc', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
            
        return view('livewire.zone-geos.zone-geo-list', [
            'zoneGeos' => $zoneGeos
        ]);
    }
}