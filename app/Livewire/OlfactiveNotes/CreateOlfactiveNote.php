<?php

namespace App\Livewire\OlfactiveNotes;

use App\Models\OlfactiveNote;
use App\Traits\HasPermissions;
use Livewire\Component;

class CreateOlfactiveNote extends Component
{
    use HasPermissions;
    
    public $olfactive_note_name = '';
    public $olfactive_note_desc = '';
    public $olfactive_note_active = true;
    
    protected $rules = [
        'olfactive_note_name' => 'required|string|max:255|unique:olfactive_notes',
        'olfactive_note_desc' => 'nullable|string',
        'olfactive_note_active' => 'boolean',
    ];

    public function create()
    {
        $this->permAuthorize('add data');
        
        $this->validate();
        
        try {
            OlfactiveNote::create([
                'olfactive_note_name' => $this->olfactive_note_name,
                'olfactive_note_desc' => $this->olfactive_note_desc,
                'olfactive_note_active' => $this->olfactive_note_active,
            ]);
            
            session()->flash('message', __('Note olfactive créée avec succès.'));
            
            return redirect()->route('olfactive-notes.index');
        } catch (\Exception $e) {
            session()->flash('error', __('Erreur lors de la création de la note olfactive: ') . $e->getMessage());
        }
    }

    public function render()
    {
        $this->permAuthorize('add data');
        
        return view('livewire.olfactive-notes.create-olfactive-note');
    }
}