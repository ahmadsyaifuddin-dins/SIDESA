<?php

namespace App\Livewire\History;

use App\Models\HistoryKependudukan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

#[Title('Riwayat Kependudukan')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 15;

    // Properti untuk filter
    public string $filterPeristiwa = '';
    public string $filterUser = '';
    public ?string $filterTanggalMulai = null;
    public ?string $filterTanggalSelesai = null;

    // Properti untuk chart - FIXED: default ke periode yang ada data
    public string $chartPeriod = '1year';

    // Properti untuk opsi dropdown
    public array $opsiPeristiwa = [
        'LAHIR' => 'Kelahiran',
        'MENINGGAL' => 'Kematian',
        'PINDAH MASUK' => 'Pindah Masuk',
        'PINDAH KELUAR' => 'Pindah Keluar',
        'TIDAK DIKETAHUI' => 'Tidak Diketahui',
    ];
    public $opsiUser;

    public function mount()
    {
        // Mengambil daftar admin/user yang pernah mencatat Riwayat
        $this->opsiUser = User::whereIn('id', HistoryKependudukan::select('created_by')->distinct())
            ->pluck('name', 'id');
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['search', 'perPage', 'filterPeristiwa', 'filterUser', 'filterTanggalMulai', 'filterTanggalSelesai'])) {
            $this->resetPage();
        }
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterPeristiwa', 'filterUser', 'filterTanggalMulai', 'filterTanggalSelesai']);
        $this->resetPage();
    }

    /**
     * FIXED: Method untuk mendapatkan data chart dengan periode dinamis
     */
    public function getChartData()
    {
        try {
            // Menentukan rentang tanggal berdasarkan periode
            $dateRange = $this->getDateRange($this->chartPeriod);
            $startDate = $dateRange['start']->format('Y-m-d');
            $endDate = $dateRange['end']->format('Y-m-d');

            // Query data berdasarkan periode
            $rawData = HistoryKependudukan::select([
                'peristiwa',
                DB::raw('DATE_FORMAT(tanggal_peristiwa, "%Y-%m") as month_year'),
                DB::raw('COUNT(*) as jumlah')
            ])
                ->whereDate('tanggal_peristiwa', '>=', $startDate)
                ->whereDate('tanggal_peristiwa', '<=', $endDate)
                ->groupBy('peristiwa', 'month_year')
                ->orderBy('month_year', 'asc')
                ->get();

            // Generate continuous month keys YYYY-MM
            $current = $dateRange['start']->copy();
            $monthKeys = [];
            while ($current->lte($dateRange['end'])) {
                $monthKeys[] = $current->format('Y-m');
                $current->addMonth();
            }

            // Convert ke labels M Y
            $labels = array_map(function ($ym) {
                return Carbon::createFromFormat('Y-m', $ym)->format('M Y');
            }, $monthKeys);

            // Group raw data untuk lookup
            $grouped = [];
            foreach ($rawData as $row) {
                $grouped[$row->peristiwa][$row->month_year] = (int) $row->jumlah;
            }

            // Generate datasets dengan panjang sama
            $peristiwaTypes = ['LAHIR', 'MENINGGAL', 'PINDAH MASUK', 'PINDAH KELUAR', 'TIDAK DIKETAHUI'];
            $datasets = [];

            foreach ($peristiwaTypes as $peristiwa) {
                $data = [];
                foreach ($monthKeys as $ym) {
                    $data[] = $grouped[$peristiwa][$ym] ?? 0;
                }

                $datasets[] = [
                    'label' => $peristiwa,
                    'data' => $data,
                    'fill' => false,
                    'tension' => 0.4
                ];
            }

            return [
                'success' => true,
                'labels' => $labels,
                'datasets' => $datasets,
                'period' => $this->chartPeriod
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Gagal mengambil data chart'
            ];
        }
    }

    public function updatedChartPeriod($value)
    {
        $chartData = $this->getChartData();
        $this->dispatch('chart-updated', data: $chartData);
    }

    /**
     * Handle event when a new history record is created elsewhere in the app.
     * This will regenerate chart data and push to the frontend.
     */
    #[On('history-created')]
    public function onHistoryCreated()
    {
        $chartData = $this->getChartData();
        // Livewire v3: dispatch browser DOM event with named param 'data'
        $this->dispatch('chart-updated', data: $chartData);
    }

    /**
     * FIXED: Method refresh chart dengan event yang benar
     */
    public function refreshChart()
    {
        $chartData = $this->getChartData();
        $this->dispatch('chart-refreshed', data: $chartData);
    }

    /**
     * FIXED: Optimized date range calculation
     */
    private function getDateRange($period)
    {
        $now = Carbon::now();

        switch ($period) {
            case '6months':
                // 6 bulan terakhir termasuk bulan ini
                $start = $now->copy()->subMonths(5)->startOfMonth();
                $end   = $now->copy()->endOfMonth();
                break;

            case '1year':
                // 12 bulan terakhir termasuk bulan ini
                $start = $now->copy()->subMonths(11)->startOfMonth();
                $end   = $now->copy()->endOfMonth();
                break;

            case '2years':
                // 24 bulan terakhir termasuk bulan ini
                $start = $now->copy()->subMonths(23)->startOfMonth();
                $end   = $now->copy()->endOfMonth();
                break;

            case 'all':
            default:
                // Ambil seluruh range data dari database
                $earliestDate = HistoryKependudukan::min('tanggal_peristiwa');
                $latestDate   = HistoryKependudukan::max('tanggal_peristiwa');

                if (!$earliestDate || !$latestDate) {
                    // Fallback jika tidak ada data
                    $start = $now->copy()->subMonths(11)->startOfMonth();
                    $end   = $now->copy()->endOfMonth();
                } else {
                    $start = Carbon::parse($earliestDate)->startOfMonth();
                    $end   = Carbon::parse($latestDate)->endOfMonth();
                }
                break;
        }

        return [
            'start' => $start,
            'end' => $end
        ];
    }

    /**
     * FIXED: Generate consistent labels
     */
    private function generateLabels($startDate, $endDate)
    {
        $labels = [];
        $current = $startDate->copy()->startOfMonth();
        $end = $endDate->copy()->endOfMonth();

        while ($current->lte($end)) {
            $labels[] = $current->format('M Y');
            $current->addMonth();
        }

        return $labels;
    }

    /**
     * Method untuk mendapatkan statistik ringkas
     */
    public function getChartStats()
    {
        try {
            $dateRange = $this->getDateRange($this->chartPeriod);

            $stats = HistoryKependudukan::select([
                'peristiwa',
                DB::raw('COUNT(*) as total')
            ])
                ->whereDate('tanggal_peristiwa', '>=', $dateRange['start']->format('Y-m-d'))
                ->whereDate('tanggal_peristiwa', '<=', $dateRange['end']->format('Y-m-d'))
                ->groupBy('peristiwa')
                ->get()
                ->keyBy('peristiwa');

            // Pastikan semua jenis peristiwa ada dalam response
            $peristiwaTypes = ['LAHIR', 'MENINGGAL', 'PINDAH MASUK', 'PINDAH KELUAR', 'TIDAK DIKETAHUI'];
            $result = [];

            foreach ($peristiwaTypes as $peristiwa) {
                $result[$peristiwa] = $stats->has($peristiwa) ? (int) $stats[$peristiwa]->total : 0;
            }

            return [
                'success' => true,
                'stats' => $result,
                'period' => $this->chartPeriod,
                'total_records' => array_sum($result)
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Gagal mengambil statistik',
                'error' => $e->getMessage()
            ];
        }
    }

    public function render()
    {
        $historiesQuery = HistoryKependudukan::query()
            ->with(['warga', 'creator']) // Eager load untuk performa
            ->when($this->search, function ($query) {
                $query->whereHas('warga', function ($q) {
                    $q->where('nama_lengkap', 'like', "%{$this->search}%")
                        ->orWhere('nik', 'like', "%{$this->search}%");
                });
            })
            ->when($this->filterPeristiwa, fn($q) => $q->where('peristiwa', $this->filterPeristiwa))
            ->when($this->filterUser, fn($q) => $q->where('created_by', $this->filterUser))
            ->when($this->filterTanggalMulai, fn($q) => $q->whereDate('tanggal_peristiwa', '>=', $this->filterTanggalMulai))
            ->when($this->filterTanggalSelesai, fn($q) => $q->whereDate('tanggal_peristiwa', '<=', $this->filterTanggalSelesai));

        $histories = $historiesQuery->latest()->paginate($this->perPage);

        // Data untuk chart
        $chartData = $this->getChartData();
        $chartStats = $this->getChartStats();

        return view('livewire.history.index', compact('histories', 'chartData', 'chartStats'));
    }
}
