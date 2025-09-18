{{--
Ini adalah "Zona Aman". `wire:ignore` memerintahkan Livewire untuk tidak
menyentuh area ini setelah dimuat. Pembaruan akan ditangani oleh
JavaScript murni yang kita tulis di file index.blade.php.
--}}
<div wire:ignore>
    {{-- Kartu Statistik --}}
    <div class="mb-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow">
            <p class="text-sm font-medium text-light"><i class="fa-solid fa-users-between-lines"></i> Total Warga</p>
            <p id="stat-total" class="mt-1 text-3xl font-bold text-main">{{ $stats['total'] ?? 0 }}</p>
        </div>
        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow">
            <p class="text-sm font-medium text-light"><i class="fa-solid fa-mars"></i> Laki-laki</p>
            <p id="stat-laki-laki" class="mt-1 text-3xl font-bold text-main">{{ $stats['laki_laki'] ?? 0 }}</p>
        </div>
        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow">
            <p class="text-sm font-medium text-light"><i class="fa-solid fa-venus"></i> Perempuan</p>
            <p id="stat-perempuan" class="mt-1 text-3xl font-bold text-main"> {{ $stats['perempuan'] ?? 0 }}</p>
        </div>
        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow">
            <p class="text-sm font-medium text-light"><i class="fa-solid fa-address-card"></i> Total Kartu Keluarga</p>
            <p id="stat-total-kk" class="mt-1 text-3xl font-bold text-main"> {{ $stats['total_kk'] ?? 0 }}</p>
        </div>
    </div>

    {{-- Layout Grafik dan Filter --}}
    <div class="flex flex-col gap-6">
        {{-- Grafik Komposisi Penduduk --}}
        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow">
            <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
                <div>
                    <h3 class="text-lg font-semibold text-main">Grafik Komposisi Penduduk</h3>
                    <p class="mt-1 text-sm text-light" id="chart-description">Berdasarkan Jenis Kelamin</p>
                </div>
                {{-- PENAMBAHAN: Dropdown untuk memilih mode grafik --}}
                <div class="flex items-center gap-x-2">
                    <label for="chartMode" class="text-sm font-medium text-main">Tampilkan berdasarkan:</label>
                    <x-forms.select wire:model.live="chartMode" id="chartMode"
                        class="rounded-md border-slate-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="jenis_kelamin">Jenis Kelamin</option>
                        <option value="usia">Kelompok Usia</option>
                        <option value="status_perkawinan">Status Perkawinan</option>
                        <option value="pendidikan">Pendidikan</option>
                        <option value="rt">Berdasarkan RT</option>
                    </x-forms.select>
                </div>
            </div>
            <div class="mt-4 h-96"> {{-- Tinggi ditambah agar label panjang tidak terpotong --}}
                <canvas id="wargaChart"></canvas>
            </div>
        </div>

        @include('livewire.warga.partials._filters')
    </div>
</div>