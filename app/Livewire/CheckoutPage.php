<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Models\Order;
use App\Models\CartItem;
use Livewire\Attributes\Title;
use Livewire\Component;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Auth;

#[Title('Checkout')]
class CheckoutPage extends Component
{
    public $cart_items = []; 
    public $first_name;
    public $email;
    public $telp;
    public $street_address;
    public $payment_method;

    public function mount()
    {
        // Ambil cart dari database kalau login, atau cookie kalau guest
        if (Auth::check()) {
            $this->cart_items = CartItem::with('product')
                ->whereHas('cart', fn($q) => $q->where('user_id', Auth::id()))
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->product->id,
                        'name' => $item->product->name,
                        'quantity' => $item->qty,
                        'unit_amount' => $item->product->price,
                        'total_amount' => $item->product->price * $item->qty,
                        'image' => $item->product->image[0] ?? null,
                    ];
                })
                ->toArray();
        } else {
            $this->cart_items = CartManagement::getCartItemsFromCookie();
        }

        if (count($this->cart_items) == 0) {
            return redirect('/products');
        }

        // Autofill data user kalau login
        $user = auth()->user();
        if ($user) {
            $this->first_name = $user->name;
            $this->email = $user->email;
            $this->telp = $user->telp ?? '';
        }
    }


    public function placeOrder()
    {
        $this->validate([
            'first_name' => 'required',
            'email' => 'required|email',
            'telp' => 'required',
            'street_address' => 'required',
            'payment_method' => 'required',
        ]);

        $line_items = [];
        $order_items = [];
        $cart_for_total = [];

        // 🔹 Ambil cart dan siapkan data
        if (Auth::check()) {
            $cartItems = CartItem::with('product')
                ->whereHas('cart', fn($q) => $q->where('user_id', Auth::id()))
                ->get();
        
            foreach ($cartItems as $item) {
                // Untuk Stripe
                $line_items[] = [
                    'price_data' => [
                        'currency' => 'idr',
                        'unit_amount' => $item->product->price * 100,
                        'product_data' => [
                            'name' => $item->product->name,
                        ],
                    ],
                    'quantity' => $item->qty,
                ];
            
                // Untuk database order_items - PENTING: gunakan nama field yang PERSIS
                $order_items[] = [
                    'product_id' => $item->product->id,
                    'qty' => (int) $item->qty,  // ✅ Cast ke integer
                    'price' => (float) $item->product->price,  // ✅ Cast ke float
                    'subtotal' => (float) ($item->product->price * $item->qty),
                ];
            
                // Untuk calculate total
                $cart_for_total[] = [
                    'quantity' => $item->qty,
                    'unit_amount' => $item->product->price,
                    'total_amount' => $item->product->price * $item->qty,
                ];
            }
        
        } else {
            // Guest user - dari cookie
            $cart_items = CartManagement::getCartItemsFromCookie();
        
            foreach ($cart_items as $item) {
                // Untuk Stripe
                $line_items[] = [
                    'price_data' => [
                        'currency' => 'idr',
                        'unit_amount' => $item['unit_amount'] * 100,
                        'product_data' => [
                            'name' => $item['name'],
                        ],
                    ],
                    'quantity' => $item['quantity'],
                ];
            
                // Untuk database order_items
                $order_items[] = [
                    'product_id' => (int) $item['id'],
                    'qty' => (int) $item['quantity'],  // ✅ Cast ke integer
                    'price' => (float) $item['unit_amount'],  // ✅ Cast ke float
                    'subtotal' => (float) $item['total_amount'],
                ];
            }
        
            $cart_for_total = $cart_items;
        }

        // 🔹 Simpan order baru
        $order = new Order();
        $order->user_id = Auth::id();
        $order->total = CartManagement::calculateGrandTotal($cart_for_total);
        $order->payment_method = $this->payment_method;
        $order->status = 'processing';
        $order->address_text = $this->street_address;
        $order->telp = $this->telp;

        $redirect_url = '';

        // 🔹 Integrasi Stripe
        if ($this->payment_method == 'stripe') {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $sessionCheckout = Session::create([
                'payment_method_types' => ['card'],
                'customer_email' => $this->email,
                'line_items' => $line_items,
                'mode' => 'payment',
                'success_url' => route('success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('cancel'),
            ]);

            $redirect_url = $sessionCheckout->url;
        } else {
            // COD
            $redirect_url = route('success');
        }

        // 🔹 Simpan order dan itemnya
        $order->save();
    
        // Debug - hapus setelah berhasil
        //dd($order_items);
    
        $order->items()->createMany($order_items);

        // 🔹 Bersihkan cart
        if (Auth::check()) {
            CartItem::whereHas('cart', fn($q) => $q->where('user_id', Auth::id()))->delete();
        } else {
            CartManagement::clearCartItems();
        }

        // 🔹 Redirect
        return redirect($redirect_url);
    }

    public function render()
    {
        // Pastikan data cart selalu up-to-date
        if (Auth::check()) {
            $this->cart_items = CartItem::with('product')
                ->whereHas('cart', fn($q) => $q->where('user_id', Auth::id()))
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->product->id,
                        'name' => $item->product->name,
                        'quantity' => $item->qty,
                        'unit_amount' => $item->product->price,
                        'total_amount' => $item->product->price * $item->qty,
                        'image' => $item->product->image[0] ?? null,
                    ];
                })
                ->toArray();
        } else {
            $this->cart_items = CartManagement::getCartItemsFromCookie();
        }

        // Gunakan helper resmi
        $grand_total = CartManagement::calculateGrandTotal($this->cart_items);

        return view('livewire.checkout-page', [
            'cart_items' => $this->cart_items,
            'grand_total' => $grand_total,
        ]);
    }
}

