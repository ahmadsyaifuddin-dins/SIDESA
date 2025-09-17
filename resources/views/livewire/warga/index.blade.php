<div x-data="{ title: 'Manajemen Data Warga' }">
    <x-slot:title>
        Manajemen Data Warga
    </x-slot:title>

    {{-- 1. Memanggil Header Halaman --}}
    @include('livewire.warga.partials._header')

    {{-- 2. Memanggil Kontrol Tabel (Pencarian & Paginasi) --}}
    @include('livewire.warga.partials._controls')

    {{-- 3. Memanggil Tabel Utama --}}
    @include('livewire.warga.partials._table')

    {{-- 4. Memanggil Paginasi --}}
    @include('livewire.warga.partials._pagination')

    {{-- 5. Memanggil Modal Impor (Tetap di sini agar bisa diakses) --}}
    @include('livewire.warga.partials._import-modal')
    
</div>

