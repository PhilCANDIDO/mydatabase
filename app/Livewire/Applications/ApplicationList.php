<?php

namespace App\Livewire\Applications;

use App\Models\Application;
use App\Traits\HasPermissions;
use Livewire\Component;
use Livewire\WithPagination;

class ApplicationList extends Component
{
    use WithPagination, HasPermissions;
    
    public $search = '';
    public $sortField = 'application_name';
    public $sortDirection = 'asc';
    public $perPage = 10;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'application_name'],
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
        
        $applications = Application::query()
            ->when($this->search, function ($query) {
                return $query->where('application_name', 'like', '%' . $this->search . '%')
                    ->orWhere('application_desc', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
            
        return view('livewire.applications.application-list', [
            'applications' => $applications
        ]);
    }
}