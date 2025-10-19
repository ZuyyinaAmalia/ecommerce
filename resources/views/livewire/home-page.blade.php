<div>
    <!-- Hero section start -->
    <div class="w-full h-screen bg-no-repeat bg-center bg-gray-50" style="background-image: url('{{ asset('storage/home.png') }}'); background-size: cover;">
        <div class="w-full h-full flex items-center justify-center py-10 px-4 sm:px-6 lg:px-8 mx-auto pt-16">
            <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Grid -->
                <div class="grid md:grid-cols-2 gap-4 md:gap-8 xl:gap-20 md:items-center">
                    <div class="text-center md:text-left">
                        <!-- <h1 class="block text-4xl font-bold text-gray-800 sm:text-5xl lg:text-7xl lg:leading-tight mb-4">
                            EXPRESS YOUR STYLE WITH BATIK
                        </h1> -->
                        <h2 class="block text-2xl font-bold text-gray-800 sm:text-3xl lg:text-5xl lg:leading-tight mb-6">
                            EXPRESS YOUR STYLE WITH BATIK
                        </h2>
                        <p class="text-lg text-gray-700 sm:text-xl lg:text-2xl italic mb-8 max-w-2xl">
                            Tradisi tak pernah ketinggalan zaman. Saatnya tampil modern tanpa meninggalkan akar budaya.
                        </p>

                        <!-- Button -->
                        <div class="mt-8">
                            <a class="inline-flex items-center justify-center px-8 py-4 text-base font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 transition duration-300 transform hover:scale-105" href="/shop">
                                SHOP NOW
                                <svg class="flex-shrink-0 w-4 h-4 ml-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m9 18 6-6-6-6" />
                                </svg>
                            </a>
                        </div>
                        <!-- End Button -->
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Grid -->
            </div>
        </div>
    </div>
    <!-- Hero section End -->
    <!-- Category Section Start -->
    <div class="bg-orange-200 py-20">
    <div class="max-w-xl mx-auto">
        <div class="text-center ">
        <div class="relative flex flex-col items-center">
            <h1 class="text-5xl font-bold dark:text-gray-200"> Browse <span class="text-blue-500"> Categories
            </span> </h1>
            <div class="flex w-40 mt-2 mb-6 overflow-hidden rounded">
            <div class="flex-1 h-2 bg-blue-200">
            </div>
            <div class="flex-1 h-2 bg-blue-400">
            </div>
            <div class="flex-1 h-2 bg-blue-600">
            </div>
            </div>
        </div>
        <p class="mb-12 text-base text-center text-gray-500">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Delectus magni eius eaque?
            Pariatur
            numquam, odio quod nobis ipsum ex cupiditate?
        </p>
        </div>
    </div>

    <div class="max-w-[85rem] px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">

        @foreach($categories as $category)
            <a class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md transition dark:bg-slate-900 dark:border-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="#" wire:key="{{ $category->id }}">
                <div class="p-4 md:p-5">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                    <img class="h-[2.375rem] w-[2.375rem] rounded-full" src="{{ url('storage', $category->image) }}" alt="{{ $category->name }}">
                    <div class="ms-3">
                        <h3 class="group-hover:text-blue-600 font-semibold text-gray-800 dark:group-hover:text-gray-400 dark:text-gray-200">
                        {{ $category->name }}
                        </h3>
                    </div>
                    </div>
                    <div class="ps-3">
                    <svg class="flex-shrink-0 w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                    </div>
                </div>
                </div>
            </a>
        @endforeach

        </div>
    </div>
    </div>
    <!-- Category Section End -->
</div>
