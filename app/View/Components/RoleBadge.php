<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Spatie\Permission\Models\Role;

class RoleBadge extends Component
{
    public $role;
    public $bgColor;
    public $textColor;
    
    public function __construct(Role $role)
    {
        $this->role = $role;
        
        // Définir les couleurs en fonction du rôle
        switch ($role->name) {
            case 'Super':
                $this->bgColor = 'bg-red-100';
                $this->textColor = 'text-red-800';
                break;
            case 'Superviser':
                $this->bgColor = 'bg-blue-100';
                $this->textColor = 'text-blue-800';
                break;
            case 'Writer':
                $this->bgColor = 'bg-green-100';
                $this->textColor = 'text-green-800';
                break;
            default:
                $this->bgColor = 'bg-gray-100';
                $this->textColor = 'text-gray-800';
                break;
        }
    }
    
    public function render()
    {
        return view('components.role-badge');
    }
}