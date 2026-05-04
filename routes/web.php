<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\TeamController as AdminTeamController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\JerseyController; // <-- Ini penting buat baju
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // === Rute Admin (DIGEMBOK SAMA SATPAM) ===
    Route::middleware(['role:super_admin'])->group(function () {
        Route::get('/admin/teams', [AdminTeamController::class, 'index'])->name('admin.teams.index');
        Route::get('/admin/teams/{team}', [AdminTeamController::class, 'show'])->name('admin.teams.show');
        Route::patch('/admin/teams/{team}/status', [AdminTeamController::class, 'updateStatus'])->name('admin.teams.update-status');
      // Rute Kelola User (TAMBAHAN BARU)
        Route::get('/admin/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
        Route::post('/admin/users', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.users.store'); // ?? INI TAMBAHANNYA BANG
        Route::patch('/admin/users/{user}/role', [\App\Http\Controllers\Admin\UserController::class, 'updateRole'])->name('admin.users.update-role');
        Route::patch('/admin/users/{user}/password', [\App\Http\Controllers\Admin\UserController::class, 'updatePassword'])->name('admin.users.update-password'); // ?? INI TAMBAHANNYA
        Route::delete('/admin/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.users.destroy');

        Route::delete('/admin/teams/{team}', [AdminTeamController::class, 'destroy'])->name('admin.teams.destroy');
 });

    // === Rute Bikin Tim (Customer) ===
    Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    
    // ?????? TAMBAHAN BARU DI SINI BANG ??????
    Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');
    // ?????? ============================== ??????

    // === Rute Input Baju ===
    Route::post('/teams/{team}/jerseys', [JerseyController::class, 'store'])->name('jerseys.store');

// === Rute Input & Hapus Baju ===
    Route::post('/teams/{team}/jerseys', [JerseyController::class, 'store'])->name('jerseys.store');
    Route::delete('/teams/{team}/jerseys/{jersey}', [JerseyController::class, 'destroy'])->name('jerseys.destroy'); // <--- TAMBAHAN INI

// TAMBAHAN BARU:
    Route::get('/teams/{team}/export', [JerseyController::class, 'export'])->name('jerseys.export');
    Route::post('/teams/{team}/import', [JerseyController::class, 'import'])->name('jerseys.import');

});

require __DIR__.'/auth.php';