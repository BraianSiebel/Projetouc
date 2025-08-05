<?php

use App\Http\Controllers\ClientesPagantesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request; // <-- CORREÇÃO 1: Importado
use Illuminate\Support\Facades\Auth; // <-- CORREÇÃO 1: Importado
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rota raiz para deslogar qualquer usuário que a acesse
Route::get('/', function (Request $request) {
    if (Auth::check()) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
    return view('welcome');
});

// Rotas gerais que exigem autenticação e email verificado
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard principal (pode ser um ponto de redirecionamento)
    Route::get('/dashboard', [ClientesPagantesController::class, 'index'])->name('dashboard');

    // Grupo de rotas para o Administrador
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        // Rota removida era duplicada, esta é a correta
        Route::get('/dashboard', [ClientesPagantesController::class, 'dashboardAdmin'])->name('dashboard');
        
        // A rota de exclusão foi movida para o grupo de admin para melhor organização
        Route::delete('/clientes/{cliente}', [ClientesPagantesController::class, 'destroy'])->name('cliente.destroy');
    });

    // Grupo de rotas para o Vendedor
    // O prefixo adiciona '/vendedor' à URL e o name() adiciona 'vendedor.' ao nome da rota
    Route::prefix('vendedor')->name('vendedor.')->group(function () {
        Route::get('/dashboard', [ClientesPagantesController::class, 'dashboardVendedor'])->name('dashboard');
        Route::get('/create', [ClientesPagantesController::class, 'create'])->name('ClientePaganteCreate');
        Route::post('/create', [ClientesPagantesController::class, 'store'])->name('store');
    });

});

// Rotas de perfil (geralmente não precisam de 'verified', apenas 'auth')
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Inclui as rotas de autenticação (login, register, etc.)
require __DIR__ . '/auth.php';