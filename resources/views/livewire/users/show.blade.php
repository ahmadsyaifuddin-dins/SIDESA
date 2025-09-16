<div>
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold">Detail Pengguna</h2>
        <a href="{{ route('users.index') }}" wire:navigate class="bg-slate-200 hover:bg-slate-300 text-main font-semibold py-2 px-4 rounded-md transition-colors">
            Kembali ke Daftar
        </a>
    </div>

    <div class="mt-6 bg-surface rounded-lg shadow-lg">
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Kolom Foto Profil -->
            <div class="md:col-span-1 flex flex-col items-center text-center">
                @if ($user->profile_photo_path)
                    <img src="{{ asset($user->profile_photo_path) }}" alt="{{ $user->name }}" class="rounded-full w-40 h-40 object-cover">
                @else
                    <div class="w-40 h-40 rounded-full bg-slate-200 flex items-center justify-center">
                        <span class="text-5xl text-slate-500">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                @endif
                <h3 class="mt-4 text-xl font-bold text-main">{{ $user->name }}</h3>
                <p class="text-sm text-light">{{ $user->jabatan ?? '-' }}</p>
            </div>

            <!-- Kolom Detail Data -->
            <div class="md:col-span-2">
                <dl class="divide-y divide-slate-200">
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-light">Email</dt>
                        <dd class="mt-1 text-sm text-main sm:mt-0 sm:col-span-2">{{ $user->email }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-light">Role</dt>
                        <dd class="mt-1 text-sm text-main sm:mt-0 sm:col-span-2">
                            @if ($user->role == 'superadmin')<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Superadmin</span>@elseif ($user->role == 'pimpinan')<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pimpinan</span>@else<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Admin</span>@endif
                        </dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-light">Status</dt>
                        <dd class="mt-1 text-sm text-main sm:mt-0 sm:col-span-2">
                             @if ($user->status == 'Aktif')<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>@else<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-slate-100 text-slate-800">Tidak Aktif</span>@endif
                        </dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-light">Jenis Kelamin</dt>
                        <dd class="mt-1 text-sm text-main sm:mt-0 sm:col-span-2">{{ $user->jenis_kelamin ?? '-' }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-light">Tanggal Lahir</dt>
                        <dd class="mt-1 text-sm text-main sm:mt-0 sm:col-span-2">{{ $user->tanggal_lahir ? \Carbon\Carbon::parse($user->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-light">Alamat</dt>
                        <dd class="mt-1 text-sm text-main sm:mt-0 sm:col-span-2">{{ $user->alamat ?? '-' }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-light">Login Terakhir</dt>
                        <dd class="mt-1 text-sm text-main sm:mt-0 sm:col-span-2">{{ $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() : 'Belum pernah' }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
