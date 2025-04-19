<?php

namespace App\Livewire\OlfactiveFamilies;

use App\Models\OlfactiveFamily;
use App\Traits\HasPermissions;
use Livewire\Component;

class CreateOlfactiveFamily extends Component
{
    use HasPermissions;
    
    public $olfactive_family_name = '';
    public $olfactive_family_desc = '';
    public $olfactive_family_active = true;
    
    protected $rules = [
        'olfactive_family_name' => 'required|string|max:255|unique:olfactive_families',
        'olfactive_family_desc' => 'nullable|string',
        'olfactive_family_active' => 'boolean',
    ];

    public function create()
    {
        $this->permAuthorize('add data');
        
        $this->validate();
        
        try {
            OlfactiveFamily::create([
                'olfactive_family_name' => $this->olfactive_family_name,
                'olfactive_family_desc' => $this->olfactive_family_desc,
                'olfactive_family_active' => $this->olfactive_family_active,
            ]);
            
            session()->flash('message', __('Famille olfactive créée avec succès.'));
            
            return redirect()->route('olfactive-families.index');
        } catch (\Exception $e) {
            session()->flash('error', __('Erreur lors de la création de la famille olfactive: ') . $e->getMessage());
        }
    }

    public function render()
    {
        $this->permAuthorize('add data');
        
        return view('livewire.olfactive-families.create-olfactive-family');
    }
}