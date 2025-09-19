<aside class="w-64 flex-shrink-0 bg-surface border-r border-slate-200 flex flex-col fixed inset-y-0 left-0 z-30
           transform -translate-x-full md:relative md:translate-x-0 
           transition-transform duration-300 ease-in-out"
    :class="$store.sidebar.isOpen ? 'translate-x-0' : '-translate-x-full md:-translate-x-full'">

    {{-- Bagian Logo / Judul Aplikasi --}}
    <div class="h-16 flex items-center justify-center border-b border-slate-200">
        <a href="{{ route('dashboard') }}" class="text-xl font-bold text-primary">
            SIDESA
        </a>

        <button @click="$store.sidebar.toggle()"
            class="md:hidden absolute top-4 right-4 p-1 rounded-full hover:bg-slate-200">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-6 h-6 text-main">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    {{-- Daftar Menu Navigasi --}}
    <nav class="flex-1 px-4 py-4">
        <ul class="space-y-2">
            {{-- Item Menu Dashboard --}}
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2 rounded-md transition-colors
                          {{ request()->routeIs('dashboard') 
                             ? 'bg-primary-gradient text-white' 
                             : 'text-main hover:bg-slate-200' }}">
                    {{-- Icon Dashboard (Heroicons) --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path
                            d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                    </svg>
                    <span>Dashboard</span>
                </a>
            </li>

            @if (in_array(auth()->user()->role, ['superadmin', 'pimpinan']))
            <li>
                <a href="{{ route('users.index') }}" wire:navigate
                    class="flex items-center gap-3 px-4 py-2 rounded-md transition-colors
                  {{ request()->routeIs('users.index') ? 'bg-primary-gradient text-white' : 'text-main hover:bg-slate-200' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0012 11z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>Pengguna</span>
                </a>
            </li>
            @endif

            {{-- Item Menu Data Warga --}}
            <li>
                <a href="{{ route('warga.index') }}" wire:navigate
                    class="flex items-center gap-3 px-4 py-2 rounded-md transition-colors
                  {{ request()->routeIs('warga.index') ? 'bg-primary-gradient text-white' : 'text-main hover:bg-slate-200' }}">
                    {{-- Icon Data Warga (Heroicons) --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path
                            d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                    </svg>
                    <span>Data Warga</span>
                </a>
            </li>

            {{-- Item Menu Riwayat Kependudukan --}}
            <li>
                <a href="{{ route('history.index') }}" wire:navigate
                    class="flex items-center gap-3 px-4 py-2 rounded-md transition-colors
                  {{ request()->routeIs('history.index') ? 'bg-primary-gradient text-white' : 'text-main hover:bg-slate-200' }}">
                    <i class="fa-solid fa-clock-rotate-left w-5 h-5"></i>
                    <span>Riwayat Kependudukan</span>
                </a>
            </li>

            {{-- Item Menu Kartu Keluarga --}}
            <li>
                <a href="#" wire:navigate
                    class="flex items-center gap-3 px-4 py-2 rounded-md transition-colors text-gray-400 cursor-not-allowed
                  {{ request()->routeIs('kartu_keluarga.index') ? 'bg-primary-gradient text-white' : 'text-main hover:bg-slate-200' }}">
                    <i class="fas fa-id-card w-5 h-5"></i>
                    <span>Kartu Keluarga</span>
                </a>
            </li>

            {{-- Item Menu Peta Desa --}}
            <li>
                <a href="#" {{-- Ganti href nanti --}}
                    class="flex items-center gap-3 px-4 py-2 rounded-md transition-colors text-main hover:bg-slate-200 text-gray-400 cursor-not-allowed">
                    {{-- Icon Peta Desa (Heroicons) --}}
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z" />
                    </svg>
                    <span>Peta Desa</span>
                </a>
            </li>

            {{-- Item Menu Surat Menyurat --}}
            <li>
                <a href="#" {{-- Ganti href nanti --}}
                    class="flex items-center gap-3 px-4 py-2 rounded-md transition-colors text-main hover:bg-slate-200 text-gray-400 cursor-not-allowed">
                    {{-- Icon Surat (Heroicons) --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>Surat Menyurat</span>
                </a>
            </li>

            {{-- MENU BARU: Log Aktivitas (Hanya Superadmin) --}}
            @if (auth()->user()->role === 'superadmin')
            <li>
                <a href="{{ route('activity-log.index') }}" wire:navigate
                    class="flex items-center gap-3 px-4 py-2 rounded-md transition-colors
                  {{ request()->routeIs('activity-log.index') ? 'bg-primary-gradient text-white' : 'text-main hover:bg-slate-200' }}">
                    {{-- Icon Log (Heroicons: Document Report) --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm2 10a1 1 0 10-2 0v2a1 1 0 102 0v-2zm2-3a1 1 0 011 1v5a1 1 0 11-2 0v-5a1 1 0 011-1zm4-1a1 1 0 10-2 0v7a1 1 0 102 0V8z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>Log Aktivitas</span>
                </a>
            </li>
            @endif

        </ul>
    </nav>
</aside>