<?php

namespace App\Livewire\ZoneGeos;

use App\Models\ZoneGeo;
use App\Traits\HasPermissions;
use Livewire\Component;

class EditZoneGeo extends Component
{
    use HasPermissions;
    
    public ZoneGeo $zoneGeo;
    public $zone_geo_name;
    public $zone_geo_desc;
    public $zone_geo_active;
    
    protected function rules()
    {
        return [
            'zone_geo_name' => 'required|string|max:255|unique:zone_geos,zone_geo_name,' . $this->zoneGeo->id,
            'zone_geo_desc' => 'nullable|string',
            'zone_geo_active' => 'boolean',
        ];
    }

    public function mount(ZoneGeo $zoneGeo)
    {
        $this->zoneGeo = $zoneGeo;
        $this->zone_geo_name = $zoneGeo->zone_geo_name;
        $this->zone_geo_desc = $zoneGeo->zone_geo_desc;
        $this->zone_geo_active = $zoneGeo->zone_geo_active;
    }

    public function update()
    {
        $this->permAuthorize('edit data');
        
        $this->validate();
        
        try {
            $this->zoneGeo->update([
                'zone_geo_name' => $this->zone_geo_name,
                'zone_geo_desc' => $this->zone_geo_desc,
                'zone_geo_active' => $this->zone_geo_active,
            ]);
            
            session()->flash('message', __('Zone géographique mise à jour avec succès.'));
            
            return redirect()->route('zone-geos.index');
        } catch (\Exception $e) {
            session()->flash('error', __('Erreur lors de la mise à jour de la zone géographique: ') . $e->getMessage());
        }
    }

    public function render()
    {
        $this->permAuthorize('edit data');
        
        return view('livewire.zone-geos.edit-zone-geo');
    }
}