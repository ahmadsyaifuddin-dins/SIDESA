<header class="h-16 bg-surface border-b border-slate-200 flex items-center justify-between px-6 flex-shrink-0">
    {{-- Sisi Kiri Navbar --}}
    <div class="flex items-center gap-4">
        <button @click="$store.sidebar.toggle()" class="md:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-main" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
        </button>

        {{-- BREADCRUMB DINAMIS --}}
        <nav class="hidden md:block" aria-label="Breadcrumb">
            <ol class="flex items-center gap-2 text-sm">
                @if (!empty($breadcrumbs))
                    <li>
                        <a href="{{ route('dashboard') }}" wire:navigate class="text-light hover:text-main">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h7.5" /></svg>
                        </a>
                    </li>
                    @foreach ($breadcrumbs as $breadcrumb)
                        <li>
                            <svg class="w-4 h-4 text-slate-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
                        </li>
                        <li>
                            @if (!$loop->last)
                                <a href="{{ $breadcrumb['url'] }}" wire:navigate class="font-medium text-light hover:text-main">
                                    {{ $breadcrumb['label'] }}
                                </a>
                            @else
                                <span class="font-semibold text-main">{{ $breadcrumb['label'] }}</span>
                            @endif
                        </li>
                    @endforeach
                @endif
            </ol>
        </nav>
    </div>

    {{-- Sisi Kanan Navbar --}}
    <div class="flex items-center gap-4">
        @auth
            {{-- IKON NOTIFIKASI BARU --}}
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="relative">
                    <svg class="w-6 h-6 text-main" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" /></svg>
                    <span class="absolute -top-1 -right-1 flex h-3 w-3">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-3 w-3 bg-danger"></span>
                    </span>
                </button>
                <div x-show="open" @click.outside="open = false" x-cloak x-transition class="absolute right-0 mt-2 w-80 bg-surface rounded-md shadow-lg border border-slate-200 z-10">
                    <div class="p-3 border-b border-slate-200">
                        <h4 class="font-semibold text-main">Notifikasi</h4>
                    </div>
                    <div class="p-3 text-center text-light text-sm">
                        Belum ada notifikasi baru.
                    </div>
                </div>
            </div>

            {{-- Dropdown Profil (tidak berubah) --}}
            <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                <button @click="open = !open" class="flex items-center gap-3">
                    <div class="text-right">
                        <div class="font-semibold text-sm text-main">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-light">{{ auth()->user()->role }}</div>
                    </div>
                    <div class="w-10 h-10 rounded-full">
                        @if (auth()->user()->profile_photo_path)
                            <img src="{{ asset(Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover rounded-full">
                        @else
                            <div class="w-full h-full rounded-full bg-primary text-white flex items-center justify-center font-bold">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                </button>
                <div x-show="open" x-transition x-cloak class="absolute right-0 mt-2 w-48 bg-surface rounded-md shadow-lg border border-slate-200 z-10">
                    <a href="{{ route('profile.edit') }}" wire:navigate class="block px-4 py-2 text-sm text-main hover:bg-slate-100">Profil Saya</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-danger hover:bg-slate-100">Logout</button>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</header>
