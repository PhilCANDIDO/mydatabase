<?php

namespace App\Livewire\ReferenceData;

use App\Models\ReferenceData;
use Livewire\Component;

class CreateReferenceData extends Component
{
    public $type = '';
    public $value = '';
    public $label = '';
    public $description = '';
    public $order = 0;
    public $active = true;
    public $is_multiple = false;

    // Liste des types autorisés
    protected $allowedTypes = [
        'application' => 'Application',
        'famille_olfactive' => 'Famille olfactive',
        'zone_geo' => 'Zone Géographique'
    ];

    protected $rules = [
        'type' => 'required|string|max:50',
        'value' => 'required|string|max:100',
        'label' => 'required|string|max:255',
        'description' => 'nullable|string',
        'order' => 'nullable|integer|min:0',
        'active' => 'boolean',
        'is_multiple' => 'boolean',
    ];

    public function create()
    {
        $this->validate();

        // Vérification que le type est autorisé
        if (!array_key_exists($this->type, $this->allowedTypes)) {
            session()->flash('error', __('Ce type de référence n\'est pas autorisé.'));
            return;
        }

        // Vérification d'unicité de la paire type/value
        $exists = ReferenceData::where('type', $this->type)
            ->where('value', $this->value)
            ->exists();
            
        if ($exists) {
            session()->flash('error', __('Cette valeur existe déjà pour ce type de référence.'));
            return;
        }

        ReferenceData::create([
            'type' => $this->type,
            'value' => $this->value,
            'label' => $this->label,
            'description' => $this->description,
            'order' => $this->order,
            'active' => $this->active,
            'is_multiple' => $this->is_multiple,
        ]);

        session()->flash('success', __('Donnée de référence créée avec succès.'));
        return redirect()->route('reference-data.index');
    }

    public function render()
    {
        return view('livewire.reference-data.create-reference-data', [
            'allowedTypes' => $this->allowedTypes,
        ]);
    }
}