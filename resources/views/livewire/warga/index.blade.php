<div x-data="{ 
    title: 'Manajemen Data Warga',
    showImportModal: false,
    showDeleteModal: false,
    showFilters: false
}"
@open-delete-modal.window="showDeleteModal = true"
@close-delete-modal.window="showDeleteModal = false"
@close-import-modal.window="showImportModal = false"
>
    <x-slot:title>
        Manajemen Data Warga
    </x-slot:title>

    @include('livewire.warga.partials._header')
    @include('livewire.warga.partials._dashboard')
    @include('livewire.warga.partials._controls')
    @include('livewire.warga.partials._table')
    @include('livewire.warga.partials._pagination')
    @include('livewire.warga.partials._import-modal')
    @include('livewire.warga.partials._delete-modal')

</div>

@push('scripts')
{{-- PEROMBAKAN TOTAL SCRIPT GRAFIK --}}
<script>
document.addEventListener('livewire:navigated', () => {
    // Mengambil semua data yang dibutuhkan saat halaman dimuat
    const initialStats = @json($stats);
    const allInitialChartData = @json($allChartData);
    const initialChartMode = @json($chartMode);

    let wargaChart = null; // Variabel global untuk instance Chart.js
    const chartCanvas = document.getElementById('wargaChart');
    if (!chartCanvas) return;

    // Elemen statis untuk statistik
    const statTotalEl = document.getElementById('stat-total');
    const statLakiLakiEl = document.getElementById('stat-laki-laki');
    const statPerempuanEl = document.getElementById('stat-perempuan');
    const statTotalKkEl = document.getElementById('stat-total-kk');
    const chartDescriptionEl = document.getElementById('chart-description');

    // Fungsi untuk memperbarui kartu statistik
    function updateStats(stats) {
        if (!stats) return;
        statTotalEl.innerText = stats.total;
        statLakiLakiEl.innerText = stats.laki_laki;
        statPerempuanEl.innerText = stats.perempuan;
        statTotalKkEl.innerText = stats.total_kk;
    }
    
    // Fungsi utama untuk me-render atau memperbarui grafik
    function renderChart(mode, data) {
        if (!data || !data[mode]) return;
        
        const chartConfig = {
            jenis_kelamin: { title: 'Berdasarkan Jenis Kelamin', colors: ['rgba(59, 130, 246, 0.6)', 'rgba(236, 72, 153, 0.6)'] },
            usia: { title: 'Berdasarkan Kelompok Usia', colors: ['rgba(16, 185, 129, 0.6)'] },
            status_perkawinan: { title: 'Berdasarkan Status Perkawinan', colors: ['rgba(245, 158, 11, 0.6)'] },
            pendidikan: { title: 'Berdasarkan Pendidikan Terakhir', colors: ['rgba(139, 92, 246, 0.6)'] },
        };

        const config = chartConfig[mode];
        const chartData = data[mode];
        chartDescriptionEl.innerText = config.title;

        if (wargaChart) {
            // Jika grafik sudah ada, update datanya
            wargaChart.data.labels = chartData.labels;
            wargaChart.data.datasets[0].data = chartData.data;
            wargaChart.data.datasets[0].backgroundColor = config.colors;
            wargaChart.options.plugins.title.text = `Grafik Penduduk ${config.title}`;
            wargaChart.update();
        } else {
            // Jika belum ada, buat instance grafik baru
            wargaChart = new Chart(chartCanvas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Jumlah Penduduk',
                        data: chartData.data,
                        backgroundColor: config.colors,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true, ticks: { precision: 0 } } },
                    plugins: {
                        legend: { display: false },
                        title: {
                            display: true,
                            text: `Grafik Penduduk ${config.title}`,
                            padding: { top: 10, bottom: 20 }
                        }
                    }
                }
            });
        }
    }

    // --- INISIALISASI SAAT HALAMAN DIMUAT ---
    updateStats(initialStats);
    renderChart(initialChartMode, allInitialChartData);

    // --- LISTENER UNTUK EVENT DARI LIVEWIRE ---
    Livewire.on('dashboard-updated', ({ stats, allChartData, chartMode }) => {
        updateStats(stats);
        renderChart(chartMode, allChartData);
    });
});
</script>
@endpush
