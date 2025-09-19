<div x-show="showFilters" x-transition x-cloak class="rounded-lg border border-slate-200 bg-white p-5">
    <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
        {{-- Filter Peristiwa --}}
        <div>
            <label for="filterPeristiwa" class="block text-sm font-medium text-main">Jenis Peristiwa</label>
            <x-forms.select id="filterPeristiwa" wire:model.live="filterPeristiwa" class="mt-1">
                <option value="">Semua Peristiwa</option>
                @foreach($opsiPeristiwa as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </x-forms.select>
        </div>

        {{-- Filter User Pencatat --}}
        <div>
            <label for="filterUser" class="block text-sm font-medium text-main">Dicatat Oleh</label>
            <x-forms.select id="filterUser" wire:model.live="filterUser" class="mt-1">
                <option value="">Semua Admin</option>
                @foreach($opsiUser as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </x-forms.select>
        </div>

        {{-- Filter Rentang Tanggal --}}
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-main">Rentang Tanggal Peristiwa</label>
            <div class="mt-1 flex items-center gap-x-2">
                <x-forms.input type="date" wire:model.live="filterTanggalMulai" />
                <span class="text-light">-</span>
                <x-forms.input type="date" wire:model.live="filterTanggalSelesai" />
            </div>
        </div>
    </div>
    <div class="mt-4 border-t border-slate-200 pt-4">
        <button wire:click="resetFilters" class="text-sm text-blue-600 hover:text-blue-800">
            Reset Filter
        </button>
    </div>
</div>
