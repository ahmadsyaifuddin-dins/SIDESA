<header class="h-16 bg-[var(--color-surface)] border-b border-slate-200 flex items-center justify-between px-6 flex-shrink-0">
    
    {{-- Sisi Kiri Navbar --}}
    <div class="flex items-center gap-4">
        {{-- Tombol Hamburger untuk Mobile --}}
        <button class="md:hidden">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[var(--color-text-main)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
        </button>
    </div>

    {{-- Sisi Kanan Navbar --}}
    <div class="flex items-center">
        {{-- Cek apakah user sudah login --}}
        @auth
        <div class="relative">
            {{-- Tombol Dropdown --}}
            <button class="flex items-center gap-3">
                <div class="text-right">
                    <div class="font-semibold text-sm text-[var(--color-text-main)]">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-[var(--color-text-light)]">{{ auth()->user()->role }}</div>
                </div>
                {{-- Avatar Sederhana --}}
                <div class="w-10 h-10 rounded-full bg-[var(--color-primary)] text-white flex items-center justify-center font-bold">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            </button>
            
            {{-- Menu Dropdown (Awalnya disembunyikan, nanti diaktifkan dengan Alpine.js) --}}
            <div class="absolute right-0 mt-2 w-48 bg-[var(--color-surface)] rounded-md shadow-lg border border-slate-200 hidden">
                <a href="#" class="block px-4 py-2 text-sm text-[var(--color-text-main)] hover:bg-slate-100">Profil Saya</a>
                
                {{-- Tombol Logout --}}
                <form method="POST" action="#"> {{-- Ganti href ke route('logout') nanti --}}
                    @csrf
                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-[var(--color-danger)] hover:bg-slate-100">
                        Logout
                    </button>
                </form>
            </div>
        </div>
        @endauth
    </div>
</header>