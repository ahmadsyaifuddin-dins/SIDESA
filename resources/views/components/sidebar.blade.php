<aside class="w-64 flex-shrink-0 bg-[var(--color-surface)] border-r border-slate-200 flex flex-col">
    
    {{-- Bagian Logo / Judul Aplikasi --}}
    <div class="h-16 flex items-center justify-center border-b border-slate-200">
        <a href="#" class="text-xl font-bold text-[var(--color-primary)]">
            SIDESA
        </a>
    </div>

    {{-- Daftar Menu Navigasi --}}
    <nav class="flex-1 px-4 py-4">
        <ul class="space-y-2">
            {{-- Item Menu Dashboard --}}
            <li>
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-2 rounded-md transition-colors
                          {{ request()->routeIs('dashboard') 
                             ? 'bg-[var(--color-primary)] text-white' 
                             : 'text-[var(--color-text-main)] hover:bg-slate-100' }}"
                >
                    {{-- Icon Dashboard (Heroicons) --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" /></svg>
                    <span>Dashboard</span>
                </a>
            </li>

            {{-- Item Menu Data Warga --}}
            <li>
                <a href="#" {{-- Ganti href nanti --}}
                   class="flex items-center gap-3 px-4 py-2 rounded-md transition-colors text-[var(--color-text-main)] hover:bg-slate-100"
                >
                    {{-- Icon Data Warga (Heroicons) --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" /></svg>
                    <span>Data Warga</span>
                </a>
            </li>

            {{-- Item Menu Surat Menyurat --}}
            <li>
                <a href="#" {{-- Ganti href nanti --}}
                   class="flex items-center gap-3 px-4 py-2 rounded-md transition-colors text-[var(--color-text-main)] hover:bg-slate-100"
                >
                    {{-- Icon Surat (Heroicons) --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" /></svg>
                    <span>Surat Menyurat</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>