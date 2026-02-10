<?php

use App\Http\Controllers\PretController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SalleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;




Route::get('/', function () {
    return redirect()->route('login');
});

// 1. Les routes accessibles uniquement SI ON EST CONNECTÉ
Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Gestion des Prêts
    Route::get('/prets', [PretController::class, 'index'])->name('prets.index');
    Route::post('/prets', [PretController::class, 'store'])->name('prets.store');
    Route::get('/historique', [PretController::class, 'historique'])->name('prets.historique');
    Route::delete('/prets/{id}', [PretController::class, 'destroy'])->name('prets.destroy');
    Route::patch('/prets/{id}', [PretController::class, 'update'])->name('prets.update');
    Route::get('/prets/{id}/pdf', [PretController::class, 'genererPDF'])->name('prets.pdf');

    //modification de profile 
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Salles et Stock
    Route::resource('salles', SalleController::class);
    Route::get('/stock/historique', [StockController::class, 'history'])->name('stock.history');
    //Route::get('/stocks', [PretController::class, 'index'])->name('stocks.index');
    Route::get('/salles-export', [SalleController::class, 'exportExcel'])->name('salles.export');
    Route::resource('stock', StockController::class);
    Route::resource('salles', SalleController::class);
    
    

    // 2. Uniquement pour l'ADMIN
    Route::middleware(['admin'])->group(function () {
       Route::get('/users', [UserController::class, 'index'])->name('users.index');
       Route::post('/users', [UserController::class, 'store'])->name('users.store');
       Route::patch('/users/{id}', [UserController::class, 'update'])->name('users.update');
       Route::patch('/users/{id}/toggle', [App\Http\Controllers\UserController::class, 'toggleStatus'])->name('users.toggle');
       Route::delete('/users/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
       
    });
    
});

Route::match(['get', 'post'], '/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login'); // Redirection vers la page de connexion
})->name('logout');





require __DIR__.'/auth.php';