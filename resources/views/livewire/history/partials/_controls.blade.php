<div class="flex flex-col items-center justify-between gap-4 md:flex-row">
    {{-- Kolom Kiri: Search Bar --}}
    <div class="w-full md:w-1/3">
        <x-forms.input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama atau NIK warga..." />
    </div>

    {{-- Kolom Kanan: Tombol Aksi & Paginasi --}}
    <div class="flex w-full flex-wrap items-center justify-start gap-2 md:w-auto md:justify-end">
        
        @php
            $filters = array_filter([
                'search' => $search, 'filterPeristiwa' => $filterPeristiwa, 'filterUser' => $filterUser,
                'filterTanggalMulai' => $filterTanggalMulai, 'filterTanggalSelesai' => $filterTanggalSelesai,
            ]);
        @endphp
        <a href="{{ route('history.export.pdf', $filters) }}" target="_blank" class="flex items-center gap-x-2 rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-red-700">
             <i class="fa-solid fa-file-pdf"></i> Export PDF
        </a>
        <a href="{{ route('history.export.excel', $filters) }}" target="_blank" class="flex items-center gap-x-2 rounded-md bg-green-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-green-700">
             <i class="fa-solid fa-file-excel"></i> Export Excel
        </a>
        <x-forms.select wire:model.live="perPage" class="w-20 bg-surface">
            <option value="15">15</option>
            <option value="30">30</option>
            <option value="50">50</option>
            <option value="100">100</option>
            <option value="250">250</option>
            <option value="500">500</option>
        </x-forms.select>

        <button @click="showFilters = !showFilters" class="flex items-center gap-x-2 rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-main transition hover:bg-slate-50">
            <i class="fa-solid fa-filter"></i> <span>Filter</span>
        </button>
    </div>
</div>

