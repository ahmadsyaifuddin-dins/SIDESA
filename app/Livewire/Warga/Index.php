<?php

namespace App\Livewire\Warga;

use App\Imports\WargaImport;
use App\Models\Warga;
use Carbon\Carbon;
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

    public array $opsiAgama = [];

    // HANYA properti untuk data yang akan dihapus yang kita perlukan
    public ?Warga $wargaToDelete = null;

    protected $listeners = ['refresh-data' => '$refresh'];

    public function mount()
    {
        $this->opsiAgama = config('options.agama', []);
    }
    
    public function updated($propertyName)
    {
        if (in_array($propertyName, ['search', 'perPage', 'filterJenisKelamin', 'filterAgama', 'filterUsiaMin', 'filterUsiaMax'])) {
            $this->resetPage();
        }
    }

    public function resetFilters()
    {
        $this->reset(['filterJenisKelamin', 'filterAgama', 'filterUsiaMin', 'filterUsiaMax', 'search']);
        $this->resetPage();
    }

    // Metode ini hanya menyiapkan data dan MENGIRIM EVENT ke Alpine.js
    public function confirmDelete(Warga $warga)
    {
        $this->wargaToDelete = $warga;
        $this->dispatch('open-delete-modal'); // Kirim sinyal ke frontend
    }

    // Metode ini menghapus data dan MENGIRIM EVENT ke Alpine.js
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
            $this->dispatch('close-delete-modal'); // Kirim sinyal ke frontend
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
                $this->dispatch('flash-message-display', ['message' => "Impor Selesai! Sebanyak {$count} data warga berhasil diproses.",'type' => 'success']);
            } else {
                 $this->dispatch('flash-message-display', ['message' => 'Impor selesai, namun tidak ada data warga baru yang dapat diproses. Pastikan format file benar.', 'type' => 'error']);
            }
            $this->dispatch('refresh-data');
            $this->dispatch('close-import-modal'); // Kirim sinyal ke frontend

        } catch (\Throwable $e) {
            Log::error('EXCEPTION SAAT IMPOR: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            $this->dispatch('flash-message-display', ['message' => 'Terjadi kesalahan fatal saat mengimpor. Silakan cek log untuk detail.','type' => 'error']);
        }
    }

    public function render()
    {
        $wargaQuery = Warga::query()
            ->when($this->search, fn($q) => $q->where(fn($sq) => $sq->where('nama_lengkap', 'like', "%{$this->search}%")->orWhere('nik', 'like', "%{$this->search}%")->orWhereHas('kartuKeluarga', fn($kq) => $kq->where('nomor_kk', 'like', "%{$this->search}%"))))
            ->when($this->filterJenisKelamin, fn($q) => $q->where('jenis_kelamin', $this->filterJenisKelamin))
            ->when($this->filterAgama, fn($q) => $q->where('agama', $this->filterAgama))
            ->when($this->filterUsiaMin, fn($q) => $q->where('tanggal_lahir', '<=', Carbon::now()->subYears($this->filterUsiaMin)))
            ->when($this->filterUsiaMax, fn($q) => $q->where('tanggal_lahir', '>=', Carbon::now()->subYears($this->filterUsiaMax)));
        
        $stats = [
            'total' => $wargaQuery->count(),
            'laki_laki' => (clone $wargaQuery)->where('jenis_kelamin', 'LAKI-LAKI')->count(),
            'perempuan' => (clone $wargaQuery)->where('jenis_kelamin', 'PEREMPUAN')->count(),
            'total_kk' => (clone $wargaQuery)->distinct('kartu_keluarga_id')->count('kartu_keluarga_id'),
        ];
        
        $chartData = [
            'laki_laki' => $stats['laki_laki'],
            'perempuan' => $stats['perempuan'],
        ];
        
        $this->dispatch('dashboard-updated', stats: $stats, chartData: $chartData);
        
        $warga = $wargaQuery->with('kartuKeluarga')->latest()->paginate($this->perPage);

        return view('livewire.warga.index', [
            'warga' => $warga,
            'stats' => $stats,
            'chartData' => $chartData,
        ]);
    }
}