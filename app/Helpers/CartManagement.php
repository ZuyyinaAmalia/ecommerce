<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Cookie;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;

class CartManagement {
    // add item to cart
    static public function addItemToCart($product_id) {
        $cart_items = self::getCartItemsFromCookie();

        $existing_item = null;

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                $existing_item = $key;
                break;
            }
        }

        if ($existing_item !== null) {
            $cart_items[$existing_item]['qty']++;
            $cart_items[$existing_item]['total']= $cart_items[$existing_item]['qty'] * $cart_items[$existing_item]['price'];
        } else {
            $product = Product::where('id', $product_id)->first(['id', 'name', 'price', 'image']);
            if($product) {
                $cart_items[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'image' => $product->image,
                    'price' => $product->price,
                    'qty' => 1,
                    'unit_amout' => $product->price,
                    'total' => $product->price,
                ];
            }
        }

        self::addCartItemsToCookie($cart_items);
        return count($cart_items);
    }

    // add item to cart with qty
    static public function addItemToCartWithQty($product_id, $qty = 1) {
        $cart_items = self::getCartItemsFromCookie();

        $existing_item = null;

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                $existing_item = $key;
                break;
            }
        }

        if ($existing_item !== null) {
            // assignment, bukan perbandingan
            $cart_items[$existing_item]['qty'] = $qty;
            // hitung total sesuai qty
            $cart_items[$existing_item]['total'] = $cart_items[$existing_item]['qty'] * $cart_items[$existing_item]['price'];
        } else {
            $product = Product::where('id', $product_id)->first(['id', 'name', 'price', 'image']);
            if($product) {
                $cart_items[] = [
                    'product_id'  => $product->id,
                    'name'        => $product->name,
                    'image'       => $product->image,
                    'price'       => $product->price,
                    'qty'         => $qty,
                    'unit_amount' => $product->price,
                    'total'       => $product->price * $qty,
                ];
            }
        }

        self::addCartItemsToCookie($cart_items);
        return count($cart_items);
    }
    



    // remove item from cart
    static public function removeCartItem($product_id) {
        $cart_items = self::getCartItemsFromCookie();

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                unset($cart_items[$key]);
            }
        }

        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }

    // add cart item to cookie
    static public function addCartItemsToCookie($cart_items) {
        Cookie::queue('cart_items', json_encode($cart_items), 60 * 24 * 30); // 30 days
    }

    // clear cart item from cookie
    static public function clearCartItems() {
        Cookie::queue(Cookie::forget('cart_items'));
    }

    // get all cart items from cookie
    static public function getCartItemsFromCookie() {
        $cart_items = json_decode(Cookie::get('cart_items'), true);
        if (!$cart_items) {
            $cart_items = [];
        }

        return $cart_items;
    }

    // increment item quantity
    static public function incrementQuantityToCartItem($product_id) {
        $cart_items = self::getCartItemsFromCookie();

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                $cart_items[$key]['qty']++;
                $cart_items[$key]['total']= $cart_items[$key]['qty'] * $cart_items[$key]['price'];
                break;
            }
        }

        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }

    // decrement item quantity
    public static function decrementQuantityToCartItem($product_id) {
        $cart_items = self::getCartItemsFromCookie();

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                if ($cart_items[$key]['qty'] > 1) {
                    $cart_items[$key]['qty']--;
                    $cart_items[$key]['total']= $cart_items[$key]['qty'] * $cart_items[$key]['price'];
                }
                break;
            }
        }

        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }

    // callculate total price
    static public function calculateTotal($items) {
        return array_sum(array_column($items, 'total'));
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
    }

}