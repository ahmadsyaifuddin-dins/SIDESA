<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{ $title ?? 'SIDESA Anjir Muara' }}</title>

    {{-- Memuat CSS dari Vite --}}
    @vite('resources/css/app.css')

    {{-- PENTING: Menambahkan style yang dibutuhkan oleh Livewire --}}
    @livewireStyles
</head>

<body class="bg-background text-main antialiased">

    <div x-data class="flex h-screen">

        {{-- Komponen Sidebar (akan kita buat) --}}
        <x-sidebar />

        {{-- Area Konten Utama --}}
        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- Komponen Navbar (akan kita buat) --}}
            <x-navbar />

            {{-- Konten Halaman yang dinamis --}}
            <main class="flex-1 p-6 overflow-y-auto">

                @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                    class="bg-green-500 text-white text-sm font-bold text-center p-2 mb-3 rounded">
                    {{ session('success') }}
                </div>
                @endif
                
                {{ $slot }}
            </main>

            <x-footer />

        </div>

        {{-- Overlay untuk mobile --}}
        <div x-show="$store.sidebar.isOpen" @click="$store.sidebar.isOpen = false"
            class="fixed inset-0 bg-black/30 z-20 md:hidden">
        </div>

    </div>

    @vite('resources/js/app.js')
    @livewireScripts

</body>

</html>