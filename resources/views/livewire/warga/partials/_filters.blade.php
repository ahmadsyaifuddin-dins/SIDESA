{{-- Panel Filter Lanjutan --}}
<div>
    {{-- PERBAIKAN: Menggunakan @click Alpine.js untuk toggle --}}
    <div class="mb-4 flex items-center justify-end">
        <button @click="showFilters = !showFilters" class="flex items-center gap-x-2 rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-main transition hover:bg-slate-50">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.59L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z" clip-rule="evenodd" />
            </svg>
            <span>Filter Lanjutan</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 transition-transform" :class="{ 'rotate-180': showFilters }" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>

    {{-- PERBAIKAN: Menggunakan x-show Alpine.js --}}
    <div x-show="showFilters" x-transition x-cloak class="mb-6 rounded-lg border border-slate-200 bg-white p-5">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
            {{-- Filter Jenis Kelamin --}}
            <div>
                <label for="filterJenisKelamin" class="block text-sm font-medium text-main">Jenis Kelamin</label>
                <x-forms.select id="filterJenisKelamin" wire:model.live="filterJenisKelamin" class="mt-1">
                    <option value="">Semua</option>
                    <option value="LAKI-LAKI">Laki-laki</option>
                    <option value="PEREMPUAN">Perempuan</option>
                </x-forms.select>
            </div>
            {{-- Filter Agama --}}
            <div>
                <label for="filterAgama" class="block text-sm font-medium text-main">Agama</label>
                <x-forms.select id="filterAgama" wire:model.live="filterAgama" class="mt-1">
                    <option value="">Semua</option>
                    @foreach($opsiAgama as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </x-forms.select>
            </div>
             {{-- Filter Usia --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-main">Rentang Usia</label>
                <div class="mt-1 flex items-center gap-x-2">
                    <x-forms.input type="number" wire:model.live.debounce.300ms="filterUsiaMin" placeholder="Min" />
                    <span class="text-light">-</span>
                    <x-forms.input type="number" wire:model.live.debounce.300ms="filterUsiaMax" placeholder="Max" />
                </div>
            </div>
        </div>
        <div class="mt-4 border-t border-slate-200 pt-4">
            <button wire:click="resetFilters" class="text-sm text-blue-600 hover:text-blue-800">
                Reset Filter
            </button>
        </div>
    </div>
</div>

