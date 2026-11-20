<?php

use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LpkController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/lpk/{slug}', [PublicController::class, 'show'])->name('lpk.show');

// Redirect /dashboard to /admin
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Panel Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('lpks', LpkController::class);
    Route::post('lpks/{lpk}/toggle-active', [LpkController::class, 'toggleActive'])->name('lpks.toggle-active');
    Route::delete('lpks/{lpk}/gallery/{gallery}', [LpkController::class, 'destroyGallery'])->name('lpks.gallery.destroy');

    Route::resource('articles', ArticleController::class);
    Route::post('articles/{article}/toggle-active', [ArticleController::class, 'toggleActive'])->name('articles.toggle-active');

    Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
    Route::post('settings/password', [SettingController::class, 'updatePassword'])->name('settings.password');
});

require __DIR__.'/auth.php';
