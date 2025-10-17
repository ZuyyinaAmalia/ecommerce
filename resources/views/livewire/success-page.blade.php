@extends('layouts.app')

@section('title', 'Order Success')

@section('content')
<section class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 font-poppins py-12 px-4">
  <div class="w-full max-w-5xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm p-8 md:p-12">
    
    <!-- Header -->
    <div class="text-center mb-10">
      <h1 class="text-3xl font-semibold text-gray-800 dark:text-gray-100">
        🎉 Thank you! Your order has been received.
      </h1>
      <p class="text-gray-500 dark:text-gray-400 mt-2">A confirmation has been sent to your email.</p>
    </div>

    <!-- Customer Information -->
    <div class="grid md:grid-cols-2 gap-8 border-b border-gray-200 dark:border-gray-700 pb-8 mb-8">
      <div>
        <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-3">Customer Details</h2>
        <p class="text-gray-800 dark:text-gray-400 font-medium">Cielo Schimmel</p>
        <p class="text-gray-600 dark:text-gray-400">71582 Schmitt Springs</p>
        <p class="text-gray-600 dark:text-gray-400">Castro Valley, Delaware, 53476-0454</p>
        <p class="text-gray-600 dark:text-gray-400">📞 587-019-6103</p>
      </div>

      <!-- Order Info -->
      <div>
        <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-3">Order Summary</h2>
        <div class="space-y-2 text-gray-700 dark:text-gray-400">
          <p><span class="font-medium">Order Number:</span> 29</p>
          <p><span class="font-medium">Date:</span> 17-02-2024</p>
          <p><span class="font-medium">Payment Method:</span> Cash on Delivery</p>
          <p><span class="font-medium">Total:</span> <span class="text-blue-600 font-semibold">₹157,495.00</span></p>
        </div>
      </div>
    </div>

    <!-- Order Details -->
    <div class="grid md:grid-cols-2 gap-8 mb-10">
      <div>
        <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-4">Order Details</h2>
        <div class="space-y-3">
          <div class="flex justify-between border-b border-gray-100 dark:border-gray-700 pb-2">
            <p>Subtotal</p>
            <p>₹157,495.00</p>
          </div>
          <div class="flex justify-between border-b border-gray-100 dark:border-gray-700 pb-2">
            <p>Discount</p>
            <p>00</p>
          </div>
          <div class="flex justify-between border-b border-gray-100 dark:border-gray-700 pb-2">
            <p>Shipping</p>
            <p>00</p>
          </div>
          <div class="flex justify-between text-lg font-semibold pt-3">
            <p>Total</p>
            <p class="text-blue-600">₹157,495.00</p>
          </div>
        </div>
      </div>

      <!-- Shipping Info -->
      <div>
        <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-4">Shipping</h2>
        <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
          <div class="flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-600 dark:text-blue-400" viewBox="0 0 16 16" fill="currentColor">
              <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
            </svg>
            <div>
              <p class="text-lg font-semibold text-gray-800 dark:text-gray-300">Delivery</p>
              <p class="text-sm text-gray-500 dark:text-gray-400">Delivery within 24 hours</p>
            </div>
          </div>
          <p class="text-lg font-semibold text-gray-800 dark:text-gray-300">00</p>
        </div>
      </div>
    </div>

    <!-- Footer Buttons -->
    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mt-8">
      <a href="/products"
         class="w-full sm:w-auto text-center px-6 py-3 text-blue-600 border border-blue-600 rounded-md font-medium hover:bg-blue-600 hover:text-white transition-colors dark:border-gray-600 dark:hover:bg-gray-700 dark:text-gray-200">
        ← Go Back Shopping
      </a>
      <a href="/orders"
         class="w-full sm:w-auto text-center px-6 py-3 bg-blue-600 text-white rounded-md font-medium hover:bg-blue-700 transition-colors dark:bg-gray-700 dark:hover:bg-gray-600">
        View My Orders →
      </a>
    </div>

  </div>
</section>
@endsection

