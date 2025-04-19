<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\OlfactiveFamilyController;
use App\Http\Controllers\OlfactiveNoteController;
use App\Http\Controllers\ZoneGeoController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductFamilyController;
use App\Http\Controllers\ReferenceDataController;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::post('/change-language', function () {
    $locale = request('locale');
    if (in_array($locale, ['en', 'fr'])) {
        Session::put('locale', $locale);
        App::setLocale($locale);
    } else {
        Session::put('locale', 'en');
        App::setLocale('en');
    }
    return redirect()->back();
})->name('change.language');

Route::middleware(['auth', 'role:Super'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

// Routes pour les Données de référence (accessibles uniquement aux rôles Superviser et Super)
Route::middleware(['auth', 'role_or_permission:Superviser|Super'])->group(function () {
    // Applications
    Route::resource('product-families', ProductFamilyController::class);

    // Applications
    Route::resource('applications', ApplicationController::class);
    
    // Familles Olfactives
    Route::resource('olfactive-families', OlfactiveFamilyController::class);
    
    // Notes Olfactives
    Route::resource('olfactive-notes', OlfactiveNoteController::class);
    
    // Zones Géographiques
    Route::resource('zone-geos', ZoneGeoController::class);

});

Route::middleware(['auth'])->group(function () {
    // Routes pour les produits (accessibles à tous les rôles)
    Route::resource('products', ProductController::class);
});

require __DIR__.'/auth.php';
