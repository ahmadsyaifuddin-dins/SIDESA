<!-- Komponen Notifikasi Modular yang Ditingkatkan -->
<div 
    x-data="{ show: false, message: '', type: '', timer: null }"
    x-on:flash-message-display.window="
        clearTimeout(timer); // Hapus timer lama jika ada notif baru masuk
        show = false; // Sembunyikan dulu untuk mereset animasi
        $nextTick(() => { // Tunggu DOM update sebelum menampilkan yang baru
            message = $event.detail[0].message; 
            type = $event.detail[0].type;
            show = true; // Tampilkan lagi untuk memicu animasi masuk
            timer = setTimeout(() => show = false, 4000); // Set timer baru (durasi 4 detik)
        })
    "
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-y-2"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform translate-y-2"
    :class="{ 'bg-green-500': type === 'success', 'bg-red-500': type === 'error' }"
    class="fixed top-4 right-4 w-auto max-w-sm p-4 rounded-md shadow-lg z-50 flex items-center space-x-3"
    style="display: none;"
    x-cloak
>
    <!-- Kolom Ikon Dinamis -->
    <div class="flex-shrink-0">
        <!-- Ikon Sukses (Heroicons) -->
        <div x-show="type === 'success'">
            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </div>
        <!-- Ikon Error (Heroicons) -->
        <div x-show="type === 'error'">
             <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
            </svg>
        </div>
    </div>

    <!-- Kolom Teks Pesan -->
    <div class="text-white text-sm font-semibold">
        <span x-text="message"></span>
    </div>
</div>

