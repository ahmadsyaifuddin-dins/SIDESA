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
