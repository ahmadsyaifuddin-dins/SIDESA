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
<body class="bg-[var(--color-background)] text-[var(--color-text-main)] antialiased">
    
    <div class="flex h-screen">
        
        {{-- Komponen Sidebar (akan kita buat) --}}
        <x-sidebar />
        
        {{-- Area Konten Utama --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            
            {{-- Komponen Navbar (akan kita buat) --}}
            <x-navbar />
            
            {{-- Konten Halaman yang dinamis --}}
            <main class="flex-1 p-6 overflow-y-auto">
                {{ $slot }}
            </main>

            {{-- Komponen Footer (akan kita buat) --}}
            <x-footer />

        </div>

    </div>

    {{-- PENTING: Menambahkan script yang dibutuhkan oleh Livewire --}}
    @livewireScripts
    
    {{-- Memuat JS dari Vite --}}
    @vite('resources/js/app.js')
</body>
</html>