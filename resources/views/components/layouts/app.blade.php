<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Batik Mania' }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- 🔗 Vite untuk CSS & JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- 🧩 Livewire Styles --}}
    @livewireStyles
  </head>

  <body class="bg-slate-200 dark:bg-slate-700 font-poppins">

    {{-- 🔝 Navbar --}}
    @livewire('partials.navbar')

    {{-- 🧭 Main Content --}}
    <main class="min-h-screen">
      {{ $slot }}
    </main>

    {{-- ⚙️ Scripts Section --}}
    @livewireScripts

    {{-- 🚨 Livewire Alert Integration (WAJIB agar SweetAlert muncul) --}}
    <x-livewire-alert::scripts />

    {{-- 📦 Library JS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/preline@2.0.3/dist/preline.min.js" defer></script>

    {{-- 🔁 Reinit Preline setiap kali Livewire melakukan navigasi --}}
    <script>
      document.addEventListener("livewire:navigated", () => {
        window.HSStaticMethods?.autoInit();
      });
    </script>
  </body>
</html>



