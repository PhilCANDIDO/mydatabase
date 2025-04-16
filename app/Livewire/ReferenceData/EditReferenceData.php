<?php

namespace App\Livewire\ReferenceData;

use App\Models\ReferenceData;
use Livewire\Component;

class EditReferenceData extends Component
{
    public ReferenceData $referenceData;
    
    public $type;
    public $value;
    public $label;
    public $description;
    public $order;
    public $active;
    public $is_multiple;
    
    // Liste des types autorisés
    protected $allowedTypes = [
        'application' => 'Application',
        'famille_olfactive' => 'Famille olfactive',
        'zone_geo' => 'Zone Géographique'
    ];

    protected function rules()
    {
        return [
            'type' => 'required|string|max:50',
            'value' => 'required|string|max:100',
            'label' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'active' => 'boolean',
            'is_multiple' => 'boolean',
        ];
    }

    public function mount(ReferenceData $referenceData)
    {
        $this->referenceData = $referenceData;
        $this->type = $referenceData->type;
        $this->value = $referenceData->value;
        $this->label = $referenceData->label;
        $this->description = $referenceData->description;
        $this->order = $referenceData->order;
        $this->active = $referenceData->active;
        $this->is_multiple = $referenceData->is_multiple;
    }

    public function update()
    {
        $this->validate();
        
        // Vérification que le type est autorisé
        if (!array_key_exists($this->type, $this->allowedTypes)) {
            session()->flash('error', __('Ce type de référence n\'est pas autorisé.'));
            return;
        }

        // Vérification d'unicité de la paire type/value si modifiée
        if ($this->type !== $this->referenceData->type || $this->value !== $this->referenceData->value) {
            $exists = ReferenceData::where('type', $this->type)
                ->where('value', $this->value)
                ->where('id', '!=', $this->referenceData->id)
                ->exists();
                
            if ($exists) {
                session()->flash('error', __('Cette valeur existe déjà pour ce type de référence.'));
                return;
            }
        }

        $this->referenceData->update([
            'type' => $this->type,
            'value' => $this->value,
            'label' => $this->label,
            'description' => $this->description,
            'order' => $this->order,
            'active' => $this->active,
            'is_multiple' => $this->is_multiple,
        ]);

        session()->flash('success', __('Donnée de référence mise à jour avec succès.'));
        return redirect()->route('reference-data.index');
    }

    public function render()
    {
        return view('livewire.reference-data.edit-reference-data', [
            'allowedTypes' => $this->allowedTypes,
        ]);
    }
}