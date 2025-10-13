<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - UMKM Ecommerce</title>

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#0891b2', // biru toska
            accent: '#facc15',  // kuning cerah
            soft: '#f3f4f6',    // abu lembut
          }
        }
      }
    }
  </script>
</head>
<body class="bg-soft">

  <!-- Navbar -->
  <nav class="bg-primary text-white px-8 py-4 flex justify-between items-center shadow-lg sticky top-0 z-50">
    <div class="flex items-center space-x-2">
      <img src="https://cdn-icons-png.flaticon.com/512/869/869636.png" alt="logo" class="w-9 h-9">
      <h1 class="text-2xl font-extrabold">UMKM <span class="text-accent">Ecommerce</span></h1>
    </div>
    <div class="hidden md:flex space-x-8 text-lg">
      <a href="/" class="hover:text-accent">Home</a>
      <a href="/products" class="hover:text-accent">Produk</a>
      <a href="/cart" class="hover:text-accent">Keranjang</a>
      <a href="/profile" class="hover:text-accent">Profil</a>
    </div>
  </nav>

  <!-- Hero -->
  <section class="bg-gradient-to-r from-primary to-accent p-14 text-center text-white shadow-md">
    <h2 class="text-4xl font-extrabold mb-4">Belanja Produk UMKM Indonesia 🌏</h2>
    <p class="text-lg mb-6">Temukan produk lokal berkualitas tinggi dengan harga terbaik.</p>
    <a href="/products" class="bg-white text-primary font-bold px-6 py-3 rounded-lg shadow hover:bg-gray-100">
      Belanja Sekarang
    </a>
  </section>

  <!-- Main Content -->
  <div class="max-w-7xl mx-auto mt-10 grid grid-cols-12 gap-8 px-4">

    <!-- Sidebar kategori -->
    <aside class="col-span-12 md:col-span-3 bg-white p-6 rounded-lg shadow-lg">
      <h3 class="font-bold text-xl mb-4 border-b pb-2">Kategori</h3>
      <ul class="space-y-3">
        <li><a href="#" class="block hover:text-primary">🍜 Makanan</a></li>
        <li><a href="#" class="block hover:text-primary">👕 Fashion</a></li>
        <li><a href="#" class="block hover:text-primary">🎨 Kerajinan</a></li>
        <li><a href="#" class="block hover:text-primary">🔌 Elektronik</a></li>
      </ul>
    </aside>

    <!-- Produk -->
    <main class="col-span-12 md:col-span-9">
      <h3 class="text-2xl font-bold mb-6">🔥 Produk Populer</h3>
      <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Card produk -->
        <div class="bg-white rounded-lg shadow-md hover:shadow-xl p-4 transition">
          <img src="https://via.placeholder.com/300x200" alt="produk" class="rounded mb-4 w-full">
          <h4 class="font-bold text-lg">Produk A</h4>
          <p class="text-gray-600">Rp50.000</p>
          <button class="mt-3 w-full bg-primary text-white py-2 rounded-lg hover:bg-accent hover:text-black transition">
            🛒 Tambah ke Keranjang
          </button>
        </div>

        <div class="bg-white rounded-lg shadow-md hover:shadow-xl p-4 transition">
          <img src="https://via.placeholder.com/300x200" alt="produk" class="rounded mb-4 w-full">
          <h4 class="font-bold text-lg">Produk B</h4>
          <p class="text-gray-600">Rp75.000</p>
          <button class="mt-3 w-full bg-primary text-white py-2 rounded-lg hover:bg-accent hover:text-black transition">
            🛒 Tambah ke Keranjang
          </button>
        </div>

        <div class="bg-white rounded-lg shadow-md hover:shadow-xl p-4 transition">
          <img src="https://via.placeholder.com/300x200" alt="produk" class="rounded mb-4 w-full">
          <h4 class="font-bold text-lg">Produk C</h4>
          <p class="text-gray-600">Rp120.000</p>
          <button class="mt-3 w-full bg-primary text-white py-2 rounded-lg hover:bg-accent hover:text-black transition">
            🛒 Tambah ke Keranjang
          </button>
        </div>
      </div>
    </main>
  </div>

  <!-- Footer -->
  <footer class="bg-primary text-white text-center py-6 mt-12">
    <p>&copy; 2025 UMKM Ecommerce. Dibuat dengan ❤️ oleh Kelompok 5.</p>
  </footer>

</body>
</html>
