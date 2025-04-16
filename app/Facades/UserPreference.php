<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class UserPreference extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'user.preferences';
    }
}