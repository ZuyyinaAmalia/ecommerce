<!DOCTYPE html>
<html>
<head>
    <title>Keranjang Belanja</title>
</head>
<body>
    <h1>🛒 Keranjang Belanja</h1>
    <nav>
        <a href="/">Home</a> |
        <a href="/products">Produk</a> |
        <a href="/cart">Keranjang</a> |
        <a href="/profile">Profil</a>
    </nav>

    <h2>Isi Keranjang:</h2>

    @if($cart && $cart->items->count() > 0)
        <ul>
            @foreach($cart->items as $item)
                <li>
                    {{ $item->product->name }} - Rp{{ number_format($item->product->price, 0, ',', '.') }}  
                    (Qty: {{ $item->qty }})
                </li>
            @endforeach
        </ul>
    @else
        <p>Keranjang kosong.</p>
    @endif
</body>
</html>
