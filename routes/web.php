<?php

use App\Http\Controllers\ClientesPagantesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'verified'])->group(function () {


    Route::get('/dashboard', [ClientesPagantesController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/vendedor/dashboard', [ClientesPagantesController::class, 'dashboardVendedor'])
        ->name('vendedor.dashboard');

    Route::get('/vendedor/create', [ClientesPagantesController::class, 'create'])
        ->name('vendedor.ClientePaganteCreate');

    Route::post('/vendedor/create', [ClientesPagantesController::class, 'store'])
        ->name('vendedor.store');

    Route::get('/admin/dashboard', [ClientesPagantesController::class, 'dashboardAdmin'])
        ->middleware(['auth', 'verified', 'admin']) 
        ->name('admin.dashboard');

    Route::delete('/clientes/{cliente}', [ClientesPagantesController::class, 'destroy'])
    ->middleware(['auth', 'admin']) // Protegida para que apenas admins possam excluir
    ->name('cliente.destroy');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
