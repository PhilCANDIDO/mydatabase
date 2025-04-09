<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\UserController;

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
});

require __DIR__.'/auth.php';
