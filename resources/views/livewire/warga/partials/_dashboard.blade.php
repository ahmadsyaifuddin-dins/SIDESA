{{-- 
    File ini adalah "Zona Aman" yang dikelola oleh Alpine.js.
    Livewire diperintahkan untuk mengabaikannya (`wire:ignore`)
    agar tidak merusak statistik dan grafik saat ada pembaruan.
--}}
<div
    wire:ignore
    x-data="{
        chartData: @entangle('chartData'),
        stats: @entangle('stats'),
        chart: null,
        
        init() {
            this.initChart();
            
            // Listen untuk refresh chart event
            Livewire.on('refresh-chart', () => {
                this.refreshChart();
            });
        },
        
        initChart() {
            this.chart = new Chart(this.$refs.canvas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['Laki-laki', 'Perempuan'],
                    datasets: [{
                        label: 'Jumlah Penduduk',
                        data: [this.chartData.laki_laki || 0, this.chartData.perempuan || 0],
                        backgroundColor: ['rgba(59, 130, 246, 0.6)', 'rgba(236, 72, 153, 0.6)'],
                        borderColor: ['rgba(59, 130, 246, 1)', 'rgba(236, 72, 153, 1)'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true } },
                    plugins: { legend: { display: false } }
                }
            });
        },
        
        refreshChart() {
            if (this.chart) {
                this.chart.data.datasets[0].data = [
                    this.stats.laki_laki || 0, 
                    this.stats.perempuan || 0
                ];
                this.chart.update();
            }
        }
    }"
>
    {{-- Statistik Cards --}}
    <div class="mb-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow">
            <p class="text-sm font-medium text-light">Total Warga</p>
            <p class="mt-1 text-3xl font-bold text-main" x-text="$wire.stats?.total || 0"></p>
        </div>
        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow">
            <p class="text-sm font-medium text-light">Laki-laki</p>
            <p class="mt-1 text-3xl font-bold text-main" x-text="$wire.stats?.laki_laki || 0"></p>
        </div>
        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow">
            <p class="text-sm font-medium text-light">Perempuan</p>
            <p class="mt-1 text-3xl font-bold text-main" x-text="$wire.stats?.perempuan || 0"></p>
        </div>
        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow">
            <p class="text-sm font-medium text-light">Total Kartu Keluarga</p>
            <p class="mt-1 text-3xl font-bold text-main" x-text="$wire.stats?.total_kk || 0"></p>
        </div>
    </div>

    {{-- Grafik dan Filter --}}
    <div class="mb-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
             <div class="rounded-lg border border-slate-200 bg-white p-5 shadow">
                 <div class="flex justify-between items-center mb-4">
                     <div>
                         <h3 class="text-lg font-semibold text-main">Grafik Komposisi Penduduk</h3>
                         <p class="mt-1 text-sm text-light">Berdasarkan Jenis Kelamin</p>
                     </div>
                     <!-- Tombol Refresh Chart -->
                     <button 
                         wire:click="refreshChart"
                         class="px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm rounded-lg transition-colors duration-200 flex items-center gap-2"
                     >
                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                         </svg>
                         Refresh
                     </button>
                 </div>
                 <div class="h-72">
                     <canvas x-ref="canvas"></canvas>
                 </div>
             </div>
        </div>
        <div class="lg:col-span-1">
             @include('livewire.warga.partials._filters')
        </div>
    </div>
</div>