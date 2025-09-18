{{-- 1. Tambahkan x-data untuk mengelola semua status UI di frontend --}}
<div x-data="{ 
    title: 'Manajemen Data Warga',
    showImportModal: false,
    showDeleteModal: false,
    showFilters: false
}"
{{-- 2. Tambahkan listener untuk event dari backend --}}
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

{{-- Panggil Modal dari file parsialnya masing-masing --}}
@include('livewire.warga.partials._import-modal')
@include('livewire.warga.partials._delete-modal')

</div>

@push('scripts')
{{-- script vanilla js Anda tetap sama dan aman --}}
<script>
document.addEventListener('livewire:navigated', () => {
const initialStats = @json($stats);
const initialChartData = @json($chartData);
let wargaChart = null;
const statTotalEl = document.getElementById('stat-total');
const statLakiLakiEl = document.getElementById('stat-laki-laki');
const statPerempuanEl = document.getElementById('stat-perempuan');
const statTotalKkEl = document.getElementById('stat-total-kk');
const chartCanvas = document.getElementById('wargaChart');
if (!chartCanvas) return;
function updateDashboard(stats, chartData) {
    if (!stats || !chartData) return;
    statTotalEl.innerText = stats.total;
    statLakiLakiEl.innerText = stats.laki_laki;
    statPerempuanEl.innerText = stats.perempuan;
    statTotalKkEl.innerText = stats.total_kk;
    if (wargaChart) {
        wargaChart.data.datasets[0].data = [chartData.laki_laki, chartData.perempuan];
        wargaChart.update();
    } else {
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
updateDashboard(initialStats, initialChartData);
Livewire.on('dashboard-updated', ({ stats, chartData }) => {
    updateDashboard(stats, chartData);
});
});
</script>
@endpush

