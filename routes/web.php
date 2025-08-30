<?php

use App\Http\Controllers\ClientesPagantesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;




Route::get('/', function () {
    // se o usuário estiver logado, faz logout
    if (auth()->check()) {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
    return view('welcome');
});

//  principal
Route::middleware(['auth', 'verified'])->group(function () {

    //rota adm
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [ClientesPagantesController::class, 'dashboardAdmin'])->name('dashboard');
        Route::delete('/clientes/{cliente}', [ClientesPagantesController::class, 'destroy'])->name('cliente.destroy');
    
        // rotas da Lixeira
        Route::get('/clientes/lixeira', [ClientesPagantesController::class, 'lixeira'])->name('cliente.lixeira');
        
        
        Route::put('/clientes/restore/{id}', [ClientesPagantesController::class, 'restore'])->name('cliente.restore');
        
        Route::delete('/clientes/force-delete/{id}', [ClientesPagantesController::class, 'forceDelete'])->name('cliente.forceDelete');
    });

    //rota vendedor
    Route::prefix('vendedor')->name('vendedor.')->group(function () {
        Route::get('/dashboard', [ClientesPagantesController::class, 'dashboardVendedor'])->name('dashboard');
        Route::get('/create', [ClientesPagantesController::class, 'create'])->name('ClientePaganteCreate');
        Route::post('/create', [ClientesPagantesController::class, 'store'])->name('store');
    });

});

// rotas de perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// autenticacao
require __DIR__ . '/auth.php';