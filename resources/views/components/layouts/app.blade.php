<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{ $title ?? 'SIDESA Anjir Muara' }}</title>

    @vite('resources/css/app.css')
    @livewireStyles
</head>

<body class="bg-background text-main antialiased">

    <div x-data class="flex h-screen">
        <x-sidebar />

        <div class="flex-1 flex flex-col overflow-hidden">
            
            <x-ui.alert />
            {{-- Emit browser event on initial load when session has flash (works with redirect/soft navigate) --}}
            @php
                $flashMessage = session('success') ?? session('error');
                $flashType = session()->has('success') ? 'success' : (session()->has('error') ? 'error' : null);
            @endphp
            @if($flashMessage && $flashType)
                <div x-data x-init="$dispatch('flash-message-display', [{ message: @js($flashMessage), type: @js($flashType) }])"></div>
            @endif

            <livewire:ui.navbar />

            <main class="flex-1 p-6 overflow-y-auto">
                {{ $slot }}
            </main>

            <x-footer />
        </div>

        <!-- PERBAIKAN PADA OVERLAY -->
        <div 
             x-data="{ isMobile: window.innerWidth < 768 }" x-cloak
             @resize.window="isMobile = window.innerWidth < 768"
             x-show="$store.sidebar.isOpen && isMobile" 
             @click="$store.sidebar.isOpen = false"
             class="fixed inset-0 bg-black/30 z-20">
        </div>
    </div>

    @vite('resources/js/app.js')

    @livewireScripts
</body>
</html>
