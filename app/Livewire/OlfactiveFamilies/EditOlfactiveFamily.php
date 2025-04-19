<?php

namespace App\Livewire\OlfactiveFamilies;

use App\Models\OlfactiveFamily;
use App\Traits\HasPermissions;
use Livewire\Component;

class EditOlfactiveFamily extends Component
{
    use HasPermissions;
    
    public OlfactiveFamily $olfactiveFamily;
    public $olfactive_family_name;
    public $olfactive_family_desc;
    public $olfactive_family_active;
    
    protected function rules()
    {
        return [
            'olfactive_family_name' => 'required|string|max:255|unique:olfactive_families,olfactive_family_name,' . $this->olfactiveFamily->id,
            'olfactive_family_desc' => 'nullable|string',
            'olfactive_family_active' => 'boolean',
        ];
    }

    public function mount(OlfactiveFamily $olfactiveFamily)
    {
        $this->olfactiveFamily = $olfactiveFamily;
        $this->olfactive_family_name = $olfactiveFamily->olfactive_family_name;
        $this->olfactive_family_desc = $olfactiveFamily->olfactive_family_desc;
        $this->olfactive_family_active = $olfactiveFamily->olfactive_family_active;
    }

    public function update()
    {
        $this->permAuthorize('edit data');
        
        $this->validate();
        
        try {
            $this->olfactiveFamily->update([
                'olfactive_family_name' => $this->olfactive_family_name,
                'olfactive_family_desc' => $this->olfactive_family_desc,
                'olfactive_family_active' => $this->olfactive_family_active,
            ]);
            
            session()->flash('message', __('Famille olfactive mise à jour avec succès.'));
            
            return redirect()->route('olfactive-families.index');
        } catch (\Exception $e) {
            session()->flash('error', __('Erreur lors de la mise à jour de la famille olfactive: ') . $e->getMessage());
        }
    }

    public function render()
    {
        $this->permAuthorize('edit data');
        
        return view('livewire.olfactive-families.edit-olfactive-family');
    }
}