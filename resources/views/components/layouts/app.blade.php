<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Batik Mania' }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
  </head>

  <body class="bg-slate-200 dark:bg-slate-700">

    {{-- Navbar --}}
    @livewire('partials.navbar')

    {{-- Main Content --}}
    <main>
      {{ $slot }}
    </main>

    {{-- Footer --}}
    @livewire('partials.footer')

    {{-- Scripts --}}
    @livewireScripts

    {{-- Load Alpine dulu, baru Preline --}}
    <script src="https://cdn.jsdelivr.net/npm/preline@2.0.3/dist/preline.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Inisialisasi ulang Preline saat Livewire re-render --}}
    <script>
      document.addEventListener("livewire:navigated", () => {
        window.HSStaticMethods?.autoInit();
      });
    </script>
  </body>
</html>


