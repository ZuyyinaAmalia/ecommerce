<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
  <h1 class="text-4xl font-bold text-slate-500">Order Details</h1>

  <!-- Grid -->
  <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mt-5">
    <!-- Customer -->
    <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-slate-900 dark:border-gray-800">
      <div class="p-4 md:p-5 flex gap-x-4">
        <div class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
          <svg class="flex-shrink-0 size-5 text-gray-600 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
          </svg>
        </div>

        <div class="grow">
          <p class="text-xs uppercase tracking-wide text-gray-500">Customer</p>
          <div class="mt-1">{{ $order->user->name ?? 'Unknown' }}</div>
        </div>
      </div>
    </div>

    <!-- Order Date -->
    <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-slate-900 dark:border-gray-800">
      <div class="p-4 md:p-5 flex gap-x-4">
        <div class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
          <svg class="flex-shrink-0 size-5 text-gray-600 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M5 22h14M5 2h14M17 22v-4.172a2 2 0 0 0-.586-1.414L12 12l-4.414 4.414A2 2 0 0 0 7 17.828V22M7 2v4.172a2 2 0 0 0 .586 1.414L12 12l4.414-4.414A2 2 0 0 0 17 6.172V2"/>
          </svg>
        </div>

        <div class="grow">
          <p class="text-xs uppercase tracking-wide text-gray-500">Order Date</p>
          <h3 class="text-xl font-medium text-gray-800 dark:text-gray-200 mt-1">
            {{ $order->created_at->format('d-m-Y') }}
          </h3>
        </div>
      </div>
    </div>

    <!-- Order Status -->
    <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-slate-900 dark:border-gray-800">
      <div class="p-4 md:p-5 flex gap-x-4">
        <div class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
          <svg class="flex-shrink-0 size-5 text-gray-600 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 11V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h6"/>
            <path d="m12 12 4 10 1.7-4.3L22 16Z"/>
          </svg>
        </div>

        <div class="grow">
          <p class="text-xs uppercase tracking-wide text-gray-500">Order Status</p>
          <div class="mt-1">
            @php
              $statusColor = match($order->status) {
                  'new' => 'bg-blue-500',
                  'processing' => 'bg-yellow-500',
                  'shipped' => 'bg-green-500',
                  'delivered' => 'bg-green-700',
                  'cancelled' => 'bg-red-700',
                  default => 'bg-gray-500',
              };
            @endphp
            <span class="{{ $statusColor }} py-1 px-3 rounded text-white shadow capitalize">{{ $order->status }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Payment Method -->
    <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-slate-900 dark:border-gray-800">
      <div class="p-4 md:p-5 flex gap-x-4">
        <div class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
          <svg class="flex-shrink-0 size-5 text-gray-600 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M5 12s2.545-5 7-5c4.454 0 7 5 7 5s-2.546 5-7 5c-4.455 0-7-5-7-5z"/>
            <path d="M12 13a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
            <path d="M21 17v2a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-2M21 7V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2"/>
          </svg>
        </div>

        <div class="grow">
          <p class="text-xs uppercase tracking-wide text-gray-500">Payment Method</p>
          <div class="mt-1">
            @php
              $methodColor = $order->payment_method === 'cod' ? 'bg-gray-600' : 'bg-purple-600';
              $methodText = $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Stripe';
            @endphp
            <span class="{{ $methodColor }} py-1 px-3 rounded text-white shadow">{{ $methodText }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Grid -->

  <div class="flex flex-col md:flex-row gap-4 mt-4">
    <!-- Order Items -->
    <div class="md:w-3/4">
      <div class="bg-white overflow-x-auto rounded-lg shadow-md p-6 mb-4">
        <table class="w-full">
          <thead>
            <tr>
              <th class="text-left font-semibold">Product</th>
              <th class="text-left font-semibold">Price</th>
              <th class="text-left font-semibold">Quantity</th>
              <th class="text-left font-semibold">Total</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($order_items as $item)
            <tr wire:key="{{ $item->id }}">
              <td class="py-4">
                <div class="flex items-center">
                  <img class="h-16 w-16 mr-4" src="{{ url('storage', $item->product->images) }}" alt="{{ $item->product->name }}">
                  <span class="font-semibold">{{ $item->product->name }}</span>
                </div>
              </td>
              <td class="py-4">{{ Number::currency($item->unit_amount, 'IDR') }}</td>
              <td class="py-4"><span class="text-center w-8">{{ $item->quantity }}</span></td>
              <td class="py-4">{{ Number::currency($item->total_amount, 'IDR') }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- Shipping Address -->
      <div class="bg-white overflow-x-auto rounded-lg shadow-md p-6 mb-4">
        <h1 class="font-3xl font-bold text-slate-500 mb-3">Shipping Address</h1>
        <div class="flex justify-between items-center">
          <div>
            <p>{{ $order->address_text ?? 'Alamat belum tersedia' }}</p>
          </div>
          <div>
            <p class="font-semibold">Phone:</p>
            <p>{{ $order->phone ?? '-' }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Summary -->
    <div class="md:w-1/4">
      <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-lg font-semibold mb-4">Summary</h2>
        <div class="flex justify-between mb-2">
          <span>Subtotal</span>
          <span>{{ Number::currency($order->total, 'IDR') }}</span>
        </div>
        <div class="flex justify-between mb-2">
          <span>Taxes</span>
          <span>Rp0</span>
        </div>
        <div class="flex justify-between mb-2">
          <span>Shipping</span>
          <span>Rp0</span>
        </div>
        <hr class="my-2">
        <div class="flex justify-between mb-2">
          <span class="font-semibold">Grand Total</span>
          <span class="font-semibold">{{ Number::currency($order->total, 'IDR') }}</span>
        </div>
      </div>
    </div>
  </div>
</div>
