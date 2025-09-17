<div x-data="{ title: 'Detail Data Warga' }">
    {{-- Menggunakan x-slot untuk judul halaman --}}
    <x-slot:title>
        Detail Data Warga
    </x-slot:title>

    {{-- Header Halaman --}}
    <div class="mb-6 flex flex-col items-start justify-between gap-y-4 md:flex-row md:items-center">
        <div>
            {{-- Tombol Kembali --}}
            <a href="{{ route('warga.index') }}" wire:navigate
                class="mb-3 flex items-center gap-x-2 text-sm text-light transition hover:text-main">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                    <path fill-rule="evenodd"
                        d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z"
                        clip-rule="evenodd" />
                </svg>
                Kembali ke Manajemen Warga
            </a>
            <h1 class="text-2xl font-bold text-main md:text-3xl">{{ $warga->nama_lengkap }}</h1>
            <p class="text-light">Detail lengkap data kependudukan.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        {{-- Kolom Kiri: Data Pribadi & Keluarga --}}
        <div class="space-y-6 lg:col-span-2">
            
            {{-- Kartu Data Pribadi --}}
            <div class="overflow-hidden rounded-lg border border-slate-200 bg-white">
                <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
                    <h3 class="text-base font-medium text-main">Data Pribadi</h3>
                </div>
                <div class="grid grid-cols-1 gap-y-4 p-6 sm:grid-cols-2">
                    <div>
                        <p class="text-sm text-light">NIK</p>
                        <p class="font-medium text-main">{{ $warga->nik }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-light">Tempat, Tanggal Lahir</p>
                        <p class="font-medium text-main">{{ $warga->tempat_lahir }}, {{ \Carbon\Carbon::parse($warga->tanggal_lahir)->translatedFormat('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-light">Jenis Kelamin</p>
                        <p class="font-medium text-main">{{ $warga->jenis_kelamin }}</p>
                    </div>
                     <div>
                        <p class="text-sm text-light">Usia</p>
                        <p class="font-medium text-main">{{ \Carbon\Carbon::parse($warga->tanggal_lahir)->age }} Tahun</p>
                    </div>
                    <div>
                        <p class="text-sm text-light">Agama</p>
                        <p class="font-medium text-main">{{ $warga->agama }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-light">Golongan Darah</p>
                        <p class="font-medium text-main">{{ $warga->golongan_darah ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-light">Pendidikan Terakhir</p>
                        <p class="font-medium text-main">{{ $warga->pendidikan_terakhir ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-light">Pekerjaan</p>
                        <p class="font-medium text-main">{{ $warga->pekerjaan ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Kartu Data Keluarga --}}
            <div class="overflow-hidden rounded-lg border border-slate-200 bg-white">
                <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
                    <h3 class="text-base font-medium text-main">Data Keluarga</h3>
                </div>
                <div class="grid grid-cols-1 gap-y-4 p-6 sm:grid-cols-2">
                    <div>
                        <p class="text-sm text-light">Status Perkawinan</p>
                        <p class="font-medium text-main">{{ $warga->status_perkawinan }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-light">Hubungan dalam Keluarga</p>
                        <p class="font-medium text-main">{{ $warga->status_hubungan_keluarga }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-light">Nama Ayah</p>
                        <p class="font-medium text-main">{{ $warga->nama_ayah ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-light">Nama Ibu</p>
                        <p class="font-medium text-main">{{ $warga->nama_ibu ?? '-' }}</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- Kolom Kanan: Data Alamat & Histori --}}
        <div class="space-y-6 lg:col-span-1">
            {{-- Kartu Data Alamat (dari KK) --}}
            <div class="overflow-hidden rounded-lg border border-slate-200 bg-white">
                <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
                    <h3 class="text-base font-medium text-main">Informasi Kartu Keluarga</h3>
                </div>
                <div class="space-y-4 p-6">
                    <div>
                        <p class="text-sm text-light">Nomor KK</p>
                        <p class="font-medium text-main">{{ $warga->kartuKeluarga->nomor_kk ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-light">Kepala Keluarga</p>
                        <p class="font-medium text-main">{{ $warga->kartuKeluarga->kepalaKeluarga->nama_lengkap ?? 'Belum Ditetapkan' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-light">Alamat</p>
                        <p class="font-medium text-main">
                            {{ $warga->kartuKeluarga->alamat ?? '' }}, 
                            RT {{ $warga->kartuKeluarga->rt ?? '' }} / RW {{ $warga->kartuKeluarga->rw ?? '' }}
                        </p>
                    </div>
                     <div>
                        <p class="text-sm text-light">Desa/Kelurahan</p>
                        <p class="font-medium text-main">{{ $warga->kartuKeluarga->desa_kelurahan ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-light">Kecamatan</p>
                        <p class="font-medium text-main">{{ $warga->kartuKeluarga->kecamatan ?? '-' }}</p>
                    </div>
                </div>
            </div>

             {{-- Kartu Histori Kependudukan --}}
            <div class="overflow-hidden rounded-lg border border-slate-200 bg-white">
                <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
                    <h3 class="text-base font-medium text-main">Histori Kependudukan</h3>
                </div>
                <div class="p-6">
                    <ul class="space-y-4">
                        @forelse($warga->histori->sortByDesc('tanggal_peristiwa') as $histori)
                            <li class="relative pl-8">
                                <div class="absolute left-0 top-1 h-3 w-3 rounded-full bg-blue-500"></div>
                                <p class="font-semibold text-main">{{ $histori->peristiwa }}</p>
                                <p class="text-sm text-light">{{ \Carbon\Carbon::parse($histori->tanggal_peristiwa)->translatedFormat('d M Y') }}</p>
                                <p class="mt-1 text-sm text-slate-600">{{ $histori->detail_peristiwa }}</p>
                            </li>
                        @empty
                            <p class="text-sm text-light">Belum ada histori kependudukan yang tercatat.</p>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
