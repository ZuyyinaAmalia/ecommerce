<?php

use App\Livewire\HomePage;
use App\Livewire\CategoriesPage;
use App\Livewire\ProductsPage;
use App\Livewire\CartPage;
use App\Livewire\ProductDetailPage;
use App\Livewire\CheckoutPage;
use App\Livewire\MyOrdersPage;
use App\Livewire\MyOrderDetailPage;
use App\Livewire\auth\LoginPage;
use App\Livewire\auth\RegisterPage;
use App\Livewire\auth\ForgotPasswordPage;
use App\Livewire\auth\ResetPasswordPage;
use App\Livewire\SuccesPage;
use App\Livewire\CancelPage;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::get('/', HomePage::class);
Route::get('/categories', CategoriesPage::class);
Route::get('/products', ProductsPage::class);
Route::get('/cart', CartPage::class);
Route::get('/products/{id}', ProductDetailPage::class);

// Route::get('/checkout', CheckoutPage::class);
// Route::get('/my-orders', MyOrdersPage::class);
// Route::get('/my-orders/{order}', MyOrderDetailPage::class);
// Route::get('/login', LoginPage::class);
// Route::get('/register', RegisterPage::class);
// Route::get('/forgot', ForgotPasswordPage::class);
// Route::get('/reset', ResetPasswordPage::class);

// Route::get('/succes', SuccesPage::class);
// Route::get('/cancel', CancelPage::class);

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
    Route::get('/my-orders/{order_id}', MyOrderDetailPage::class)->name('my-order.show');
    Route::get('/success', SuccesPage::class)->name('success');
    Route::get('/cancel', CancelPage::class)->name('cancel');

});
