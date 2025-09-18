{{-- Tabel Data --}}
<div class="overflow-hidden rounded-lg border border-slate-200">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left text-main">
            <thead class="text-xs uppercase bg-slate-200/60">
                <tr>
                    <th scope="col" class="px-6 py-3 font-semibold">Timestamp</th>
                    <th scope="col" class="px-6 py-3 font-semibold">Modul</th>
                    <th scope="col" class="px-6 py-3 font-semibold">Deskripsi</th>
                    <th scope="col" class="px-6 py-3 font-semibold">Subjek</th>
                    <th scope="col" class="px-6 py-3 font-semibold">Pelaku</th>
                    <th scope="col" class="px-6 py-3 font-semibold">Detail Perubahan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200/70">
                @forelse ($logs as $log)
                    <tr class="transition-colors duration-200 {{ $loop->iteration % 2 == 0 ? 'bg-slate-50' : 'bg-white' }} hover:bg-blue-50/50">
                        {{-- Timestamp (Format Baru) --}}
                        <td class="whitespace-nowrap px-6 py-4 text-slate-500">{{ $log->created_at->isoFormat('D MMM Y, HH:mm') }}</td>

                        {{-- Modul (Baru) --}}
                        <td class="whitespace-nowrap px-6 py-4">
                            <span class="inline-flex rounded-full bg-blue-100 px-2 text-xs font-semibold leading-5 text-blue-800 capitalize">
                                {{ $log->log_name }}
                            </span>
                        </td>
                        
                        {{-- Deskripsi dengan Ikon (Gaya Lama) --}}
                        <td class="px-6 py-4 font-medium">
                            <div class="flex items-center gap-3">
                                @if($log->event === 'created')
                                <i class="fa fa-plus-circle text-green-500"></i>
                                @elseif($log->event === 'updated')
                                <i class="fa fa-edit text-amber-500"></i>
                                @elseif($log->event === 'deleted')
                                <i class="fa fa-trash text-red-500"></i>
                                @endif
                                <span>{{ $log->description }}</span>
                            </div>
                        </td>

                        {{-- Subjek (Gaya Lama) --}}
                        <td class="px-6 py-4">
                            @if ($log->subject)
                                <span class="font-medium text-slate-800">{{ $log->subject->name ?? ($log->subject->nama_lengkap ?? 'N/A') }}</span>
                                <span class="block text-xs text-slate-500">ID: {{ $log->subject->id }}</span>
                            @else
                                -
                            @endif
                        </td>
                        
                        {{-- Pelaku/Penyebab (Gaya Lama) --}}
                        <td class="px-6 py-4 font-medium text-slate-800">{{ $log->causer->name ?? 'Sistem' }}</td>

                        {{-- Detail Perubahan (Gaya Lama) --}}
                        <td class="px-6 py-4">
                            @if ($log->event === 'updated' && $log->properties->has(['old', 'attributes']))
                                <div class="flex flex-col items-start gap-2">
                                    @foreach ($log->properties->get('attributes') as $field => $newValue)
                                        @php $oldValue = $log->properties->get('old')[$field] ?? null; @endphp
                                        <div>
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ ucwords(str_replace('_', ' ', $field)) }}
                                            </span>
                                            <div class="mt-1 text-xs">
                                                <span class="px-1 py-0.5 bg-red-100 text-red-700 rounded line-through">{{ $oldValue ?? 'kosong' }}</span>
                                                <span class="mx-1 font-sans text-slate-400">→</span>
                                                <span class="px-1 py-0.5 font-bold bg-green-100 text-green-700 rounded">{{ $newValue ?? 'kosong' }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <span class="flex items-center justify-center text-slate-400">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                            Tidak ada data log yang cocok dengan kriteria Anda.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

