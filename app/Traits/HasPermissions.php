<?php

namespace App\Traits;

trait HasPermissions
{
    public function userCan($permission)
    {
        return auth()->user() && auth()->user()->can($permission);
    }
    
    public function userHasRole($role)
    {
        return auth()->user() && auth()->user()->hasRole($role);
    }
    
    public function userHasAnyRole($roles)
    {
        return auth()->user() && auth()->user()->hasAnyRole($roles);
    }
    
    public function userHasAllRoles($roles)
    {
        return auth()->user() && auth()->user()->hasAllRoles($roles);
    }
    
    public function authorize($permission)
    {
        if (!$this->userCan($permission)) {
            abort(403, __('Unauthorized action.'));
        }
        
        return true;
    }
}