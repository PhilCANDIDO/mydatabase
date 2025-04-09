<?php

namespace App\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Directive pour vérifier si l'utilisateur a une permission
        Blade::directive('can', function ($expression) {
            return "<?php if (auth()->check() && auth()->user()->can({$expression})): ?>";
        });
        
        Blade::directive('endcan', function () {
            return "<?php endif; ?>";
        });
        
        // Directive pour vérifier si l'utilisateur a un rôle
        Blade::directive('role', function ($expression) {
            return "<?php if (auth()->check() && auth()->user()->hasRole({$expression})): ?>";
        });
        
        Blade::directive('endrole', function () {
            return "<?php endif; ?>";
        });
        
        // Directive pour vérifier si l'utilisateur a l'un des rôles
        Blade::directive('hasanyrole', function ($expression) {
            return "<?php if (auth()->check() && auth()->user()->hasAnyRole({$expression})): ?>";
        });
        
        Blade::directive('endhasanyrole', function () {
            return "<?php endif; ?>";
        });
    }
}