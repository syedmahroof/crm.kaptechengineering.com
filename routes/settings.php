<?php

declare(strict_types=1);

use App\Http\Controllers\Settings\BranchController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('settings/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('settings/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('settings/password', [PasswordController::class, 'edit'])->name('password.edit');
    Route::put('settings/password', [PasswordController::class, 'update'])->name('password.update');

    Route::get('settings/appearance', function () {
        return Inertia::render('settings/appearance');
    })->name('appearance');

    // Branch Management Routes
    Route::resource('settings/branches', BranchController::class)->names([
        'index' => 'settings.branches.index',
        'create' => 'settings.branches.create',
        'store' => 'settings.branches.store',
        'show' => 'settings.branches.show',
        'edit' => 'settings.branches.edit',
        'update' => 'settings.branches.update',
        'destroy' => 'settings.branches.destroy',
    ]);
    Route::post('settings/branches/{branch}/toggle-status', [BranchController::class, 'toggleStatus'])->name('settings.branches.toggle-status');
});
