<?php

namespace App\Livewire\ReferenceData;

use App\Models\ReferenceData;
use Livewire\Component;

class CreateReferenceData extends Component
{
    public $type = '';
    public $newType = '';
    public $value = '';
    public $label = '';
    public $description = '';
    public $order = 0;
    public $active = true;
    public $is_multiple = false;

    public $isNewType = false;

    protected $rules = [
        'type' => 'required|string|max:50',
        'value' => 'required|string|max:100',
        'label' => 'required|string|max:255',
        'description' => 'nullable|string',
        'order' => 'nullable|integer|min:0',
        'active' => 'boolean',
        'is_multiple' => 'boolean',
    ];

    public function updatedIsNewType()
    {
        if ($this->isNewType) {
            $this->type = '';
        } else {
            $this->newType = '';
        }
    }

    public function create()
    {
        // Si c'est un nouveau type, utiliser newType
        if ($this->isNewType) {
            $this->type = $this->newType;
            $this->validate([
                'newType' => 'required|string|max:50',
                'value' => 'required|string|max:100',
                'label' => 'required|string|max:255',
                'description' => 'nullable|string',
                'order' => 'nullable|integer|min:0',
                'active' => 'boolean',
                'is_multiple' => 'boolean',
            ]);
        } else {
            $this->validate();
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
        $types = ReferenceData::select('type')->distinct()->orderBy('type')->pluck('type');
        
        return view('livewire.reference-data.create-reference-data', [
            'types' => $types,
        ]);
    }
}