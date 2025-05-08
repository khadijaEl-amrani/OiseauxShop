<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavoriController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', [AnnonceController::class, 'index'])->name('home');
Route::get('/annonces/{id}', [AnnonceController::class, 'show'])->name('annonces.show');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // User profile
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('password.form');
    Route::put('/change-password', [AuthController::class, 'updatePassword'])->name('password.update');

    // User announcements
    Route::get('/mes-annonces', [AnnonceController::class, 'userAnnonces'])->name('user.annonces');

    // Announcement CRUD
    Route::get('/annonces/create', [AnnonceController::class, 'create'])->name('annonces.create');
    Route::post('/annonces', [AnnonceController::class, 'store'])->name('annonces.store');
    Route::get('/annonces/{id}/edit', [AnnonceController::class, 'edit'])->name('annonces.edit');
    Route::put('/annonces/{id}', [AnnonceController::class, 'update'])->name('annonces.update');
    Route::delete('/annonces/{id}', [AnnonceController::class, 'destroy'])->name('annonces.destroy');

    // Favorites
    Route::get('/favoris', [FavoriController::class, 'index'])->name('favoris.index');
    Route::post('/favoris/{annonce}', [FavoriController::class, 'toggle'])->name('favoris.toggle');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Announcements management
    Route::get('/annonces', [AdminController::class, 'annonces'])->name('admin.annonces');
    Route::put('/annonces/{id}/approve', [AdminController::class, 'approveAnnonce'])->name('admin.annonces.approve');
    Route::put('/annonces/{id}/reject', [AdminController::class, 'rejectAnnonce'])->name('admin.annonces.reject');

    // Users management
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::put('/users/{id}/toggle-block', [AdminController::class, 'toggleBlockUser'])->name('admin.users.toggle-block');

    // Categories management
    Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::put('/categories/{id}', [AdminController::class, 'updateCategory'])->name('admin.categories.update');

    // Cities management
    Route::get('/villes', [AdminController::class, 'villes'])->name('admin.villes');
    Route::post('/villes', [AdminController::class, 'storeVille'])->name('admin.villes.store');
    Route::put('/villes/{id}', [AdminController::class, 'updateVille'])->name('admin.villes.update');
});
