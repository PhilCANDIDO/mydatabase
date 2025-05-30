<?php

namespace App\Livewire\OlfactiveNotes;

use App\Models\OlfactiveNote;
use App\Traits\HasPermissions;
use Livewire\Component;
use Livewire\WithPagination;

class OlfactiveNoteList extends Component
{
    use WithPagination, HasPermissions;
    
    public $search = '';
    public $sortField = 'olfactive_note_name';
    public $sortDirection = 'asc';
    public $perPage = 10;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'olfactive_note_name'],
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
        
        $olfactiveNotes = OlfactiveNote::query()
            ->when($this->search, function ($query) {
                return $query->where('olfactive_note_name', 'like', '%' . $this->search . '%')
                    ->orWhere('olfactive_note_desc', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
            
        return view('livewire.olfactive-notes.olfactive-note-list', [
            'olfactiveNotes' => $olfactiveNotes
        ]);
    }
}