@props([
    'leadingIcon' => false,
])

<div class="relative">
    {{-- Ikon di sebelah kiri input (jika ada) --}}
    @if ($leadingIcon)
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            {{ $leadingIcon }}
        </div>
    @endif
    
    {{--
        Kita gabungkan class default dengan class tambahan yang mungkin dikirim.
        Jika ada ikon, kita tambahkan padding kiri (ps-10).
    --}}
    <input {{ $attributes->merge(['class' => 'block w-full p-2 border-slate-300 rounded-md shadow-sm' . ($leadingIcon ? ' ps-10' : '')]) }}>
</div>
