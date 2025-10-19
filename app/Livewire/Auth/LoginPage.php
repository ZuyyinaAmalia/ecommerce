<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Helpers\CartManagement; // ⬅️ penting: tambahkan ini

#[Title('Login')]
class LoginPage extends Component
{
    public $email;
    public $password;

    public function save()
    {
        $this->validate([
            'email' => 'required|email|max:255|exists:users,email',
            'password' => 'required|min:6|max:255',
        ]);

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            $this->addError('email', 'Email atau password salah.');
            session()->flash('error', 'Invalid credentials');
            return;
        }

        $user = Auth::user();

        $guestCart = CartManagement::getCartItemsFromCookie();

        if (!empty($guestCart)) {
            CartManagement::mergeGuestCartToUserCart($user, $guestCart);
            Cookie::queue(Cookie::forget('cart_items')); 
        }

        if ($user->role === 'admin') {
            return redirect()->intended('/admin/dashboard');
        } else {
            return redirect()->intended('/');
        }
    }

    public function render()
    {
        return view('livewire.auth.login-page');
    }
}

