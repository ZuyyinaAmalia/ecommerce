<!DOCTYPE html>
<html>
<head>
    <title>Daftar Produk</title>
</head>
<body>
    <h1>🛍️ Daftar Produk</h1>
    <nav>
        <a href="/">Home</a> |
        <a href="/products">Produk</a> |
        <a href="/cart">Keranjang</a> |
        <a href="/profile">Profil</a>
    </nav>

    <form action="/search" method="GET">
        <input type="text" name="q" placeholder="Cari produk...">
        <button type="submit">Cari</button>
    </form>

    <h2>Produk:</h2>
    <ul>
        @forelse($products as $product)
            <li>
                {{ $product->name }} - Rp{{ number_format($product->price, 0, ',', '.') }}  
                <form action="/cart/add/{{ $product->id }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit">Add to Cart</button>
                </form>
            </li>
        @empty
            <li>Belum ada produk.</li>
        @endforelse
    </ul>
</body>
</html>
