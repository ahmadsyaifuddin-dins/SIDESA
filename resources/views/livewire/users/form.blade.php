<div>
    <div class="bg-surface rounded-lg shadow-lg">
        <!-- Card Header -->
        <div class="px-6 py-4 border-b border-slate-200">
            <h2 class="text-xl font-bold text-main">{{ $isEditMode ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}</h2>
        </div>

        <!-- Card Body -->
        <form wire:submit="save">
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                
                <!-- Kolom Kiri -->
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-main">Nama Lengkap</label>
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>
                            </div>
                            <input type="text" wire:model="name" id="name" class="block w-full ps-10 p-2.5 border-slate-300 rounded-md shadow-sm">
                        </div>
                        @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-main">Email</label>
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Zm0 0c0 1.657 1.007 3 2.25 3S21 13.657 21 12a9 9 0 1 0-2.636 6.364M16.5 12V8.25" /></svg>
                            </div>
                            <input type="email" wire:model="email" id="email" class="block w-full ps-10 p-2.5 border-slate-300 rounded-md shadow-sm">
                        </div>
                        @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="jabatan" class="block text-sm font-medium text-main">Jabatan</label>
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.05a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25v-15a2.25 2.25 0 0 1 2.25-2.25h4.05m0 0a2.25 2.25 0 0 1 2.25 2.25v1.5a2.25 2.25 0 0 1-2.25 2.25H6.75m0 0-3 3m0 0h3.75m-3.75 0V15m6.15-6.15a2.25 2.25 0 0 1 2.25 2.25v1.5a2.25 2.25 0 0 1-2.25 2.25H12.75m0 0-3 3m0 0h3.75m-3.75 0V15" /></svg>
                            </div>
                            <input type="text" wire:model="jabatan" id="jabatan" class="block w-full ps-10 p-2.5 border-slate-300 rounded-md shadow-sm">
                        </div>
                        <p class="mt-2 text-xs text-light">Jabatan resmi pengguna di kantor desa, misal: "Sekretaris Desa".</p>
                        @error('jabatan') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="space-y-6">
                    <div>
                        <label for="role" class="block text-sm font-medium text-main">Role</label>
                        <x-forms.select wire:model="role" id="role" class="mt-1 block w-full border-slate-300 rounded-md shadow-sm">
                            <option value="admin">Admin</option>
                            <option value="superadmin">Superadmin</option>
                            <option value="pimpinan">Pimpinan</option>
                        </x-forms.select>
                        <p class="mt-2 text-xs text-light">Role menentukan hak akses pengguna di dalam sistem.</p>
                        @error('role') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-main">Status</label>
                        <x-forms.select wire:model="status" id="status" class="mt-1 block w-full border-slate-300 rounded-md shadow-sm">
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </x-forms.select>
                        <p class="mt-2 text-xs text-light">Pengguna dengan status "Tidak Aktif" tidak akan bisa login.</p>
                        @error('status') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-main">Password</label>
                        <input type="password" wire:model="password" id="password" class="block w-full p-2.5 border-slate-300 rounded-md shadow-sm">
                        <p class="mt-2 text-xs text-light">{{ $isEditMode ? 'Kosongkan jika tidak ingin mengubah password.' : 'Minimal 8 karakter.' }}</p>
                        @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-main">Konfirmasi Password</label>
                        <input type="password" wire:model="password_confirmation" id="password_confirmation" class="block w-full p-2.5 border-slate-300 rounded-md shadow-sm">
                    </div>
                </div>
            </div>

            <!-- Card Footer -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-end gap-3 rounded-b-lg">
                <a href="{{ route('users.index') }}" wire:navigate class="bg-slate-200 hover:bg-slate-300 text-main font-semibold py-2 px-4 rounded-md transition-colors">
                    Batal
                </a>
                <button type="submit" wire:loading.attr="disabled" class="bg-primary hover:bg-primary-dark text-white font-semibold py-2 px-4 rounded-md transition-colors disabled:opacity-50">
                    <span wire:loading.remove>Simpan</span>
                    <span wire:loading>Menyimpan...</span>
                </button>
            </div>
        </form>
    </div>
</div>

