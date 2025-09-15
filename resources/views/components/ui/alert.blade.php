<!-- Komponen Notifikasi Modular -->
<div 
    x-data="{ show: false, message: '', type: '' }"
    x-on:flash-message-display.window="
        show = true; 
        message = $event.detail[0].message; 
        type = $event.detail[0].type;
        setTimeout(() => show = false, 3000)
    "
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform -translate-y-4"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform -translate-y-4"
    :class="{ 'bg-green-500': type === 'success', 'bg-red-500': type === 'error' }"
    class="absolute top-4 right-4 text-white text-sm font-bold p-4 rounded-md shadow-lg z-50"
    style="display: none;"
>
    <span x-text="message"></span>
</div>
