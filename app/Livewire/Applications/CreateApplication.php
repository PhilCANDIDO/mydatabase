<?php

namespace App\Livewire\Applications;

use App\Models\Application;
use App\Traits\HasPermissions;
use Livewire\Component;

class CreateApplication extends Component
{
    use HasPermissions;
    
    public $application_name = '';
    public $application_desc = '';
    public $application_active = true;
    
    protected $rules = [
        'application_name' => 'required|string|max:255|unique:applications',
        'application_desc' => 'nullable|string',
        'application_active' => 'boolean',
    ];

    public function create()
    {
        $this->permAuthorize('add data');
        
        $this->validate();
        
        try {
            Application::create([
                'application_name' => $this->application_name,
                'application_desc' => $this->application_desc,
                'application_active' => $this->application_active,
            ]);
            
            session()->flash('message', __('Application created successfully.'));
            
            return redirect()->route('applications.index');
        } catch (\Exception $e) {
            session()->flash('error', __('Error creating application: ') . $e->getMessage());
        }
    }

    public function render()
    {
        $this->permAuthorize('add data');
        
        return view('livewire.applications.create-application');
    }
}