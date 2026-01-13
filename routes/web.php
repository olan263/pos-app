<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Semua Route di bawah ini hanya bisa diakses jika sudah LOGIN
Route::middleware(['auth', 'verified'])->group(function () {
    
    // 1. Dashboard Utama (Dengan Logic Statistik)
    Route::get('/dashboard', function () {
        $todaySales = Order::whereDate('created_at', now())->sum('total_amount');
        $totalOrders = Order::whereDate('created_at', now())->count();
        $lowStock = Product::where('stock', '<=', 5)->count();
        $recentOrders = Order::latest()->take(5)->get();

        return view('dashboard', compact('todaySales', 'totalOrders', 'lowStock', 'recentOrders'));
    })->name('dashboard');

    // 2. Fitur Kasir (POS)
    Route::get('/cashier', [CartController::class, 'index'])->name('cashier.index');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // 3. Manajemen Produk (Stok Barang)
    Route::resource('products', ProductController::class);

    // 4. Profile User
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';