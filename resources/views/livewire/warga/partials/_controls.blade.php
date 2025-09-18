{{-- Kontrol Tabel & Pencarian --}}
<div class="mb-4 flex items-center justify-between">
    <div class="flex items-center gap-x-2">
        <x-forms.select wire:model.live="perPage"
            class="rounded-md bg-surface border-slate-300 pr-1 text-sm focus:border-blue-500 focus:ring-blue-500">
            <option value="15">15</option>
            <option value="30">30</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </x-forms.select>
        <p class="text-sm text-light">data per halaman</p>
    </div>
    <div class="relative w-full max-w-xs bg-surface">
        <x-forms.input type="text" wire:model.live.debounce.300ms="search"
            class="w-full rounded-md border-slate-300 pl-9 text-sm focus:border-blue-500 focus:ring-blue-500"
            placeholder="Cari NIK, Nama, atau No. KK..." />
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                class="h-5 w-5 text-slate-400">
                <path fill-rule="evenodd"
                    d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                    clip-rule="evenodd" />
            </svg>
        </div>
    </div>
</div>
