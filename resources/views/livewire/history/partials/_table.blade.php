<div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Warga</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Peristiwa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Tanggal Peristiwa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Dicatat Oleh</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Waktu Dicatat</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 bg-white">
                @forelse ($histories as $history)
                <tr class="hover:bg-slate-50" wire:key="{{ $history->id }}">
                    <td class="whitespace-nowrap px-6 py-4">
                        <div class="font-semibold text-main">{{ $history->warga->nama_lengkap ?? '[Data Warga Dihapus]' }}</div>
                        <div class="text-sm text-light">{{ $history->warga->nik ?? '-' }}</div>
                    </td>
                    <td class="whitespace-nowrap px-6 py-4">
                        <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5
                            @switch($history->peristiwa)
                                @case('LAHIR') bg-green-100 text-green-800 @break
                                @case('MENINGGAL') bg-red-100 text-red-800 @break
                                @case('PINDAH MASUK') bg-blue-100 text-blue-800 @break
                                @case('PINDAH KELUAR') bg-yellow-100 text-yellow-800 @break
                                @default bg-slate-100 text-slate-800
                            @endswitch
                        ">
                            {{ $history->peristiwa }}
                        </span>
                    </td>
                    <td class="whitespace-nowrap px-6 py-4 text-sm text-light">{{ \Carbon\Carbon::parse($history->tanggal_peristiwa)->translatedFormat('d F Y') }}</td>
                    <td class="whitespace-nowrap px-6 py-4 text-sm text-light">{{ $history->creator->name ?? 'Sistem' }}</td>
                    <td class="whitespace-nowrap px-6 py-4 text-sm text-light">{{ $history->created_at->diffForHumans() }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-8 text-center text-light">
                        Tidak ada data histori yang ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
