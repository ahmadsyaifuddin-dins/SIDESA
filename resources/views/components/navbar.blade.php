<header
    class="h-16 bg-surface border-b border-slate-200 flex items-center justify-between px-6 flex-shrink-0">

    {{-- Sisi Kiri Navbar --}}
    <div class="flex items-center gap-4">
        {{-- Tombol Hamburger untuk Mobile --}}
        <button class="md:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[var(--color-text-main)]" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    {{-- Sisi Kanan Navbar --}}
    <div class="flex items-center">
        @auth
        {{-- 1. Inisialisasi state Alpine di div pembungkus utama --}}
        <div x-data="{ open: false }" @click.outside="open = false" class="relative">

            {{-- 2. Tambahkan @click untuk mengubah state 'open' --}}
            <button @click="open = !open" class="flex items-center gap-3">
                <div class="text-right">
                    <div class="font-semibold text-sm text-main">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-light">{{ auth()->user()->role }}</div>
                </div>
                <div
                    class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            </button>

            {{-- 3. Gunakan x-show untuk menampilkan/menyembunyikan menu dan tambahkan x-transition --}}
            <div x-show="open" x-transition
                class="absolute right-0 mt-2 w-48 bg-background rounded-md shadow-lg border border-slate-200 z-10">
                <a href="#" class="block px-4 py-2 text-sm text-black hover:bg-slate-200">Profil
                    Saya</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="cursor-pointer w-full text-left block px-4 py-2 text-sm text-red-400 hover:bg-slate-200">
                        Logout
                    </button>
                </form>
            </div>
        </div>
        @endauth
    </div>
</header>