<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
  <section class="py-10 bg-gray-50 font-poppins dark:bg-gray-800 rounded-lg">
    <div class="px-4 py-4 mx-auto max-w-7xl lg:py-6 md:px-6">

      {{-- 🔍 Search + Sort + Filter Row --}}
      <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 
                  bg-gray-100 dark:bg-gray-900 p-4 rounded-md gap-4 shadow-sm border 
                  border-gray-200 dark:border-gray-700">

        {{-- 🔍 Search --}}
        <div class="w-full md:w-1/3">
          <input 
            type="text" 
            wire:model.live.debounce.500ms="search"
            placeholder="Search products..."
            class="w-full px-4 py-2 border border-gray-300 rounded-md 
                   dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 
                   focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
          >
        </div>

        {{-- 🧩 Filter Kategori --}}
        <div class="w-full md:w-1/3 flex flex-wrap items-center gap-3">
          <span class="font-semibold dark:text-gray-300">Filter:</span>
          @foreach ($categories as $category)
            <label for="category-{{ $category->id }}" 
                   class="flex items-center text-sm text-gray-700 dark:text-gray-300">
              <input 
                type="checkbox" 
                wire:model.live="selected_categories" 
                id="category-{{ $category->id }}" 
                value="{{ $category->id }}" 
                class="w-4 h-4 mr-2 text-blue-600 border-gray-300 rounded 
                       focus:ring-blue-500 focus:ring-2"
              >
              {{ $category->name }}
            </label>
          @endforeach
        </div>

        {{-- 📊 Sort --}}
        <div class="w-full md:w-1/4">
          <select 
            wire:model.live="sort"
            class="w-full px-3 py-2 border border-gray-300 rounded-md 
                   dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 
                   focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
          >
            <option value="latest">Sort by Latest</option>
            <option value="price_asc">Price: Low to High</option>
            <option value="price_desc">Price: High to Low</option>
          </select>
        </div>
      </div>
      {{-- End Search + Sort + Filter Row --}}

      {{-- 📦 Produk Grid --}}
      <div class="flex flex-wrap items-center">
        @forelse ($products as $product)
          <div class="w-full px-3 mb-6 sm:w-1/2 md:w-1/3">
            <div class="border border-gray-300 dark:border-gray-700 rounded-lg 
                        overflow-hidden bg-white dark:bg-gray-900 shadow-sm 
                        hover:shadow-md transition">
              <div class="relative bg-gray-200 dark:bg-gray-800">
                <a href="{{ url('/products/' . $product->id) }}">
                  <img 
                    src="{{ url('storage', $product->image[0]) }}" 
                    alt="{{ $product->name }}" 
                    class="object-cover w-full h-56"
                  >
                </a>
              </div>
              <div class="p-4">
                <h3 class="text-lg font-semibold mb-2 dark:text-gray-200 truncate">
                  {{ $product->name }}
                </h3>
                <p class="text-green-600 dark:text-green-500 font-medium">
                  {{ Number::currency($product->price, 'IDR') }}
                </p>
              </div>
              <div class="flex justify-center p-4 border-t border-gray-200 dark:border-gray-700">
                <button
                  type="button"
                  wire:click="addToCart({{ $product->id }})"
                  class="text-gray-600 dark:text-gray-300 hover:text-blue-600 
                         dark:hover:text-blue-400 flex items-center gap-2 focus:outline-none"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" 
                       fill="currentColor" class="w-4 h-4 bi bi-cart3" viewBox="0 0 16 16">
                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 
                             .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 
                             0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 
                             0 0 1-.5-.5z"/>
                  </svg>
                  <span>Add to Cart</span>
                </button>
              </div>
            </div>
          </div>
        @empty
          <div class="w-full text-center py-10 text-gray-500 dark:text-gray-400">
            No products found.
          </div>
        @endforelse
      </div>

      {{-- 📄 Pagination --}}
      <div class="flex justify-end mt-6">
        {{ $products->links() }}
      </div>

    </div>
  </section>
</div>

