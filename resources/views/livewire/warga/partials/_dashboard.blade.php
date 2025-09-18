{{-- 
    Ini adalah "Zona Aman". `wire:ignore` memerintahkan Livewire untuk tidak
    menyentuh area ini setelah dimuat. Pembaruan akan ditangani oleh
    JavaScript murni yang kita tulis di file index.blade.php.
--}}
<div wire:ignore>
    {{-- Kartu Statistik --}}
    <div class="mb-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow">
            <p class="text-sm font-medium text-light">Total Warga</p>
            <p id="stat-total" class="mt-1 text-3xl font-bold text-main">{{ $stats['total'] ?? 0 }}</p>
        </div>
        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow">
            <p class="text-sm font-medium text-light">Laki-laki</p>
            <p id="stat-laki-laki" class="mt-1 text-3xl font-bold text-main">{{ $stats['laki_laki'] ?? 0 }}</p>
        </div>
        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow">
            <p class="text-sm font-medium text-light">Perempuan</p>
            <p id="stat-perempuan" class="mt-1 text-3xl font-bold text-main">{{ $stats['perempuan'] ?? 0 }}</p>
        </div>
        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow">
            <p class="text-sm font-medium text-light">Total Kartu Keluarga</p>
            <p id="stat-total-kk" class="mt-1 text-3xl font-bold text-main">{{ $stats['total_kk'] ?? 0 }}</p>
        </div>
    </div>

    {{-- PERBAIKAN: Layout Grafik dan Filter dibuat vertikal --}}
    <div class="flex flex-col gap-6">
        {{-- Grafik Komposisi Penduduk --}}
        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow">
            <h3 class="text-lg font-semibold text-main">Grafik Komposisi Penduduk</h3>
            <p class="mt-1 text-sm text-light">Berdasarkan Jenis Kelamin</p>
            <div class="mt-4 h-72">
                <canvas id="wargaChart"></canvas>
            </div>
        </div>
        
        {{-- Filter Data --}}
        @include('livewire.warga.partials._filters')
    </div>
</div>