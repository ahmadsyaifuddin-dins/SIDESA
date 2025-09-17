<div x-data="{ title: 'Manajemen Data Warga' }">
    <x-slot:title>
        Manajemen Data Warga
    </x-slot:title>

    @include('livewire.warga.partials._header')
    @include('livewire.warga.partials._dashboard')
    @include('livewire.warga.partials._controls')
    @include('livewire.warga.partials._table')
    @include('livewire.warga.partials._pagination')
    @include('livewire.warga.partials._import-modal')
    
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {
        // Ambil data awal dari server saat halaman pertama kali dimuat
        const initialStats = @json($stats);
        const initialChartData = @json($chartData);
        
        let wargaChart = null;
        
        // Simpan referensi ke elemen DOM agar tidak perlu query berulang kali
        const statTotalEl = document.getElementById('stat-total');
        const statLakiLakiEl = document.getElementById('stat-laki-laki');
        const statPerempuanEl = document.getElementById('stat-perempuan');
        const statTotalKkEl = document.getElementById('stat-total-kk');
        const chartCanvas = document.getElementById('wargaChart');

        // Fungsi terpusat untuk mengupdate semua elemen di dasbor
        function updateDashboard(stats, chartData) {
            if (!stats || !chartData) return;

            // 1. Update kartu statistik
            statTotalEl.innerText = stats.total;
            statLakiLakiEl.innerText = stats.laki_laki;
            statPerempuanEl.innerText = stats.perempuan;
            statTotalKkEl.innerText = stats.total_kk;

            // 2. Update atau inisialisasi chart
            if (wargaChart) {
                // Jika chart sudah ada, cukup update datanya
                wargaChart.data.datasets[0].data = [chartData.laki_laki, chartData.perempuan];
                wargaChart.update();
            } else {
                // Jika belum ada, buat chart baru
                wargaChart = new Chart(chartCanvas.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: ['Laki-laki', 'Perempuan'],
                        datasets: [{
                            label: 'Jumlah Penduduk',
                            data: [chartData.laki_laki, chartData.perempuan],
                            backgroundColor: ['rgba(59, 130, 246, 0.6)', 'rgba(236, 72, 153, 0.6)'],
                            borderColor: ['rgba(59, 130, 246, 1)', 'rgba(236, 72, 153, 1)'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: { y: { beginAtZero: true, ticks: { precision: 0 } } },
                        plugins: { legend: { display: false } }
                    }
                });
            }
        }

        // Panggil fungsi update untuk pertama kali dengan data awal
        updateDashboard(initialStats, initialChartData);

        // Dengarkan event `dashboard-updated` dari Livewire untuk pembaruan selanjutnya
        Livewire.on('dashboard-updated', ({ stats, chartData }) => {
            updateDashboard(stats, chartData);
        });
    });
</script>
@endpush

