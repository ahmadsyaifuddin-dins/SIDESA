{{-- Tabel Data Warga --}}
<div class="overflow-hidden rounded-lg border border-slate-200 bg-white">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">
                        NIK
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">
                        Nama Lengkap
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">
                        No. KK
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">
                        Hub. Keluarga
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">
                        Jenis Kelamin
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">
                        Usia
                    </th>
                    <th class="relative px-6 py-3">
                        <span class="sr-only">Aksi</span>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 bg-white">
                @forelse ($warga as $item)
                <tr class="hover:bg-slate-50" wire:key="{{ $item->id }}">
                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-main">
                        {{ $item->nik }}
                    </td>
                    <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-main">
                        {{ $item->nama_lengkap }}
                    </td>
                    <td class="whitespace-nowrap px-6 py-4 text-sm text-light">
                        {{ $item->kartuKeluarga->nomor_kk ?? '-' }}
                    </td>
                    <td class="whitespace-nowrap px-6 py-4 text-sm text-light">
                        {{ $item->status_hubungan_keluarga }}
                    </td>
                    <td class="whitespace-nowrap px-6 py-4 text-sm text-light">
                        {{ $item->jenis_kelamin }}
                    </td>
                    <td class="whitespace-nowrap px-6 py-4 text-sm text-light">
                        {{ \Carbon\Carbon::parse($item->tanggal_lahir)->age }} Thn
                    </td>
                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                        <div class="flex items-center justify-end gap-x-2">
                            <a href="{{ route('warga.show', $item->id) }}" wire:navigate
                                class="text-blue-600 hover:text-blue-900">Lihat</a>
                            <a href="{{ route('warga.edit', $item) }}" wire:navigate
                                class="text-yellow-600 hover:text-yellow-900">Edit</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-8 text-center text-light">
                        <div class="flex flex-col items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="h-12 w-12 text-slate-300">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                            <p class="mt-3 text-base">Data warga tidak ditemukan.</p>
                            <p class="mt-1 text-sm">Coba ubah kata kunci pencarian Anda.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
