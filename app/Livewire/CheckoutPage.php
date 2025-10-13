<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Mail\OrderPlaced;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class CheckoutPage extends Component
{
    public $address_text;
    public $payment_method = 'cod';

    public function placeOrder()
    {
        $this->validate([
            'address_text' => 'required|string|max:255',
            'payment_method' => 'required|in:cod,stripe',
        ]);

        $cart_items = CartManagement::getCartItemsFromCookie();

        if (empty($cart_items)) {
            session()->flash('error', 'Keranjang masih kosong.');
            return;
        }

        $total = CartManagement::calculateGrandTotal($cart_items);

        // Buat order baru
        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => $total,
            'status' => 'new',
            'payment_method' => $this->payment_method,
            'address_text' => $this->address_text,
        ]);

        // Simpan item order
        foreach ($cart_items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'price' => $item['unit_amount'],
                'qty' => $item['quantity'],
                'subtotal' => $item['total_amount'],
            ]);
        }

        // Bersihkan keranjang
        CartManagement::clearCartItems();

        // Kirim email (opsional, bisa dihapus kalau belum setup Mailtrap)
        // Mail::to(Auth::user())->send(new OrderPlaced($order));

        return redirect()->route('success')->with('order_id', $order->id);
    }

    public function render()
    {
        $cart_items = CartManagement::getCartItemsFromCookie();
        $grand_total = CartManagement::calculateGrandTotal($cart_items);

        return view('livewire.checkout-page', [
            'cart_items' => $cart_items,
            'grand_total' => $grand_total,
        ]);
    }
}
