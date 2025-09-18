{{-- Panel Filter Lanjutan (Collapsible) --}}
<div x-show="showFilters" x-transition x-cloak class="mb-6 rounded-lg border border-slate-200 bg-white p-5">
    <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
        {{-- Filter Pelaku (User) --}}
        <div>
            <label for="filterCauserId" class="block text-sm font-medium text-main">Pelaku</label>
            <x-forms.select id="filterCauserId" wire:model.live="filterCauserId" class="mt-1">
                <option value="">Semua Pengguna</option>
                @foreach($users as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </x-forms.select>
        </div>

        {{-- Filter Modul (Log Name) --}}
        <div>
            <label for="filterLogName" class="block text-sm font-medium text-main">Modul</label>
            <x-forms.select id="filterLogName" wire:model.live="filterLogName" class="mt-1">
                <option value="">Semua Modul</option>
                @foreach($logNames as $name)
                    <option value="{{ $name }}">{{ $name }}</option>
                @endforeach
            </x-forms.select>
        </div>

        {{-- Filter Rentang Tanggal --}}
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-main">Rentang Tanggal</label>
            <div class="mt-1 flex items-center gap-x-2">
                <x-forms.input type="date" wire:model.live="filterDateStart" />
                <span class="text-light">-</span>
                <x-forms.input type="date" wire:model.live="filterDateEnd" />
            </div>
        </div>
    </div>
    <div class="mt-4 border-t border-slate-200 pt-4">
        <button wire:click="resetFilters" class="text-sm text-blue-600 hover:text-blue-800">
            Reset Filter
        </button>
    </div>
</div>
