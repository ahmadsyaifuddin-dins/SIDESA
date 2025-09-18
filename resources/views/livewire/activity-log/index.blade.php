<div>
    {{-- Header Halaman --}}
    <header class="bg-surface shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 mx-auto">
            <h1 class="text-xl font-bold text-main">
                Log Aktivitas Pengguna
            </h1>
        </div>
    </header>

    {{-- Konten Utama --}}
    <main class="p-6">
        <div class="bg-surface rounded-lg shadow-md">
            {{-- Tabel Data --}}
            <div class="overflow-x-auto rounded-lg">
                <table class="min-w-full text-sm text-left text-main">
                    <thead class="text-xs uppercase bg-slate-200/60">
                        <tr>
                            <th scope="col" class="px-6 py-3 font-semibold">Deskripsi</th>
                            <th scope="col" class="px-6 py-3 font-semibold">Subjek</th>
                            <th scope="col" class="px-6 py-3 font-semibold">Penyebab</th>
                            <th scope="col" class="px-6 py-3 font-semibold">Detail Perubahan</th>
                            <th scope="col" class="px-6 py-3 font-semibold">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-slate-300">
                        @forelse ($logs as $log)
                        <tr
                            class="border-b transition-colors duration-200 {{ $loop->iteration % 2 == 0 ? 'bg-slate-50' : 'bg-white' }} hover:bg-blue-50">
                            {{-- Deskripsi dengan Ikon --}}
                            <td class="px-6 py-4 font-medium">
                                <div class="flex items-center gap-3">
                                    @if($log->event === 'created')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-500"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    @elseif($log->event === 'updated')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-amber-500"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                    @elseif($log->event === 'deleted')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    @endif
                                    <span>{{ $log->description }}</span>
                                </div>
                            </td>
                            {{-- Subjek --}}
                            <td class="px-6 py-4">
                                @if ($log->subject)
                                <span class="font-medium text-slate-800">{{ $log->subject->name ?? 'N/A' }}</span>
                                <span class="text-slate-500">(ID: {{ $log->subject->id }})</span>
                                @else
                                -
                                @endif
                            </td>
                            {{-- Penyebab --}}
                            <td class="px-6 py-4">
                                @if ($log->causer)
                                {{ $log->causer->name }}
                                @else
                                <span class="italic text-slate-500">Sistem</span>
                                @endif
                            </td>
                            {{-- Detail Perubahan yang Dipercantik --}}
                            <td class="px-6 py-4">
                                @if ($log->event === 'updated' && $log->properties->has(['old', 'attributes']))
                                <div class="flex flex-col items-start gap-2">
                                    @foreach ($log->properties->get('attributes') as $field => $newValue)
                                    @php
                                    $oldValue = $log->properties->get('old')[$field] ?? null;
                                    @endphp
                                    <div class="w-full">
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ ucwords(str_replace('_', ' ', $field)) }}
                                        </span>
                                        <div class="mt-1 text-xs">
                                            @if ($field === 'password')
                                            <span class="italic text-slate-500">[Nilai disembunyikan]</span>
                                            @else
                                            <span class="px-1 py-0.5 bg-red-100 text-red-700 rounded line-through">{{
                                                $oldValue ?? 'kosong' }}</span>
                                            <span class="mx-1 font-sans text-slate-400">→</span>
                                            <span class="px-1 py-0.5 font-bold bg-green-100 text-green-700 rounded">{{
                                                $newValue ?? 'kosong' }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <span class="flex items-center justify-center text-slate-400">-</span>
                                @endif
                            </td>
                            {{-- Waktu --}}
                            <td class="px-6 py-4 text-slate-500">{{ $log->created_at->diffForHumans() }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-slate-500">
                                Tidak ada aktivitas yang tercatat.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginasi --}}
            @if ($logs->hasPages())
            <div class="p-4 border-t">
                {{ $logs->links('vendor.pagination.livewire-custom') }}
            </div>
            @endif
        </div>
    </main>
</div>