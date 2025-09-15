<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SIDESA Anjir Muara' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[var(--color-surface)] text-[var(--color-text-main)] antialiased">

    {{-- Di sini kita bisa letakkan navbar publik jika perlu --}}

    <main>
        {{ $slot }}
    </main>

    {{-- Di sini kita bisa letakkan footer publik --}}
    <footer class="bg-slate-800 text-white py-4">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm">
            &copy; {{ date('Y') }} SIDESA Anjir Muara Kota Tengah. All Rights Reserved.
        </div>
    </footer>

</body>
</html>