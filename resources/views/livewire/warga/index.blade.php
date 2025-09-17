<div x-data="{ title: 'Manajemen Data Warga' }">
    <x-slot:title>
        Manajemen Data Warga
    </x-slot:title>

    {{-- Header Halaman --}}
    <div class="mb-6 flex flex-col items-start justify-between gap-y-4 md:flex-row md:items-center">
        <div>
            <h1 class="text-2xl font-bold text-main md:text-3xl">Manajemen Data Warga</h1>
            <p class="text-light">Kelola semua data penduduk desa Anjir Muara Kota Tengah.</p>
        </div>

        <div class="flex items-center gap-x-2">
            <a href="{{ route('warga.create') }}" wire:navigate
                class="flex items-center gap-x-2 rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-main transition hover:bg-slate-50">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z"
                        clip-rule="evenodd" />
                </svg>
                Tambah Warga
            </a>
            <button @click="$wire.set('showImportModal', true)"
                class="bg-primary hover:bg-primary-dark flex items-center gap-x-2 rounded-md px-4 py-2 text-sm font-medium text-white transition">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                    <path
                        d="M9.25 13.25a.75.75 0 001.5 0V4.636l2.955 3.129a.75.75 0 001.09-1.03l-4.25-4.5a.75.75 0 00-1.09 0l-4.25 4.5a.75.75 0 101.09 1.03L9.25 4.636v8.614z" />
                    <path
                        d="M3.5 12.75a.75.75 0 00-1.5 0v2.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0018 15.25v-2.5a.75.75 0 00-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5z" />
                </svg>
                Import Data
            </button>
        </div>
    </div>

    {{-- Kontrol Tabel & Pencarian --}}
    <div class="mb-4 flex items-center justify-between">
        <div class="flex items-center gap-x-2">
            <x-forms.select wire:model.live="perPage"
                class="rounded-md border-slate-300 pr-1 text-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="15">15</option>
                <option value="30">30</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </x-forms.select>
            <p class="text-sm text-light">data per halaman</p>
        </div>
        <div class="relative w-full max-w-xs">
            <x-forms.input type="text" wire:model.live.debounce.300ms="search"
                class="w-full rounded-md border-slate-300 pl-9 text-sm focus:border-blue-500 focus:ring-blue-500"
                placeholder="Cari NIK, Nama, atau No. KK...">
                <x-slot:leadingIcon>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                        class="h-5 w-5 text-slate-400">
                        <path fill-rule="evenodd"
                            d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                            clip-rule="evenodd" />
                    </svg>
                </x-slot:leadingIcon>
            </x-forms.input>
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

    {{-- Tabel Data Warga --}}
    <div class="overflow-hidden rounded-lg border border-slate-200 bg-white">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">
                            NIK
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">
                            Nama Lengkap
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">
                            No. KK
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">
                            Hub. Keluarga
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">
                            Jenis Kelamin
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">
                            Usia
                        </th>
                        <th class="relative px-6 py-3">
                            <span class="sr-only">Aksi</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse ($warga as $item)
                    <tr class="hover:bg-slate-50" wire:key="{{ $item->id }}">
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-main">
                            {{ $item->nik }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-main">
                            {{ $item->nama_lengkap }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-light">
                            {{ $item->kartuKeluarga->nomor_kk ?? '-' }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-light">
                            {{ $item->status_hubungan_keluarga }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-light">
                            {{ $item->jenis_kelamin }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-light">
                            {{ \Carbon\Carbon::parse($item->tanggal_lahir)->age }} Thn
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                            <div class="flex items-center justify-end gap-x-2">
                                <a href="{{ route('warga.show', $item->id) }}" wire:navigate
                                    class="text-blue-600 hover:text-blue-900">Lihat</a>
                                <a href="{{ route('warga.edit', $item) }}" wire:navigate
                                    class="text-yellow-600 hover:text-yellow-900">Edit</a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-light">
                            <div class="flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="h-12 w-12 text-slate-300">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                                <p class="mt-3 text-base">Data warga tidak ditemukan.</p>
                                <p class="mt-1 text-sm">Coba ubah kata kunci pencarian Anda.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Paginasi --}}
    @if ($warga->hasPages())
    <div class="mt-6">
        {{ $warga->links('vendor.pagination.livewire-custom') }}
    </div>
    @endif

    {{-- Modal untuk Impor Data --}}
    <div x-show="$wire.showImportModal" x-transition.opacity x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div @click.outside="$wire.closeImportModal()" class="w-full max-w-lg rounded-xl bg-white p-6 shadow-xl">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-xl font-bold text-main">Import Data Warga</h3>
                    <p class="mt-1 text-sm text-light">Unggah file Excel untuk menambahkan data secara massal.</p>
                </div>
                <button @click="$wire.closeImportModal()" class="text-slate-400 hover:text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form wire:submit.prevent="import" class="mt-6">
                {{-- KOTAK INFORMASI BATASAN IMPOR --}}
                <div class="mb-4 rounded-md border border-yellow-300 bg-yellow-50 p-3">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Perhatian</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p>Untuk menjaga performa dan mencegah error, proses impor secara langsung dibatasi
                                    hingga <strong>~500 baris data per file</strong>. Jika data Anda lebih banyak, mohon
                                    unggah dalam beberapa file terpisah.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <label for="file-upload" class="block text-sm font-medium text-main">File Excel</label>
                    <div class="mt-2">
                        <input type="file" wire:model="file" id="file-upload" class="block w-full text-sm text-slate-500
                            file:mr-4 file:rounded-md file:border-0
                            file:bg-blue-50 file:px-4 file:py-2
                            file:text-sm file:font-semibold file:text-blue-700
                            hover:file:bg-blue-100">
                    </div>
                    @error('file') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
                    <p class="mt-2 text-xs text-light">Format yang didukung: .xlsx, .xls. Ukuran maksimal: 5MB.</p>
                </div>

                <div wire:loading wire:target="file" class="mt-4">
                    <p class="text-sm text-light">Mengunggah file...</p>
                </div>

                <div class="mt-6 flex justify-end gap-x-3">
                    <button type="button" @click="$wire.closeImportModal()"
                        class="rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-main transition hover:bg-slate-50">
                        Batal
                    </button>
                    <button type="submit"
                        class="bg-primary hover:bg-primary-dark rounded-md px-4 py-2 text-sm font-medium text-white transition"
                        wire:loading.attr="disabled" wire:target="import, file">
                        <span wire:loading.remove wire:target="import">Mulai Proses Impor</span>
                        <span wire:loading wire:target="import">Memproses data...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>