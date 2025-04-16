<?php

namespace App\Traits;

trait HasPermissions
{
    public function permUserCan($permission)
    {
        return auth()->user() && auth()->user()->can($permission);
    }
    
    public function permUserHasRole($role)
    {
        return auth()->user() && auth()->user()->hasRole($role);
    }
    
    public function permUserHasAnyRole($roles)
    {
        return auth()->user() && auth()->user()->hasAnyRole($roles);
    }
    
    public function permUserHasAllRoles($roles)
    {
        return auth()->user() && auth()->user()->hasAllRoles($roles);
    }
    
    public function permAuthorize($permission)
    {
        if (!$this->permUserCan($permission)) {
            abort(403, __('Unauthorized action.'));
        }
        
        return true;
    }
}