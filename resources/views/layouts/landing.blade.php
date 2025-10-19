<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 text-gray-900">
    <nav class="bg-white shadow mb-8">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-blue-600">E-commerce Store</a>
            <ul class="flex space-x-6">
                <li><a href="/" class="hover:text-blue-600">Home</a></li>
                <li><a href="/products" class="hover:text-blue-600">Products</a></li>
                <li><a href="/about" class="hover:text-blue-600">About Us</a></li>
                <li><a href="/contact" class="hover:text-blue-600">Contact</a></li>
            </ul>
        </div>
    </nav>
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold mb-6">Welcome to Our E-commerce Store</h1>
        <section>
            <h2 class="text-2xl font-semibold mb-4">Featured Products</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @if(isset($products) && count($products))
                    @foreach($products as $product)
                        <div class="bg-white rounded-lg shadow p-4 flex flex-col items-center">
                            @if($product->image_url)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover mb-2 rounded">
                            @endif
                            <h3 class="text-lg font-bold mb-1">{{ $product->name }}</h3>
                            <p class="text-gray-600 mb-2">{{ $product->description }}</p>
                            <p class="font-semibold text-blue-600 mb-1">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                            <p class="text-sm text-gray-500">Stock: {{ $product->stock }}</p>
                        </div>
                    @endforeach
                @else
                    <p>No products available.</p>
                @endif
            </div>
        </section>
    </div>
    <footer class="bg-white text-center py-4 mt-8 shadow">
        &copy; {{ date('Y') }} E-commerce Store. All rights reserved.
    </footer>
</body>
</html>