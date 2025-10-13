<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Kelompok 5' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
  </head>

  <body class="bg-slate-200 dark:bg-slate-700">
    @livewire('partials.navbar')

    <main>
      {{ $slot }}
    </main>

    @livewire('partials.footer')
    @livewireScripts

    <script>
      document.addEventListener("livewire:navigated", () => {
        window.HSStaticMethods?.autoInit();
      });
      document.addEventListener("DOMContentLoaded", () => {
        window.HSStaticMethods?.autoInit();
      });
    </script>
  </body>
</html>
