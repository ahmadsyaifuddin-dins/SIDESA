<?php

namespace App\Livewire\History;

use App\Models\HistoryKependudukan;
use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use livewire\Attribute;

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

        return view('livewire.history.index', compact('histories'));
    }
}
