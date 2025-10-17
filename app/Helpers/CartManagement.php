<?php

namespace App\Helpers;

use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Cookie;

class CartManagement
{
    // =============================
    // 🔹 Get all cart items
    // =============================
    public static function getCartItems()
    {
        if (auth()->check()) {
            $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
            return $cart->items()->with('product')->get()->map(function ($item) {
                return [
                    'product_id' => $item->product->id,
                    'name' => $item->product->name,
                    'image' => $item->product->image[0] ?? null,
                    'quantity' => $item->qty,
                    'unit_amount' => $item->product->price,
                    'total_amount' => $item->product->price * $item->qty,
                ];
            })->toArray();
        }

        // Guest
        $cart = json_decode(Cookie::get('cart_items'), true);
        return is_array($cart) ? $cart : [];
    }

    // =============================
    // 🔹 Add item to cart
    // =============================
    public static function addItemToCart($product_id)
    {
        if (auth()->check()) {
            $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
            $item = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $product_id)
                ->first();

            if ($item) {
                $item->increment('qty');
            } else {
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $product_id,
                    'qty' => 1,
                ]);
            }

            return self::getCartItems();
        }

        // Guest
        $cart_items = self::getCartItemsFromCookie();
        $found = false;

        foreach ($cart_items as &$item) {
            if ($item['product_id'] == $product_id) {
                $item['quantity']++;
                $item['total_amount'] = $item['quantity'] * $item['unit_amount'];
                $found = true;
                break;
            }
        }

        if (!$found) {
            $product = Product::find($product_id, ['id', 'name', 'price', 'image']);
            if ($product) {
                $cart_items[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'image' => $product->image[0] ?? null,
                    'quantity' => 1,
                    'unit_amount' => $product->price,
                    'total_amount' => $product->price,
                ];
            }
        }

        self::saveCartItemsToCookie($cart_items);
        return $cart_items;
    }

    // =============================
    // 🔹 Remove item from cart
    // =============================
    public static function removeItemFromCart($product_id)
    {
        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->id())->first();
            if ($cart) {
                CartItem::where('cart_id', $cart->id)
                    ->where('product_id', $product_id)
                    ->delete();
            }
            return self::getCartItems();
        }

        // Guest
        $cart_items = array_filter(self::getCartItemsFromCookie(), fn($item) => $item['product_id'] != $product_id);
        self::saveCartItemsToCookie(array_values($cart_items));
        return $cart_items;
    }

    // =============================
    // 🔹 Increment quantity
    // =============================
    public static function incrementQuantity($product_id)
    {
        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->id())->first();
            if ($cart) {
                $item = CartItem::where('cart_id', $cart->id)->where('product_id', $product_id)->first();
                if ($item) $item->increment('qty');
            }
            return self::getCartItems();
        }

        $cart_items = self::getCartItemsFromCookie();
        foreach ($cart_items as &$item) {
            if ($item['product_id'] == $product_id) {
                $item['quantity']++;
                $item['total_amount'] = $item['quantity'] * $item['unit_amount'];
            }
        }
        self::saveCartItemsToCookie($cart_items);
        return $cart_items;
    }

    // =============================
    // 🔹 Decrement quantity
    // =============================
    public static function decrementQuantity($product_id)
    {
        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->id())->first();
            if ($cart) {
                $item = CartItem::where('cart_id', $cart->id)->where('product_id', $product_id)->first();
                if ($item && $item->qty > 1) $item->decrement('qty');
            }
            return self::getCartItems();
        }

        $cart_items = self::getCartItemsFromCookie();
        foreach ($cart_items as &$item) {
            if ($item['product_id'] == $product_id && $item['quantity'] > 1) {
                $item['quantity']--;
                $item['total_amount'] = $item['quantity'] * $item['unit_amount'];
            }
        }
        self::saveCartItemsToCookie($cart_items);
        return $cart_items;
    }

    // =============================
    // 🔹 Calculate grand total
    // =============================
    public static function calculateGrandTotal($items)
    {
        if (!is_array($items)) return 0;
        return array_sum(array_column($items, 'total_amount'));
    }

    // =============================
    // 🔹 Cookie helpers
    // =============================
    public static function getCartItemsFromCookie()
    {
        $cart = json_decode(Cookie::get('cart_items', '[]'), true);
        return is_array($cart) ? $cart : [];
    }

    private static function saveCartItemsToCookie($cart_items)
    {
        Cookie::queue('cart_items', json_encode($cart_items), 60 * 24 * 30);
    }

    public static function clearCartItems()
    {
        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->id())->first();
            if ($cart) $cart->items()->delete();
        } else {
            Cookie::queue(Cookie::forget('cart_items'));
        }
    }

    public static function mergeGuestCartToUserCart($user, $guestCart)
    {
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        foreach ($guestCart as $item) {
            $existingItem = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $item['product_id'])
                ->first();

            if ($existingItem) {
                $existingItem->qty += $item['quantity'];
                $existingItem->save();
            } else {
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $item['product_id'],
                    'qty' => $item['quantity'],
                ]);
            }
        }

        // 🧹 Hapus cookie setelah data dimigrasi
        Cookie::queue(Cookie::forget('cart_items'));
    }

}
