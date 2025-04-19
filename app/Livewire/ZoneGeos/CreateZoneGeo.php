<?php

namespace App\Livewire\ZoneGeos;

use App\Models\ZoneGeo;
use App\Traits\HasPermissions;
use Livewire\Component;

class CreateZoneGeo extends Component
{
    use HasPermissions;
    
    public $zone_geo_name = '';
    public $zone_geo_desc = '';
    public $zone_geo_active = true;
    
    protected $rules = [
        'zone_geo_name' => 'required|string|max:255|unique:zone_geos',
        'zone_geo_desc' => 'nullable|string',
        'zone_geo_active' => 'boolean',
    ];

    public function create()
    {
        $this->permAuthorize('add data');
        
        $this->validate();
        
        try {
            ZoneGeo::create([
                'zone_geo_name' => $this->zone_geo_name,
                'zone_geo_desc' => $this->zone_geo_desc,
                'zone_geo_active' => $this->zone_geo_active,
            ]);
            
            session()->flash('message', __('Zone géographique créée avec succès.'));
            
            return redirect()->route('zone-geos.index');
        } catch (\Exception $e) {
            session()->flash('error', __('Erreur lors de la création de la zone géographique: ') . $e->getMessage());
        }
    }

    public function render()
    {
        $this->permAuthorize('add data');
        
        return view('livewire.zone-geos.create-zone-geo');
    }
}