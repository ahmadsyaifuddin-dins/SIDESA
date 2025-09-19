{{-- Modal Konfirmasi Hapus dengan Opsi Alasan --}}
<div x-show="showDeleteModal" x-transition.opacity x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-background">
    <div @click.outside="showDeleteModal = false" class="w-full max-w-md rounded-lg bg-white p-6 shadow-xl">

        <form wire:submit.prevent="deleteWarga">
            <h2 class="text-xl font-bold text-main">Nonaktifkan Data Warga</h2>
            <p class="mt-2 text-sm text-light">
                Anda akan menonaktifkan data warga: <span class="font-semibold">{{ $wargaToDelete?->nama_lengkap
                    }}</span>.
                Pilih alasan untuk mencatat peristiwa ini di Riwayat Kependudukan.
            </p>

            <div class="mt-4 space-y-3">
                <p class="text-sm font-medium text-main">Silakan pilih alasan:</p>
                <div class="space-y-2">
                    <label
                        class="flex items-center rounded-lg border p-4 transition-all duration-200 hover:bg-slate-50 hover:shadow-sm cursor-pointer group">
                        <input type="radio" wire:model.live="alasanHapus" value="MENINGGAL"
                        class="h-5 w-5 text-blue-600 focus:ring-blue-500 focus:ring-offset-0 mr-3">
                        <i
                            class="fa-solid fa-skull-crossbones text-red-500 text-lg mr-3 group-hover:scale-110 transition-transform"></i>
                        <span class="ml-3 text-sm font-medium text-main">Meninggal Dunia</span>
                    </label>

                    <label
                        class="flex items-center rounded-lg border p-4 transition-all duration-200 hover:bg-slate-50 hover:shadow-sm cursor-pointer group">
                        <input type="radio" wire:model.live="alasanHapus" value="PINDAH KELUAR"
                        class="h-5 w-5 text-blue-600 focus:ring-blue-500 focus:ring-offset-0 mr-3">
                        <i
                            class="fa-solid fa-person-hiking text-blue-500 text-lg mr-3 group-hover:scale-110 transition-transform"></i>
                        <span class="ml-3 text-sm font-medium text-main">Pindah Keluar Desa</span>
                    </label>

                    <label
                        class="flex items-center rounded-lg border p-4 transition-all duration-200 hover:bg-slate-50 hover:shadow-sm cursor-pointer group">
                        <input type="radio" wire:model.live="alasanHapus" value="TIDAK DIKETAHUI"
                            class="h-5 w-5 text-blue-600 focus:ring-blue-500 focus:ring-offset-0 mr-3">
                        <i
                            class="fa-solid fa-question text-gray-500 text-lg mr-3 group-hover:scale-110 transition-transform"></i>
                        <span class="ml-3 text-sm font-medium text-main">Tidak Diketahui / Lainnya</span>
                    </label>
                </div>
                @error('alasanHapus') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" @click="showDeleteModal = false"
                    class="rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-main transition hover:bg-slate-50">
                    Batal
                </button>
                <button type="submit"
                    class="flex items-center justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-red-700">
                    <svg wire:loading wire:target="deleteWarga" class="h-5 w-5 animate-spin"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span wire:loading.remove wire:target="deleteWarga">Konfirmasi & Nonaktifkan</span>
                    <span wire:loading wire:target="deleteWarga">Memproses...</span>
                </button>
            </div>
        </form>
    </div>
</div>