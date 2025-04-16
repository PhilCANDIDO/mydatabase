<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\UserController;
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

// Routes pour la gestion des produits
Route::middleware(['auth'])->group(function () {
    // Route d'accueil des produits (sans famille sélectionnée)
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware(['permission:delete data']);
    
    // Routes pour une famille spécifique
    Route::prefix('products/{familyCode}')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('products.family.index');
        Route::get('/create', [ProductController::class, 'create'])->name('products.create')->middleware('permission:add data');
        Route::get('/{product}', [ProductController::class, 'show'])->name('products.show')->middleware(['permission:view data']);
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('products.edit')->middleware('permission:edit data');
        Route::get('/import', [ProductController::class, 'showImport'])->name('products.import')->middleware('permission:import data');
        Route::get('/export', [ProductController::class, 'showExport'])->name('products.export')->middleware('permission:export data');
    });
});

// Routes pour la gestion des familles de produits
Route::middleware(['auth', 'role:Superviser|Super'])->prefix('product-families')->group(function () {
    Route::get('/', [ProductFamilyController::class, 'index'])->name('product-families.index');
    Route::get('/create', [ProductFamilyController::class, 'create'])->name('product-families.create');
    Route::get('/{family}/edit', [ProductFamilyController::class, 'edit'])->name('product-families.edit');
    Route::delete('/{family}', [ProductFamilyController::class, 'destroy'])->name('product-families.destroy');
});

// Routes pour la gestion du référentiel de données
Route::middleware(['auth', 'role:Superviser|Super'])->prefix('reference-data')->group(function () {
    Route::get('/', [ReferenceDataController::class, 'index'])->name('reference-data.index');
    Route::get('/create', [ReferenceDataController::class, 'create'])->name('reference-data.create');
    Route::post('/', [ReferenceDataController::class, 'store'])->name('reference-data.store');
    Route::get('/{referenceData}/edit', [ReferenceDataController::class, 'edit'])->name('reference-data.edit');
    Route::put('/{referenceData}', [ReferenceDataController::class, 'update'])->name('reference-data.update');
    Route::delete('/{referenceData}', [ReferenceDataController::class, 'destroy'])->name('reference-data.destroy');
});

require __DIR__.'/auth.php';
