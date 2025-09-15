<div>
    {{-- Header Halaman --}}
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold">Daftar Pengguna</h2>
        @if(auth()->user()->role !== 'pimpinan')
        <a href="{{ route('users.create') }}" wire:navigate
            class="bg-primary hover:bg-primary-dark text-white font-semibold py-2 px-4 rounded-md transition-colors">
            Tambah Pengguna
        </a>
        @endif
    </div>

    {{-- Baris Pencarian dan Filter --}}
    <div class="mt-4 bg-surface p-4 rounded-lg shadow flex flex-col md:flex-row items-center gap-4">
        <div class="w-full md:w-1/2 lg:w-1/3">
            <x-forms.input wire:model.live.debounce.300ms="search" placeholder="Cari berdasarkan nama atau email...">
                <x-slot:leadingIcon>
                    <svg class="w-4 h-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </x-slot:leadingIcon>
            </x-forms.input>
        </div>
        <div class="w-full md:w-auto">
            <x-forms.select wire:model.live="filterRole">
                <option value="">Semua Role</option>
                <option value="superadmin">Superadmin</option>
                <option value="admin">Admin</option>
                <option value="pimpinan">Pimpinan</option>
            </x-forms.select>
        </div>
        <div class="w-full md:w-auto">
            <x-forms.select wire:model.live="filterStatus">
                <option value="">Semua Status</option>
                <option value="Aktif">Aktif</option>
                <option value="Tidak Aktif">Tidak Aktif</option>
            </x-forms.select>
        </div>
    </div>

    {{-- Konten Utama (Tabel) --}}
    <div class="mt-6 bg-surface p-6 rounded-lg shadow">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-light uppercase tracking-wider">Nama</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-light uppercase tracking-wider">Jabatan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-light uppercase tracking-wider">Role</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-light uppercase tracking-wider">Status</th>
                        @if(auth()->user()->role === 'superadmin')
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Aksi</span>
                        </th>
                        @endif
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse ($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-main">{{ $user->name }}</div>
                                    <div class="text-sm text-light">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-light">{{ $user->jabatan ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($user->role == 'superadmin')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Superadmin
                            </span>
                            @elseif ($user->role == 'pimpinan')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Pimpinan
                            </span>
                            @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                Admin
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($user->status == 'Aktif')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Aktif
                            </span>
                            @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-slate-100 text-slate-800">
                                Tidak Aktif
                            </span>
                            @endif
                        </td>
                        @if(auth()->user()->role === 'superadmin')
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('users.edit', $user) }}" wire:navigate class="text-primary hover:text-primary-dark">Edit</a>
                            
                            {{-- MODIFIKASI TOMBOL HAPUS --}}
                            <button 
                                wire:click="delete({{ $user->id }})" 
                                x-on:click="$dispatch('trigger-toast-check')"
                                wire:confirm="Apakah Anda yakin ingin menghapus pengguna ini? Tindakan ini tidak dapat dibatalkan."
                                class="ml-4 text-red-600 hover:text-red-800">
                                Hapus
                            </button>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-light">
                            Tidak ada data pengguna.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Link Paginasi --}}
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>

