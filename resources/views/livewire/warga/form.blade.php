<div x-data="{ title: '{{ $warga->exists ? 'Edit' : 'Tambah' }} Data Warga' }">
    <x-slot:title>
        {{ $warga->exists ? 'Edit' : 'Tambah' }} Data Warga
    </x-slot:title>

    {{-- Header Halaman --}}
    <div class="mb-6">
        <a href="{{ $warga->exists ? route('warga.show', $warga) : route('warga.index') }}" wire:navigate
            class="mb-3 flex items-center gap-x-2 text-sm text-light transition hover:text-main">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                <path fill-rule="evenodd"
                    d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z"
                    clip-rule="evenodd" />
            </svg>
            Kembali
        </a>
        <h1 class="text-2xl font-bold text-main md:text-3xl">{{ $warga->exists ? 'Edit Data Warga' : 'Tambah Warga Baru'
            }}</h1>
        <p class="text-light">Lengkapi semua informasi yang diperlukan pada form di bawah ini.</p>
    </div>

    {{-- Form Utama dengan struktur kartu --}}
    <form wire:submit.prevent="save" class="space-y-6">

        {{-- Bagian 1: Informasi Domisili & Keluarga --}}
        <div class="rounded-lg border border-slate-200 bg-white">
            <div class="border-b border-slate-200 p-5">
                <h3 class="text-lg font-semibold text-main">Informasi Domisili & Keluarga</h3>
                <p class="mt-1 text-sm text-light">Pilih Kartu Keluarga dan tentukan status hubungan dalam keluarga.</p>
            </div>
            <div class="grid grid-cols-1 gap-6 p-5 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label for="kartu_keluarga_id" class="block text-sm font-medium text-main">Nomor Kartu
                        Keluarga</label>
                    <x-forms.select id="kartu_keluarga_id" wire:model="kartu_keluarga_id" class="mt-1" required>
                        <option value="">Pilih Nomor KK</option>
                        @foreach($kartuKeluarga as $id => $nomor_kk)
                        <option value="{{ $id }}">{{ $nomor_kk }}</option>
                        @endforeach
                    </x-forms.select>
                </div>
                <div>
                    <label for="status_hubungan_keluarga" class="block text-sm font-medium text-main">Status Hubungan Keluarga</label>
                    <x-forms.select id="status_hubungan_keluarga" wire:model="status_hubungan_keluarga" class="mt-1"
                        required>
                        @foreach($opsiHubunganKeluarga as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </x-forms.select>
                </div>
                <div>
                    <label for="status_perkawinan" class="block text-sm font-medium text-main">Status Perkawinan</label>
                    <x-forms.select id="status_perkawinan" wire:model="status_perkawinan" class="mt-1" required>
                        <option value="">Pilih Status Perkawinan</option>
                        <option value="BELUM KAWIN">BELUM KAWIN</option>
                        <option value="KAWIN">KAWIN</option>
                        <option value="CERAI HIDUP">CERAI HIDUP</option>
                        <option value="CERAI MATI">CERAI MATI</option>
                    </x-forms.select>
                </div>
                <div>
                    <label for="nama_ayah" class="block text-sm font-medium text-main">Nama Lengkap Ayah</label>
                    <x-forms.input id="nama_ayah" wire:model="nama_ayah" class="mt-1"
                        placeholder="Contoh: Muhammad Abdullah" />
                </div>
                <div>
                    <label for="nama_ibu" class="block text-sm font-medium text-main">Nama Lengkap Ibu</label>
                    <x-forms.input id="nama_ibu" wire:model="nama_ibu" class="mt-1" placeholder="Contoh: Siti Aisyah" />
                </div>
            </div>
        </div>

        {{-- Bagian 2: Data Diri Pribadi --}}
        <div class="rounded-lg border border-slate-200 bg-white">
            <div class="border-b border-slate-200 p-5">
                <h3 class="text-lg font-semibold text-main">Data Diri Pribadi</h3>
                <p class="mt-1 text-sm text-light">Isikan detail informasi pribadi warga yang bersangkutan.</p>
            </div>
            <div class="grid grid-cols-1 gap-6 p-5 md:grid-cols-2">
                <div>
                    <label for="nik" class="block text-sm font-medium text-main">NIK (Nomor Induk Kependudukan)</label>
                    <x-forms.input id="nik" wire:model="nik" class="mt-1" placeholder="Masukkan 16 digit NIK"
                        required />
                </div>
                <div>
                    <label for="nama_lengkap" class="block text-sm font-medium text-main">Nama Lengkap</label>
                    <x-forms.input id="nama_lengkap" wire:model="nama_lengkap" class="mt-1"
                        placeholder="Sesuai dengan KTP" required />
                </div>
                <div>
                    <label for="jenis_kelamin" class="block text-sm font-medium text-main">Jenis Kelamin</label>
                    <x-forms.select id="jenis_kelamin" wire:model="jenis_kelamin" class="mt-1" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="LAKI-LAKI">LAKI-LAKI</option>
                        <option value="PEREMPUAN">PEREMPUAN</option>
                    </x-forms.select>
                </div>
                <div>
                    <label for="agama" class="block text-sm font-medium text-main">Agama</label>
                    <x-forms.select id="agama" wire:model="agama" class="mt-1" required>
                        @foreach($opsiAgama as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </x-forms.select>
                </div>
                <div>
                    <label for="tempat_lahir" class="block text-sm font-medium text-main">Tempat Lahir</label>
                    <x-forms.input id="tempat_lahir" wire:model="tempat_lahir" class="mt-1"
                        placeholder="Contoh: Banjarmasin" required />
                </div>
                <div>
                    <label for="tanggal_lahir" class="block text-sm font-medium text-main">Tanggal Lahir</label>
                    <x-forms.input id="tanggal_lahir" type="date" wire:model="tanggal_lahir" class="mt-1" required />
                </div>
                <div class="md:col-span-2">
                    <label for="golongan_darah" class="block text-sm font-medium text-main">Golongan Darah
                        (Opsional)</label>
                    <x-forms.select id="golongan_darah" wire:model="golongan_darah" class="mt-1">
                        @foreach($opsiGolonganDarah as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </x-forms.select>
                </div>
            </div>
        </div>

        {{-- Bagian 3: Pendidikan & Pekerjaan --}}
        <div class="rounded-lg border border-slate-200 bg-white">
            <div class="border-b border-slate-200 p-5">
                <h3 class="text-lg font-semibold text-main">Pendidikan & Pekerjaan</h3>
                <p class="mt-1 text-sm text-light">Informasi mengenai jenjang pendidikan dan status pekerjaan saat ini.
                </p>
            </div>
            <div class="grid grid-cols-1 gap-6 p-5 md:grid-cols-2">
                <div>
                    <label for="pendidikan_terakhir" class="block text-sm font-medium text-main">Pendidikan
                        Terakhir</label>
                    <x-forms.select id="pendidikan_terakhir" wire:model="pendidikan_terakhir" class="mt-1">
                        @foreach($opsiPendidikan as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </x-forms.select>
                </div>
                <div>
                    <label for="pekerjaan" class="block text-sm font-medium text-main">Pekerjaan</label>
                    <x-forms.input id="pekerjaan" wire:model="pekerjaan" class="mt-1"
                        placeholder="Contoh: Karyawan Swasta" />
                </div>
            </div>
        </div>

        {{-- Tombol Aksi dengan Indikator Loading --}}
        <div class="flex justify-end">
            <button type="submit"
                class="bg-primary-gradient hover:bg-primary-gradient-dark flex items-center gap-x-2 rounded-md px-6 py-2.5 text-sm font-medium text-white transition">
                <svg wire:loading wire:target="save" class="h-5 w-5 animate-spin" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span>Simpan Perubahan</span>
            </button>
        </div>
    </form>
</div>