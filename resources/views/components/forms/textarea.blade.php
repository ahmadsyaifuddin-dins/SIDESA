@props([
    'rows' => 3
])

{{-- 
    Komponen ini menggunakan tag <textarea> yang benar.
    Semua atribut lain seperti wire:model, id, dll. akan otomatis ditambahkan
    oleh Laravel melalui $attributes.
--}}
<textarea {{ $attributes->merge([
    'class' => 'block w-full border-slate-300 rounded-md shadow-sm focus:border-primary focus:ring-primary',
    'rows' => $rows
]) }}></textarea>

