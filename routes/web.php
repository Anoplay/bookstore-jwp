<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

use App\Http\Middleware\RedirectAdmin;

// Public routes (Admins are redirected to dashboard)
Route::middleware([RedirectAdmin::class])->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('home');
    Route::get('/about', [UserController::class, 'about'])->name('about');
    Route::get('/contact', [UserController::class, 'contact'])->name('contact');
    Route::post('/contact', [UserController::class, 'submitContact'])->name('contact.submit');
    Route::get('/search', [UserController::class, 'search'])->name('search');
});

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin routes
    Route::middleware('can:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Kategori
        Route::resource('kategori', AdminController::class)->except(['show']);
        
        // Buku
        Route::get('/buku', [AdminController::class, 'bukuIndex'])->name('buku.index');
        Route::get('/buku/create', [AdminController::class, 'bukuCreate'])->name('buku.create');
        Route::post('/buku', [AdminController::class, 'bukuStore'])->name('buku.store');
        Route::get('/buku/{buku}/edit', [AdminController::class, 'bukuEdit'])->name('buku.edit');
        Route::put('/buku/{buku}', [AdminController::class, 'bukuUpdate'])->name('buku.update');
        Route::delete('/buku/{buku}', [AdminController::class, 'bukuDestroy'])->name('buku.destroy');

        // Users
        Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');

        // Pesanan
        Route::get('/pesanan', [AdminController::class, 'pesananIndex'])->name('pesanan.index');
        Route::get('/pesanan/{pesanan}/status', [AdminController::class, 'pesananStatus'])->name('pesanan.status');
        Route::post('/pesanan/{pesanan}/update-status', [AdminController::class, 'pesananUpdateStatus'])->name('pesanan.updateStatus');

        // Pesan Masuk / Kontak
        Route::get('/kontak', [AdminController::class, 'kontakIndex'])->name('kontak.index');
    });

    // User routes
    Route::middleware([RedirectAdmin::class])->group(function () {
        Route::post('/cart/add/{buku}', [UserController::class, 'addToCart'])->name('cart.add');
        Route::get('/cart', [UserController::class, 'cart'])->name('cart');
        Route::delete('/cart/remove/{id}', [UserController::class, 'removeFromCart'])->name('cart.remove');
        Route::put('/cart/update/{id}', [UserController::class, 'updateCart'])->name('cart.update');
        Route::get('/checkout', [UserController::class, 'checkout'])->name('checkout');
        Route::post('/checkout', [UserController::class, 'processCheckout'])->name('checkout.process');
        Route::get('/pesanan', [UserController::class, 'pesanan'])->name('user.pesanan');
    });
});
