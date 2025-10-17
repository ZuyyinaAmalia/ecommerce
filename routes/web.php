<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;


use App\Livewire\HomePage;
use App\Livewire\CategoriesPage;
use App\Livewire\ProductsPage;
use App\Livewire\CartPage;
use App\Livewire\ProductDetailPage;
use App\Livewire\CheckoutPage;
use App\Livewire\MyOrdersPage;
use App\Livewire\MyOrdersDetailPage;
use App\Livewire\auth\LoginPage;
use App\Livewire\auth\RegisterPage;
use App\Livewire\auth\ForgotPasswordPage;
use App\Livewire\auth\ResetPasswordPage;
use App\Livewire\SuccessPage;
use App\Livewire\CancelPage;

Route::get('/', HomePage::class);
Route::get('/categories', CategoriesPage::class);
Route::get('/products', ProductsPage::class);
Route::get('/cart', CartPage::class);
Route::get('/products/{id}', ProductDetailPage::class);

Route::middleware('guest')->group(function(){
    Route::get('/login', LoginPage::class)->name('login');
    Route::get('/register', RegisterPage::class);
    Route::get('/forgot', ForgotPasswordPage::class)->name('password.request');
    Route::get('/reset/{token}', ResetPasswordPage::class)->name('password.reset');
});

Route::middleware('auth')->group(function(){
    Route::post('/logout', function (Request $request){
        auth()->logout();                           // keluar dari sistem
        $request->session()->invalidate();           // hapus session lama
        $request->session()->regenerateToken();      // buat token baru (aman)
        return redirect('/')->with('success', 'Berhasil logout!'); // redirect ke homepage
    })->name('logout');

    Route::get('/logout', function () 
    {
        if (auth()->check()) {
            auth()->logout();
        }
        return redirect('/')->with('success', 'Berhasil logout!');
    });
    // web.php (di dalam group auth)
    Route::get('/checkout', CheckoutPage::class)->name('checkout');
    Route::get('/account', App\Livewire\Auth\MyAccountPage::class);
    Route::get('/my-orders', MyOrdersPage::class);
    Route::get('/my-orders/{order_id}', MyOrdersDetailPage::class)->name('my-order.show');
    Route::view('/success', 'success-page')->name('success');
    Route::get('/cancel', CancelPage::class)->name('cancel');

});

// Default langsung ke dashboard admin
// Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

// =========================
// 🔹 ADMIN ROUTES
// =========================
Route::prefix('admin')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // =========================
    // 🔹 ORDER MANAGEMENT
    // =========================
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{id}', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');

    // =========================
    // 🔹 DETAIL ORDERS (read-only, tanpa update status)
    // =========================
    Route::get('/details', [OrderController::class, 'detailsIndex'])->name('details.index');
    Route::get('/details/{id}', [OrderController::class, 'detailsShow'])->name('details.show');

    // =========================
    // 🔹 CATEGORY CRUD
    // =========================
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // =========================
    // 🔹 PRODUCT CRUD
    // =========================
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});

// =========================
// 🔹 FRONTEND (Landing & Register)
// =========================
Route::get('/landing', [LandingController::class, 'index'])->name('landing');





