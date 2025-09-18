@props([
    'leadingIcon' => false,
])

<div class="relative">
    {{-- Ikon di sebelah kiri (jika ada) --}}
    @if ($leadingIcon)
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            {{ $leadingIcon }}
        </div>
    @endif
    
    {{-- Input dengan class yang digabungkan --}}
    <input {{ $attributes->merge([
        'class' => 'block w-full border-slate-300 rounded-full shadow-sm focus:border-primary focus:ring-primary bg-surface' . ($leadingIcon ? ' ps-10 p-2.5' : ' p-2.5')
    ]) }}>
</div>

