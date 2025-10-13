<header class="flex z-50 sticky top-0 flex-wrap md:justify-start md:flex-nowrap w-full bg-white text-sm py-3 md:py-0 dark:bg-gray-800 shadow-md">
  <nav class="max-w-[85rem] w-full mx-auto px-4 md:px-6 lg:px-8" aria-label="Global">
    <div class="relative md:flex md:items-center md:justify-between">
      <div class="flex items-center justify-between">
        <a class="flex-none text-xl font-semibold dark:text-white dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="/" aria-label="Brand">
          Kelompok 5
        </a>
        <div class="md:hidden">
          <button type="button" class="hs-collapse-toggle flex justify-center items-center w-9 h-9 text-sm font-semibold rounded-lg border border-gray-200 text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" data-hs-collapse="#navbar-collapse-with-animation" aria-controls="navbar-collapse-with-animation" aria-label="Toggle navigation">
            <svg class="hs-collapse-open:hidden flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="3" x2="21" y1="6" y2="6" />
              <line x1="3" x2="21" y1="12" y2="12" />
              <line x1="3" x2="21" y1="18" y2="18" />
            </svg>
            <svg class="hs-collapse-open:block hidden flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M18 6 6 18" />
              <path d="m6 6 12 12" />
            </svg>
          </button>
        </div>
      </div>

      <div id="navbar-collapse-with-animation" class="hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow md:block">
        <div class="overflow-hidden overflow-y-auto max-h-[75vh] md:max-h-none">
          <div class="flex flex-col gap-x-0 mt-5 divide-y divide-dashed divide-gray-200 md:flex-row md:items-center md:justify-end md:gap-x-7 md:mt-0 md:divide-y-0 md:divide-solid dark:divide-gray-700">

            {{-- Link Navigasi --}}
            <a wire:navigate href="/" class="font-medium {{ request()->is('/') ? 'text-blue-600' : 'text-gray-500' }} py-3 md:py-6 dark:text-blue-500">
              Home
            </a>

            <a wire:navigate href="/categories" class="font-medium {{ request()->is('categories') ? 'text-blue-600' : 'text-gray-500' }} hover:text-gray-400 py-3 md:py-6 dark:text-gray-400 dark:hover:text-gray-500">
              Categories
            </a>

            <a wire:navigate href="/products" class="font-medium {{ request()->is('products') ? 'text-blue-600' : 'text-gray-500' }} hover:text-gray-400 py-3 md:py-6 dark:text-gray-400 dark:hover:text-gray-500">
              Products
            </a>

            <a wire:navigate href="/cart" class="font-medium flex items-center {{ request()->is('cart') ? 'text-blue-600' : 'text-gray-500' }} hover:text-gray-400 py-3 md:py-6 dark:text-gray-400 dark:hover:text-gray-500">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="flex-shrink-0 w-5 h-5 mr-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
              </svg>
              <span class="mr-1">Cart</span>
              <span class="py-0.5 px-1.5 rounded-full text-xs font-medium bg-blue-50 border border-blue-200 text-blue-600">4</span>
            </a>

            {{-- Tombol Login --}}
            @guest
              <div class="pt-3 md:pt-0">
                <a wire:navigate href="/login" class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700">
                  <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                  </svg>
                  Log in
                </a>
              </div>
            @endguest

            {{-- Dropdown User --}}
            @auth
              <div class="hs-dropdown relative inline-flex [--trigger:click] [--placement:bottom-right] md:py-4">
                  <button
                    id="dropdown-user"
                    type="button"
                    class="hs-dropdown-toggle flex items-center text-gray-600 hover:text-gray-800 font-medium dark:text-gray-300 dark:hover:text-gray-100"
                    aria-expanded="false"
                  >
                    @if (auth()->user()->profile_photo)
                      <img 
                        src="{{ asset('storage/' . auth()->user()->profile_photo) }}" 
                        alt="Profile Photo" 
                        class="w-6 h-6 rounded-full mr-2 object-cover"
                      >
                    @else
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2 text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 7.5a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 19.5a8.25 8.25 0 0 1 15 0v.75H4.5v-.75Z" />
                      </svg>
                    @endif

                    {{ auth()->user()->name }}
                    <svg class="ms-2 w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path d="m6 9 6 6 6-6" />
                    </svg>
                  </button>

                <div
                  class="hs-dropdown-menu absolute right-0 mt-2 z-50 hidden min-w-[10rem] bg-white shadow-md rounded-lg p-2 dark:bg-gray-800"
                  aria-labelledby="dropdown-user"
                >
                  <a wire:navigate href="/my-orders" class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm hover:bg-gray-100 dark:hover:bg-gray-700">
                    My Orders
                  </a>
                  <a wire:navigate href="/account" class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm hover:bg-gray-100 dark:hover:bg-gray-700">
                    My Account
                  </a>
                  <a href="/logout" class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm hover:bg-gray-100 dark:hover:bg-gray-700">
                    Logout
                  </a>
                </div>
              </div>
            @endauth
          </div>
        </div>
      </div>
    </div>
  </nav>
</header>