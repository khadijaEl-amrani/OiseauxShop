<?php

use App\Http\Controllers\Admin\CommandeController;
use App\Http\Controllers\Admin\CommentaireController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FamilleController;
use App\Http\Controllers\Admin\ProduitController;
use App\Http\Controllers\Admin\SousFamilleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ClientController;

use App\Http\Controllers\Auth\AuthenticatedSessionController;

use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\ProfileController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
    
    // Client routes
    Route::prefix('client')->name('client.')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');
        
        Route::get('orders', [OrderController::class, 'index'])
            ->name('orders');
        
        Route::get('orders/{order}', [OrderController::class, 'show'])
            ->name('orders.show');
        
        Route::get('profile', [ProfileController::class, 'index'])
            ->name('profile');
        
        Route::put('profile', [ProfileController::class, 'update'])
            ->name('profile.update');
    });
});

// Shop route (placeholder for now)
Route::get('/shop', function () {
    return view('shop.index');
})->name('shop');


Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('users', UserController::class);
    Route::resource('clients', ClientController::class);
    Route::resource('produits', ProduitController::class);
    Route::resource('commandes', CommandeController::class);
    Route::resource('familles', FamilleController::class);
    Route::resource('sous-familles', SousFamilleController::class);
    Route::resource('commentaires', CommentaireController::class)->only(['index', 'destroy']);
});

require __DIR__.'/auth.php';