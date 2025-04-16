<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class UserPreferenceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Macro pour accéder facilement aux préférences depuis n'importe où
        $this->app->singleton('user.preferences', function ($app) {
            return new class {
                public function get($key, $default = null)
                {
                    if (Auth::check()) {
                        return Auth::user()->getPreference($key, $default);
                    }
                    return $default;
                }

                public function set($key, $value)
                {
                    if (Auth::check()) {
                        return Auth::user()->setPreference($key, $value);
                    }
                    return null;
                }

                public function remove($key)
                {
                    if (Auth::check()) {
                        return Auth::user()->removePreference($key);
                    }
                    return false;
                }
            };
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
