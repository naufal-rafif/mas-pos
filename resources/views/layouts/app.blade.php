<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Your App Name')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>
<body class="antialiased">
    <div class="">
        <livewire:components.navbar />

        <main class="flex flex-col min-h-[85vh] pt-[100px] max-w-7xl mx-auto px-8">
            {{ $slot }}
        </main>

        <livewire:components.footer />
    </div>

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/@hotwired/turbo@7.1.0/dist/turbo.es5-umd.js"></script>
</body>
</html>