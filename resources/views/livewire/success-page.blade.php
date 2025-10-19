<section class="flex items-center font-poppins dark:bg-gray-800">
  <div class="justify-center flex-1 max-w-6xl px-4 py-6 mx-auto bg-white border rounded-md 
              dark:border-gray-900 dark:bg-gray-900 md:py-10 md:px-10">

    @if($order)
      <h1 class="px-4 mb-8 text-2xl font-semibold tracking-wide text-gray-700 dark:text-gray-300">
        🎉 Thank you, {{ $order->user->name ?? 'Customer' }}! Your order has been received.
      </h1>

      {{-- 📦 Order Info --}}
      <div class="flex flex-wrap items-center pb-4 mb-8 border-b border-gray-200 dark:border-gray-700">
        <div class="w-full px-4 mb-4 md:w-1/4">
          <p class="mb-1 text-sm text-gray-600 dark:text-gray-400">Order Number:</p>
          <p class="text-base font-semibold text-gray-800 dark:text-gray-200">#{{ $order->id }}</p>
        </div>

        <div class="w-full px-4 mb-4 md:w-1/4">
          <p class="mb-1 text-sm text-gray-600 dark:text-gray-400">Date:</p>
          <p class="text-base font-semibold text-gray-800 dark:text-gray-200">
            {{ $order->created_at ? $order->created_at->format('d M Y') : '-' }}
          </p>
        </div>

        @php
          $computedTotal = $order->orderItems ? $order->orderItems->sum('subtotal') : 0;
        @endphp

        <div class="w-full px-4 mb-4 md:w-1/4">
          <p class="mb-1 text-sm text-gray-600 dark:text-gray-400">Total:</p>
          <p class="text-base font-semibold text-blue-600 dark:text-blue-400">
            {{ Number::currency($order->total_price ?: $computedTotal, 'IDR') }}
          </p>
        </div>

        <div class="w-full px-4 mb-4 md:w-1/4">
          <p class="mb-1 text-sm text-gray-600 dark:text-gray-400">Payment Method:</p>
          <p class="text-base font-semibold text-gray-800 dark:text-gray-200">
            {{ ucfirst($order->payment_method ?? 'stripe') }}
          </p>
        </div>
      </div>

      {{-- 📋 Order Details --}}
      <div class="px-4 mb-10">
        <h2 class="mb-3 text-xl font-semibold text-gray-700 dark:text-gray-300">Order Details</h2>

        @if($order->orderItems && $order->orderItems->count())
          <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($order->orderItems as $item)
              <div class="flex justify-between py-2">
                <div>
                  <p class="font-medium text-gray-800 dark:text-gray-200">{{ $item->product->name ?? 'Unknown Product' }}</p>
                  <p class="text-sm text-gray-500 dark:text-gray-400">x{{ $item->quantity }}</p>
                </div>
                <p class="text-gray-700 dark:text-gray-300">
                  {{ Number::currency($item->subtotal ?? (($item->price ?? 0) * ($item->quantity ?? 1)), 'IDR') }}
                </p>
              </div>
            @endforeach
          </div>
        @else
          <p class="text-gray-500 dark:text-gray-400">No order items found.</p>
        @endif

        <div class="flex justify-between mt-4 font-semibold text-gray-800 dark:text-gray-300">
          <p>Total:</p>
          <p class="text-blue-600 dark:text-blue-400">
            {{ Number::currency($order->total_price ?: $computedTotal, 'IDR') }}
          </p>
        </div>
      </div>

      {{-- 🚚 Shipping --}}
      <div class="px-4 mb-10">
        <h2 class="mb-3 text-xl font-semibold text-gray-700 dark:text-gray-300">Shipping Information</h2>
        <p class="text-gray-700 dark:text-gray-300">{{ $order->shipping_address ?? '-' }}</p>
      </div>

      {{-- 🔙 Buttons --}}
      <div class="flex items-center justify-start gap-4 px-4 mt-6">
        <a href="/products" 
           class="w-full text-center px-4 py-2 text-blue-500 border border-blue-500 rounded-md md:w-auto 
                  hover:text-white hover:bg-blue-600 dark:border-gray-700 dark:hover:bg-gray-700 dark:text-gray-300">
          Go back shopping
        </a>
        <a href="/my-orders" 
           class="w-full text-center px-4 py-2 bg-blue-500 rounded-md text-gray-50 md:w-auto 
                  hover:bg-blue-600 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-gray-300">
          View My Orders
        </a>
      </div>

    @else
      <div class="text-center py-10 text-gray-500 dark:text-gray-400">
        No completed order found.
      </div>
    @endif
  </div>
</section>


