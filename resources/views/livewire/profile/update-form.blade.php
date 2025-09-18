<div class="space-y-6">
    {{-- Card 1: Informasi Profil --}}
    <div class="bg-surface rounded-lg shadow-lg">
        <div class="px-6 py-4 border-b border-slate-200">
            <h2 class="text-xl font-bold text-main">Informasi Profil</h2>
            <p class="text-sm text-light mt-1">Perbarui informasi profil dan alamat email akun Anda.</p>
        </div>
        <form wire:submit="updateProfile" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Kolom Foto Profil -->
                <div class="md:col-span-1" x-data="{ photoName: null, photoPreview: null }">
                    <label class="block text-sm font-medium text-main">Foto Profil</label>
                    <!-- Tampilan Preview Gambar -->
                    <div class="mt-2">
                        @if ($photo)
                            <img src="{{ $photo->temporaryUrl() }}" class="rounded-full w-32 h-32 object-cover">
                        @elseif (Auth::user()->profile_photo_path)
                            <img src="{{ asset(Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" class="rounded-full w-32 h-32 object-cover">
                        @else
                            <div class="w-32 h-32 rounded-full bg-slate-200 flex items-center justify-center">
                                <span class="text-3xl text-slate-500">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>
                    <!-- Tombol Upload -->
                    <div class="mt-4">
                        <input type="file" wire:model="photo" class="hidden" x-ref="photo">
                        <button type="button" @click="$refs.photo.click()" class="text-sm bg-primary-gradient hover:bg-primary-gradient-dark text-white font-semibold py-2 px-4 rounded-md transition-colors">
                            Unggah Foto
                        </button>
                    </div>
                    @error('photo') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Kolom Data Diri (Menggunakan Komponen Baru) -->
                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nik" class="block text-sm font-medium text-main">NIK</label>
                        <x-forms.input wire:model="nik" id="nik" type="text" class="mt-1" />
                        @error('nik') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="name" class="block text-sm font-medium text-main">Nama</label>
                        <x-forms.input wire:model="name" id="name" type="text" class="mt-1" />
                        @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-main">Email</label>
                        <x-forms.input wire:model="email" id="email" type="email" class="mt-1" />
                        @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="no_hp" class="block text-sm font-medium text-main">No HP</label>
                        <x-forms.input wire:model="no_hp" id="no_hp" type="text" class="mt-1" />
                        @error('no_hp') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-medium text-main">Jenis Kelamin</label>
                        <x-forms.select wire:model="jenis_kelamin" id="jenis_kelamin" class="mt-1">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </x-forms.select>
                        @error('jenis_kelamin') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-medium text-main">Tanggal Lahir</label>
                        <x-forms.date wire:model="tanggal_lahir" id="tanggal_lahir" class="mt-1" />
                        @error('tanggal_lahir') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="alamat" class="block text-sm font-medium text-main">Alamat</label>
                        <x-forms.textarea wire:model="alamat" id="alamat" class="mt-1" />
                        @error('alamat') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <button type="submit" wire:loading.attr="disabled" class="bg-primary-gradient hover:bg-primary-gradient-dark text-white font-semibold py-2 px-4 rounded-md transition-colors disabled:opacity-50">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    {{-- Card 2: Ubah Password (juga menggunakan komponen baru) --}}
    <div class="bg-surface rounded-lg shadow-lg">
        <div class="px-6 py-4 border-b border-slate-200">
            <h2 class="text-xl font-bold text-main">Ubah Password</h2>
            <p class="text-sm text-light mt-1">Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.</p>
        </div>
        <form wire:submit="updatePassword" class="p-6">
            <div class="space-y-4">
                <div>
                    <label for="current_password" class="block text-sm font-medium text-main">Password Saat Ini</label>
                    <x-forms.input type="password" wire:model="current_password" id="current_password" class="mt-1" />
                    @error('current_password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-main">Password Baru</label>
                    <x-forms.input type="password" wire:model="password" id="password" class="mt-1" />
                    @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-main">Konfirmasi Password Baru</label>
                    <x-forms.input type="password" wire:model="password_confirmation" id="password_confirmation" class="mt-1" />
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <button type="submit" wire:loading.attr="disabled" class="bg-primary-gradient hover:bg-primary-gradient-dark text-white font-semibold py-2 px-4 rounded-md transition-colors disabled:opacity-50">
                    Ubah Password
                </button>
            </div>
        </form>
    </div>
</div>