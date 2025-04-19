<?php

namespace App\Livewire\OlfactiveNotes;

use App\Models\OlfactiveNote;
use App\Traits\HasPermissions;
use Livewire\Component;

class EditOlfactiveNote extends Component
{
    use HasPermissions;
    
    public OlfactiveNote $olfactiveNote;
    public $olfactive_note_name;
    public $olfactive_note_desc;
    public $olfactive_note_active;
    
    protected function rules()
    {
        return [
            'olfactive_note_name' => 'required|string|max:255|unique:olfactive_notes,olfactive_note_name,' . $this->olfactiveNote->id,
            'olfactive_note_desc' => 'nullable|string',
            'olfactive_note_active' => 'boolean',
        ];
    }

    public function mount(OlfactiveNote $olfactiveNote)
    {
        $this->olfactiveNote = $olfactiveNote;
        $this->olfactive_note_name = $olfactiveNote->olfactive_note_name;
        $this->olfactive_note_desc = $olfactiveNote->olfactive_note_desc;
        $this->olfactive_note_active = $olfactiveNote->olfactive_note_active;
    }

    public function update()
    {
        $this->permAuthorize('edit data');
        
        $this->validate();
        
        try {
            $this->olfactiveNote->update([
                'olfactive_note_name' => $this->olfactive_note_name,
                'olfactive_note_desc' => $this->olfactive_note_desc,
                'olfactive_note_active' => $this->olfactive_note_active,
            ]);
            
            session()->flash('message', __('Note olfactive mise à jour avec succès.'));
            
            return redirect()->route('olfactive-notes.index');
        } catch (\Exception $e) {
            session()->flash('error', __('Erreur lors de la mise à jour de la note olfactive: ') . $e->getMessage());
        }
    }

    public function render()
    {
        $this->permAuthorize('edit data');
        
        return view('livewire.olfactive-notes.edit-olfactive-note');
    }
}