<div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
    {{-- Kolom Kiri: Search Bar --}}
    <div class="w-full lg:w-2/5">
        <x-forms.input 
            type="text" 
            wire:model.live.debounce.300ms="search" 
            placeholder="Cari nama atau NIK warga..." 
            class="w-full"
        />
    </div>

    {{-- Kolom Kanan: Controls --}}
    <div class="flex w-full flex-wrap items-center justify-between gap-3 lg:w-3/5 lg:justify-end">
        
        {{-- Group kiri: Filter & Per Page --}}
        <div class="flex items-center gap-3">
            {{-- Tombol Filter --}}
            <button 
                @click="showFilters = !showFilters" 
                class="flex items-center gap-x-2 rounded-lg bg-primary-gradient px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-all duration-200 hover:bg-blue-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1"
            >
                <i class="fa-solid fa-filter text-xs"></i>
                <span>Filter</span>
            </button>

            {{-- Paginasi per Halaman --}}
            <div class="flex items-center gap-2">
                <span class="text-sm text-slate-600 hidden sm:inline">Per halaman:</span>
                <x-forms.select wire:model.live="perPage" class="bg-surface min-w-[80px]">
                    <option value="15">15</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="250">250</option>
                    <option value="500">500</option>
                </x-forms.select>
            </div>
        </div>

        {{-- Group kanan: Export Dropdown --}}
        <div x-data="{ open: false }" class="relative">
            <button 
                @click="open = !open" 
                @keydown.escape.window="open = false" 
                class="flex items-center gap-x-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition-all duration-200 hover:bg-slate-50 hover:border-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1"
            >
                <i class="fa-solid fa-download text-xs"></i>
                <span>Export</span>
                <i class="fa-solid fa-chevron-down text-xs text-slate-400 transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
            </button>

            <div 
                x-show="open" 
                @click.away="open = false" 
                x-transition:enter="transition ease-out duration-200" 
                x-transition:enter-start="transform opacity-0 scale-95 -translate-y-2" 
                x-transition:enter-end="transform opacity-100 scale-100 translate-y-0" 
                x-transition:leave="transition ease-in duration-150" 
                x-transition:leave-start="transform opacity-100 scale-100 translate-y-0" 
                x-transition:leave-end="transform opacity-0 scale-95 -translate-y-2" 
                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                style="display: none;"
            >
                <div class="py-2">
                    @php
                        $filters = array_filter([
                            'search' => $search, 
                            'filterPeristiwa' => $filterPeristiwa, 
                            'filterUser' => $filterUser,
                            'filterTanggalMulai' => $filterTanggalMulai, 
                            'filterTanggalSelesai' => $filterTanggalSelesai,
                        ]);
                    @endphp
                    
                    <a 
                        href="{{ route('history.export.pdf', $filters) }}" 
                        target="_blank" 
                        class="flex w-full items-center gap-x-3 px-4 py-3 text-sm text-slate-700 transition-colors hover:bg-slate-50"
                    >
                        <i class="fa-solid fa-file-pdf w-4 text-red-500"></i>
                        <span class="font-medium">Export PDF</span>
                    </a>
                    
                    <a 
                        href="{{ route('history.export.excel', $filters) }}" 
                        target="_blank" 
                        class="flex w-full items-center gap-x-3 px-4 py-3 text-sm text-slate-700 transition-colors hover:bg-slate-50"
                    >
                        <i class="fa-solid fa-file-excel w-4 text-green-500"></i>
                        <span class="font-medium">Export Excel</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>