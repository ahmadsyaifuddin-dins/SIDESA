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
{{-- SCRIPT GRAFIK DISESUAIKAN DENGAN GAYA TERDAHULU --}}
<script>
document.addEventListener('livewire:navigated', () => {
    const initialStats = @json($stats);
    const allInitialChartData = @json($allChartData);
    const initialChartMode = @json($chartMode);

    let wargaChart = null;
    const chartCanvas = document.getElementById('wargaChart');
    if (!chartCanvas) return;

    const statTotalEl = document.getElementById('stat-total');
    const statLakiLakiEl = document.getElementById('stat-laki-laki');
    const statPerempuanEl = document.getElementById('stat-perempuan');
    const statTotalKkEl = document.getElementById('stat-total-kk');
    const chartDescriptionEl = document.getElementById('chart-description');

    function updateStats(stats) {
        if (!stats) return;
        statTotalEl.innerText = stats.total;
        statLakiLakiEl.innerText = stats.laki_laki;
        statPerempuanEl.innerText = stats.perempuan;
        statTotalKkEl.innerText = stats.total_kk;
    }
    
    // Fungsi untuk menghasilkan warna dinamis
    const generateColors = (num) => {
        const colors = [];
        for (let i = 0; i < num; i++) {
            const hue = (360 / num) * i;
            colors.push(`hsla(${hue}, 70%, 60%, 0.6)`);
        }
        return colors;
    };

    function renderChart(mode, data) {
        if (!data || !data[mode]) return;
        
        const chartConfig = {
            jenis_kelamin: { title: 'Berdasarkan Jenis Kelamin', colors: ['rgba(59, 130, 246, 0.6)', 'rgba(236, 72, 153, 0.6)'] },
            usia: { title: 'Berdasarkan Kelompok Usia', colors: generateColors(data[mode].labels.length) },
            status_perkawinan: { title: 'Berdasarkan Status Perkawinan', colors: ['#4CAF50', '#2196F3', '#FFEB3B', '#9E9E9E'] },
            pendidikan: { title: 'Berdasarkan Pendidikan Terakhir', colors: generateColors(data[mode].labels.length) },
            rt: { title: 'Berdasarkan RT', colors: generateColors(data[mode].labels.length) },
        };

        const config = chartConfig[mode];
        const chartData = data[mode];
        chartDescriptionEl.innerText = config.title;

        const borderColors = config.colors.map(color => color.replace('0.6', '1').replace('hsla', 'hsl'));

        if (wargaChart) {
            wargaChart.data.labels = chartData.labels;
            wargaChart.data.datasets[0].data = chartData.data;
            wargaChart.data.datasets[0].backgroundColor = config.colors;
            wargaChart.data.datasets[0].borderColor = borderColors;
            wargaChart.options.plugins.title.text = `Grafik Penduduk ${config.title}`;
            wargaChart.update();
        } else {
            wargaChart = new Chart(chartCanvas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Jumlah Penduduk',
                        data: chartData.data,
                        backgroundColor: config.colors,
                        borderColor: borderColors,
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
                            display: false, // Judul di dalam chart bisa di non-aktifkan jika sudah ada di luar
                            text: `Grafik Penduduk ${config.title}`,
                            padding: { top: 10, bottom: 20 }
                        }
                    }
                }
            });
        }
    }

    // Inisialisasi saat halaman dimuat
    updateStats(initialStats);
    renderChart(initialChartMode, allInitialChartData);

    // Listener untuk event dari Livewire
    Livewire.on('dashboard-updated', ({ stats, allChartData, chartMode }) => {
        updateStats(stats);
        renderChart(chartMode, allChartData);
    });
});
</script>
@endpush

