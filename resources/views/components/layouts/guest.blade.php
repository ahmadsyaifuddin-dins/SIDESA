<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SIDESA' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-main antialiased">
    
    {{-- Container utama yang menengahkan card login --}}
    <div class="min-h-screen flex items-center justify-center px-4">
        
        {{-- Card utama yang akan berisi 2 kolom --}}
        <div class="w-full max-w-4xl bg-surface rounded-lg shadow-lg flex">
            
            <div class="hidden md:block md:w-1/2">
                {{-- Helper 'asset()' akan otomatis mengarah ke folder 'public' --}}
                <img src="{{ asset('Login-Image.png') }}" alt="Login Image" class="w-full h-full object-cover rounded-l-lg">
            </div>

            <div class="w-full md:w-1/2 p-8">
                {{-- Logo --}}
                <div>
                    <a href="/" class="text-3xl font-bold text-primary">
                        SIDESA
                    </a>
                    <p class="text-sm text-light mt-2">
                        Desa Anjir Muara Kota Tengah
                    </p>
                </div>

                {{-- Slot ini akan diisi oleh konten dari login.blade.php --}}
                <div class="mt-6">
                    {{ $slot }}
                </div>
            </div>

        </div>

    </div>
</body>
</html>