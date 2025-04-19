<?php

namespace App\Livewire\Applications;

use App\Models\Application;
use App\Traits\HasPermissions;
use Livewire\Component;

class EditApplication extends Component
{
    use HasPermissions;
    
    public Application $application;
    public $application_name;
    public $application_desc;
    public $application_active;
    
    protected function rules()
    {
        return [
            'application_name' => 'required|string|max:255|unique:applications,application_name,' . $this->application->id,
            'application_desc' => 'nullable|string',
            'application_active' => 'boolean',
        ];
    }

    public function mount(Application $application)
    {
        $this->application = $application;
        $this->application_name = $application->application_name;
        $this->application_desc = $application->application_desc;
        $this->application_active = $application->application_active;
    }

    public function update()
    {
        $this->permAuthorize('edit data');
        
        $this->validate();
        
        try {
            $this->application->update([
                'application_name' => $this->application_name,
                'application_desc' => $this->application_desc,
                'application_active' => $this->application_active,
            ]);
            
            session()->flash('message', __('Application updated successfully.'));
            
            return redirect()->route('applications.index');
        } catch (\Exception $e) {
            session()->flash('error', __('Error updating application: ') . $e->getMessage());
        }
    }

    public function render()
    {
        $this->permAuthorize('edit data');
        
        return view('livewire.applications.edit-application');
    }
}