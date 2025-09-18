{{-- Modal untuk Impor Data --}}
<div x-show="showImportModal" x-transition.opacity x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div @click.outside="showImportModal = false" class="w-full max-w-lg rounded-xl bg-white p-6 shadow-xl">
        <div class="flex items-start justify-between">
            <div>
                <h3 class="text-xl font-bold text-main">Import Data Warga</h3>
                <p class="mt-1 text-sm text-light">Unggah file Excel untuk menambahkan data secara massal.</p>
            </div>
            <button @click="showImportModal = false" class="text-slate-400 hover:text-slate-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form wire:submit.prevent="import" class="mt-6">
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
                <button type="button" @click="showImportModal = false"
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

