<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{ $title ?? 'SIDESA Anjir Muara' }}</title>

    @vite('resources/css/app.css')

    <!-- CSS untuk menyembunyikan elemen x-cloak saat inisialisasi -->
    <style>
        [x-cloak] { display: none !important; }
    </style>

    @livewireStyles
</head>

<body class="bg-background text-main antialiased">

    <div x-data class="flex h-screen">
        <x-sidebar />

        <div class="flex-1 flex flex-col overflow-hidden">
            
            <x-ui.alert />

            <x-navbar />

            <main class="flex-1 p-6 overflow-y-auto">
                {{ $slot }}
            </main>

            <x-footer />
        </div>

        <!-- PERBAIKAN PADA OVERLAY -->
        <div 
             x-cloak
             x-data="{ isMobile: window.innerWidth < 768 }"
             @resize.window="isMobile = window.innerWidth < 768"
             x-show="$store.sidebar.isOpen && isMobile" 
             @click="$store.sidebar.isOpen = false"
             class="fixed inset-0 bg-black/30 z-20">
        </div>
    </div>

    @vite('resources/js/app.js')

    <!-- JEMBATAN ANTARA SESSION LARAVEL & EVENT ALPINE -->
    @if (session()->has('success') || session()->has('error'))
        <script>
            document.addEventListener('livewire:navigated', () => {
                const flashData = @json([
                    'message' => session('success') ?? session('error'),
                    'type' => session()->has('success') ? 'success' : 'error'
                ]);
                
                window.dispatchEvent(new CustomEvent('flash-message', {
                    detail: [flashData]
                }));
            });
        </script>
    @endif

    @livewireScripts
</body>
</html>

