<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
  <section 
    class="overflow-hidden bg-white py-11 font-poppins dark:bg-gray-800"
    x-data="{ mainImage: '{{ url('storage', $product->image[0]) }}' }"
  >
    <div class="max-w-6xl px-4 py-4 mx-auto lg:py-8 md:px-6">
      <div class="flex flex-col lg:flex-row gap-10 items-start">

        <!-- BAGIAN KIRI: GAMBAR PRODUK -->
        <div class="w-full lg:w-1/2 flex flex-col items-center">
          <!-- Gambar Utama -->
          <div class="w-full max-w-md h-[400px] flex items-center justify-center border border-gray-200 rounded-lg overflow-hidden">
            <img 
              x-bind:src="mainImage" 
              alt="{{ $product->name }}" 
              class="object-cover w-full h-full"
            >
          </div>

          <!-- Thumbnail -->
          <div class="flex flex-wrap justify-center gap-3 mt-6">
            @foreach ($product->image as $image)
              <div 
                class="w-20 h-20 border border-gray-200 rounded-md overflow-hidden cursor-pointer hover:scale-105 transition-transform"
                x-on:click="mainImage='{{ url('storage', $image) }}'"
              >
                <img 
                  src="{{ url('storage', $image) }}" 
                  alt="{{ $product->name }}" 
                  class="object-cover w-full h-full"
                >
              </div>
            @endforeach
          </div>
        </div>

        <!-- BAGIAN KANAN: INFORMASI PRODUK -->
        <div class="w-full lg:w-1/2 space-y-6">
          <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200">
            {{ $product->name }}
          </h2>

          <div>
            <p class="text-4xl font-bold text-gray-900 dark:text-gray-100">
              {{ Number::currency($product->price, 'IDR') }}
            </p>
            <p class="text-base line-through text-gray-400">IDR 1,000,000.00</p>
          </div>

          <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
            {{ $product->description }}
          </p>

          <!-- Quantity -->
          <div>
            <label class="block text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Quantity</label>
            <div class="flex items-center w-32 bg-gray-200 rounded-lg overflow-hidden">
              <button class="w-10 h-10 text-gray-700 font-bold text-lg hover:bg-gray-300">-</button>
              <input type="number" readonly value="1" class="w-12 text-center bg-gray-200 text-gray-700 font-semibold">
              <button class="w-10 h-10 text-gray-700 font-bold text-lg hover:bg-gray-300">+</button>
            </div>
          </div>

          <!-- Tombol Add to Cart -->
          <button class="w-full lg:w-2/5 py-3 mt-4 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition-colors">
            Add to cart
          </button>

          <!-- Info tambahan -->
          <div class="flex items-center mt-6 text-gray-600 dark:text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18l-1.5 13.5a1.5 1.5 0 01-1.5 1.5H6a1.5 1.5 0 01-1.5-1.5L3 3z" />
            </svg>
            Free Shipping
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
