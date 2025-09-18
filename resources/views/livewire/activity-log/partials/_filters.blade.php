{{-- Baris Kontrol: Pencarian dan Tombol Filter --}}
<div class="mb-4 flex flex-col items-center justify-between gap-4 md:flex-row">
    {{-- Input Pencarian --}}
    <div class="w-full md:w-1/3">
        <x-forms.input wire:model.live.debounce.300ms="search" placeholder="Cari deskripsi atau pelaku..." />
    </div>

    {{-- Tombol Filter Lanjutan --}}
    <div class="flex w-full items-center justify-end gap-x-2 md:w-auto">
        <button @click="showFilters = !showFilters" class="flex items-center gap-x-2 rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-main transition hover:bg-slate-50">
            <svg xmlns="http://www.w.org/2000/svg" class="h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.59L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z" clip-rule="evenodd" />
            </svg>
            <span>Filter Lanjutan</span>
            <svg xmlns="http://www.w.org/2000/svg" class="h-5 w-5 text-slate-400 transition-transform" :class="{ 'rotate-180': showFilters }" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>
</div>
