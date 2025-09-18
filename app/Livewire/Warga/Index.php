<?php

namespace App\Livewire\Warga;

use App\Imports\WargaImport;
use App\Models\Warga;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    use WithPagination;
    use WithFileUploads;

    public string $search = '';
    public int $perPage = 15;
    public $file;
    public string $filterJenisKelamin = '';
    public string $filterAgama = '';
    public ?int $filterUsiaMin = null;
    public ?int $filterUsiaMax = null;

    // --- PENAMBAHAN PROPERTI BARU ---
    public string $filterPendidikan = '';
    public string $filterStatusPerkawinan = '';

    public string $chartMode = 'jenis_kelamin'; // Mode default

    public array $opsiAgama = [];
    // --- PENAMBAHAN PROPERTI BARU UNTUK OPSI ---
    public array $opsiPendidikan = [];
    public array $opsiStatusPerkawinan = [];

    public ?Warga $wargaToDelete = null;

    protected $listeners = ['refresh-data' => '$refresh'];

    public function mount()
    {
        // Memuat semua opsi dari file config/options.php
        $this->opsiAgama = config('options.agama', []);
        $this->opsiPendidikan = config('options.pendidikan', []);
        $this->opsiStatusPerkawinan = config('options.status_perkawinan', []);
    }

    public function updated($propertyName)
    {
        // Menambahkan properti baru ke dalam list yang akan mereset paginasi
        if (in_array($propertyName, [
            'search',
            'perPage',
            'filterJenisKelamin',
            'filterAgama',
            'filterUsiaMin',
            'filterUsiaMax',
            'filterPendidikan',
            'filterStatusPerkawinan'
        ])) {
            $this->resetPage();
        }
    }

    public function resetFilters()
    {
        // Menambahkan properti baru untuk di-reset
        $this->reset([
            'filterJenisKelamin',
            'filterAgama',
            'filterUsiaMin',
            'filterUsiaMax',
            'search',
            'filterPendidikan',
            'filterStatusPerkawinan'
        ]);
        $this->resetPage();
    }

    public function confirmDelete(Warga $warga)
    {
        $this->wargaToDelete = $warga;
        $this->dispatch('open-delete-modal');
    }

    public function deleteWarga()
    {
        if ($this->wargaToDelete) {
            $nama = $this->wargaToDelete->nama_lengkap;
            $this->wargaToDelete->delete();

            $this->dispatch('flash-message-display', [
                'message' => "Data warga '{$nama}' berhasil dihapus.",
                'type' => 'success'
            ]);
            $this->dispatch('refresh-data');
            $this->dispatch('close-delete-modal');
        }
    }

    public function import()
    {
        $this->validate(['file' => 'required|mimes:xlsx,xls|max:5240']);
        try {
            $importer = new WargaImport;
            Excel::import($importer, $this->file);
            $count = $importer->wargaBerhasilDiimpor;
            if ($count > 0) {
                $this->dispatch('flash-message-display', ['message' => "Impor Selesai! Sebanyak {$count} data warga berhasil diproses.", 'type' => 'success']);
            } else {
                $this->dispatch('flash-message-display', ['message' => 'Impor selesai, namun tidak ada data warga baru yang dapat diproses. Pastikan format file benar.', 'type' => 'error']);
            }
            $this->dispatch('refresh-data');
            $this->dispatch('close-import-modal');
        } catch (\Throwable $e) {
            Log::error('EXCEPTION SAAT IMPOR: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            $this->dispatch('flash-message-display', ['message' => 'Terjadi kesalahan fatal saat mengimpor. Silakan cek log untuk detail.', 'type' => 'error']);
        }
    }

    public function render()
    {
        $wargaQuery = Warga::query()
            ->when($this->search, fn($q) => $q->where(fn($sq) => $sq->where('nama_lengkap', 'like', "%{$this->search}%")->orWhere('nik', 'like', "%{$this->search}%")->orWhereHas('kartuKeluarga', fn($kq) => $kq->where('nomor_kk', 'like', "%{$this->search}%"))))
            ->when($this->filterJenisKelamin, fn($q) => $q->where('jenis_kelamin', $this->filterJenisKelamin))
            ->when($this->filterAgama, fn($q) => $q->where('agama', $this->filterAgama))
            ->when($this->filterUsiaMin, fn($q) => $q->where('tanggal_lahir', '<=', Carbon::now()->subYears($this->filterUsiaMin)))
            ->when($this->filterUsiaMax, fn($q) => $q->where('tanggal_lahir', '>=', Carbon::now()->subYears($this->filterUsiaMax)))
            ->when($this->filterPendidikan, fn($q) => $q->where('pendidikan_terakhir', $this->filterPendidikan))
            ->when($this->filterStatusPerkawinan, fn($q) => $q->where('status_perkawinan', $this->filterStatusPerkawinan));

        $stats = [
            'total' => $wargaQuery->count(),
            'laki_laki' => (clone $wargaQuery)->where('jenis_kelamin', 'LAKI-LAKI')->count(),
            'perempuan' => (clone $wargaQuery)->where('jenis_kelamin', 'PEREMPUAN')->count(),
            'total_kk' => (clone $wargaQuery)->distinct('kartu_keluarga_id')->count('kartu_keluarga_id'),
        ];

        // --- PENGAMBILAN DATA UNTUK SEMUA GRAFIK ---
        $allChartData = [
            'jenis_kelamin' => $this->getChartDataJenisKelamin($stats),
            'status_perkawinan' => $this->getChartDataByGroup((clone $wargaQuery), 'status_perkawinan', $this->opsiStatusPerkawinan),
            'pendidikan' => $this->getChartDataByGroup((clone $wargaQuery), 'pendidikan_terakhir', $this->opsiPendidikan),
            'usia' => $this->getChartDataUsia((clone $wargaQuery)),
        ];

        // Mengirim semua data grafik ke frontend
        $this->dispatch('dashboard-updated', stats: $stats, allChartData: $allChartData, chartMode: $this->chartMode);

        $warga = $wargaQuery->with('kartuKeluarga')->latest()->paginate($this->perPage);

        return view('livewire.warga.index', [
            'warga' => $warga,
            'stats' => $stats,
            'allChartData' => $allChartData, // Kirim juga saat render awal
            'chartMode' => $this->chartMode, // Kirim juga saat render awal
        ]);
    }

    // --- FUNGSI-FUNGSI BARU UNTUK MENGAMBIL DATA GRAFIK ---

    private function getChartDataJenisKelamin($stats)
    {
        return [
            'labels' => ['Laki-laki', 'Perempuan'],
            'data' => [$stats['laki_laki'], $stats['perempuan']],
        ];
    }

    private function getChartDataByGroup($query, $column, $options)
    {
        $results = $query->select($column, DB::raw('count(*) as total'))
            ->groupBy($column)
            ->pluck('total', $column);

        $data = collect($options)->map(fn($label, $key) => $results->get($key) ?? 0);

        return [
            'labels' => $data->keys()->toArray(),
            'data' => $data->values()->toArray(),
        ];
    }

    private function getChartDataUsia($query)
    {
        $ageRanges = [
            '0-17' => [0, 17],
            '18-25' => [18, 25],
            '26-40' => [26, 40],
            '41-60' => [41, 60],
            '60+' => [61, 200],
        ];

        $results = $query->select(DB::raw("
            CASE
                WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 0 AND 17 THEN '0-17'
                WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 18 AND 25 THEN '18-25'
                WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 26 AND 40 THEN '26-40'
                WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 41 AND 60 THEN '41-60'
                ELSE '60+'
            END as age_range,
            count(*) as total
        "))->groupBy('age_range')->pluck('total', 'age_range');

        $data = collect($ageRanges)->map(fn($range, $label) => $results->get($label) ?? 0);

        return [
            'labels' => $data->keys()->toArray(),
            'data' => $data->values()->toArray(),
        ];
    }
}
