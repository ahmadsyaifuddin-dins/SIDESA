{{-- Modal Konfirmasi Hapus --}}
<div x-show="showDeleteModal" x-transition.opacity x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div @click.outside="showDeleteModal = false" class="w-full max-w-md rounded-xl bg-white p-6 shadow-xl">
        <div class="flex items-start">
            <div class="flex-shrink-0 mr-4 flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-xl font-bold text-main">Hapus Data Warga</h3>
                <p class="mt-2 text-sm text-light">
                    Apakah Anda yakin ingin menghapus data warga: <br>
                    <strong class="font-semibold text-main">{{ $wargaToDelete->nama_lengkap ?? '' }}</strong>? <br>
                    Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
        </div>
        <div class="mt-6 flex justify-end gap-x-3">
            <button type="button" @click="showDeleteModal = false" class="rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-main transition hover:bg-slate-50">
                Batal
            </button>
            <button type="button" wire:click="deleteWarga" class="rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-red-700" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="deleteWarga">Ya, Hapus</span>
                <span wire:loading wire:target="deleteWarga">Menghapus...</span>
            </button>
        </div>
    </div>
</div>
