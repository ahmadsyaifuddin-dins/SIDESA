{{-- resources/views/livewire/history/partials/_dashboard.blade.php --}}
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
    <div class="p-6 lg:p-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Grafik Trend Kependudukan
                </h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Visualisasi data peristiwa kependudukan berdasarkan periode waktu
                </p>
            </div>

            <!-- Filter Periode -->
            <div class="flex items-center space-x-4">
                <x-forms.select wire:model.live="chartPeriod"
                    class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 text-sm">
                    <option value="all">Semua Waktu</option>
                    <option value="6months">6 Bulan Terakhir</option>
                    <option value="1year">1 Tahun Terakhir</option>
                    <option value="2years">2 Tahun Terakhir</option>
                </x-forms.select>

                <button wire:click="refreshChart"
                    class="inline-flex items-center px-3 py-2 border border-transparent text-xs font-medium rounded-md text-white bg-primary-gradient hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                    Refresh
                </button>
            </div>
        </div>

        <!-- Loading Indicator -->
        <div wire:loading.flex wire:target="chartPeriod,refreshChart" class="items-center justify-center py-12">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-500"></div>
            <span class="ml-2 text-gray-600 dark:text-gray-400">Memuat data grafik...</span>
        </div>

        <!-- Error Message -->
        @if (isset($chartData) && !$chartData['success'])
        <div class="bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-800 rounded-md p-4 mb-4">
            <div class="flex">
                <svg class="h-5 w-5 text-red-400 dark:text-red-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Error</h3>
                    <p class="text-sm text-red-700 dark:text-red-300 mt-1">
                        {{ $chartData['message'] ??
                        'Terjadi
                        kesalahan saat memuat data chart' }}
                    </p>
                </div>
            </div>
        </div>
        @endif

        <!-- Chart Container (wrapper untuk loading masih dikontrol Livewire) -->
        <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4" style="height: 400px;" wire:loading.class="opacity-50"
            wire:target="chartPeriod,refreshChart">
            {{-- NOTE: hanya container canvas yang di-wire:ignore agar Livewire tidak mengganti elemen canvas --}}
            <div wire:ignore class="h-full w-full">
                <canvas id="trendChart" class="w-full h-full"></canvas>
            </div>
        </div>
        <!-- Chart Legend/Stats -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-6" wire:loading.class="opacity-50"
            wire:target="chartPeriod,refreshChart">
            @if (isset($chartStats) && $chartStats['success'])
            @php
            $colors = [
            'LAHIR' => ['icon' => 'fa fa-baby', 'color' => 'rgb(34, 197, 94)'],
            'MENINGGAL' => ['icon' => 'fa fa-skull-crossbones', 'color' => 'rgb(239, 68, 68)'],
            'PINDAH MASUK' => ['icon' => 'fa fa-sign-in-alt', 'color' => 'rgb(59, 130, 246)'],
            'PINDAH KELUAR' => ['icon' => 'fa fa-person-hiking', 'color' => 'rgb(245, 158, 11)'],
            'TIDAK DIKETAHUI' => ['icon' => 'fa fa-question', 'color' => 'rgb(156, 163, 175)'],
            ];

            $labels = [
            'LAHIR' => 'Kelahiran',
            'MENINGGAL' => 'Kematian',
            'PINDAH MASUK' => 'Pindah Masuk',
            'PINDAH KELUAR' => 'Pindah Keluar',
            'TIDAK DIKETAHUI' => 'Tidak Diketahui',
            ];
            @endphp

            @foreach (['LAHIR', 'MENINGGAL', 'PINDAH MASUK', 'PINDAH KELUAR', 'TIDAK DIKETAHUI'] as $peristiwa)
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                            <i class="{{ $colors[$peristiwa]['icon'] }} mr-2"
                                style="color: {{ $colors[$peristiwa]['color'] }}"></i>{{ $labels[$peristiwa] }}
                        </p>
                        <p class="text-2xl font-bold" style="color: {{ $colors[$peristiwa]['color'] }}">
                            {{ $chartStats['stats'][$peristiwa] ?? 0 }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>

<script>
    window.HistoryChart = (function() {
        let chart = null;

        const COLORS = {
            'LAHIR': {
                background: 'rgba(34, 197, 94, 0.2)',
                border: 'rgb(34, 197, 94)'
            },
            'MENINGGAL': {
                background: 'rgba(239, 68, 68, 0.2)',
                border: 'rgb(239, 68, 68)'
            },
            'PINDAH MASUK': {
                background: 'rgba(59, 130, 246, 0.2)',
                border: 'rgb(59, 130, 246)'
            },
            'PINDAH KELUAR': {
                background: 'rgba(245, 158, 11, 0.2)',
                border: 'rgb(245, 158, 11)'
            },
            'TIDAK DIKETAHUI': {
                background: 'rgba(156, 163, 175, 0.2)',
                border: 'rgb(156, 163, 175)'
            }
        };

        const LABELS = {
            'LAHIR': 'Kelahiran',
            'MENINGGAL': 'Kematian',
            'PINDAH MASUK': 'Pindah Masuk',
            'PINDAH KELUAR': 'Pindah Keluar',
            'TIDAK DIKETAHUI': 'Tidak Diketahui'
        };

        function updateChart(data) {
            console.log('[chart] payload:', data);

            if (!data || !data.success) return;

            const canvas = document.getElementById('trendChart');
            if (!canvas) return;

            if (chart) {
                // Update existing chart
                chart.data.labels = data.labels;
                chart.data.datasets = data.datasets.map(dataset => ({
                    ...dataset,
                    backgroundColor: COLORS[dataset.label]?.background,
                    borderColor: COLORS[dataset.label]?.border,
                    borderWidth: 2,
                    pointRadius: 3,
                    label: LABELS[dataset.label] || dataset.label
                }));
                chart.update('none');
            } else {
                // Create new chart
                const ctx = canvas.getContext('2d');
                chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: data.datasets.map(dataset => ({
                            ...dataset,
                            backgroundColor: COLORS[dataset.label]?.background,
                            borderColor: COLORS[dataset.label]?.border,
                            borderWidth: 2,
                            pointRadius: 3,
                            label: LABELS[dataset.label] || dataset.label
                        }))
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            }
        }

        function init() {
            // Initial chart
            @if (isset($chartData) && $chartData['success'])
                updateChart(@json($chartData));
            @endif

            // Event listeners
            window.addEventListener('chart-updated', e => updateChart(e.detail.data));

            // Livewire fallback
            document.addEventListener('livewire:init', () => {
                Livewire.on('chart-updated', payload => {
                    console.log('[chart] payload:', payload);
                    updateChart(payload);
                });
            });
        }

        return {
            init,
            update: updateChart
        };
    })();

    // Robust init: handle Livewire lifecycle (initial load, navigated, and DOM updates)
    function tryInitHistoryChart() {
        if (window.HistoryChart && typeof window.HistoryChart.init === 'function') {
            try {
                window.HistoryChart.init();
            } catch (e) {
                console.error('[HistoryChart] init error', e);
            }
        }
    }

    // 1) Initial load via Livewire
    document.addEventListener('livewire:load', () => {
        tryInitHistoryChart();
    });

    // 2) Livewire "navigation" (SPA-like)
    window.addEventListener('livewire:navigated', () => {
        tryInitHistoryChart();
    });

    // 3) Hook after Livewire processes a message — init if our canvas is present in the updated fragment
    if (window.Livewire && typeof Livewire.hook === 'function') {
        Livewire.hook('message.processed', (message, component) => {
            try {
                const root = component?.el ?? document;
                if (root && root.querySelector && root.querySelector('#trendChart')) {
                    tryInitHistoryChart();
                }
            } catch (e) {
                // minimal noisy logging
                console.warn('[HistoryChart] hook error', e);
            }
        });
    }

    // Fallback for regular page load
    document.addEventListener('DOMContentLoaded', tryInitHistoryChart);
</script>