@props([
    'rows' => 3
])

<textarea {{ $attributes->merge([
    'class' => 'block w-full border-slate-300 rounded-md shadow-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/50 ring-offset-0 transition-colors duration-150 ease-in-out',
    'rows' => $rows
]) }}></textarea>
