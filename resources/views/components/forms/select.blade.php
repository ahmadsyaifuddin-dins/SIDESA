@props([])

{{-- Komponen select sederhana yang siap menerima class tambahan --}}
<select {{ $attributes->merge(['class' => 'block w-full p-2 border-slate-300 rounded-md shadow-sm']) }}>
    {{-- Slot untuk menampung tag <option> --}}
    {{ $slot }}
</select>
