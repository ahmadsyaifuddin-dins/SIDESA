<?php

namespace App\Livewire\ActivityLog;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class Index extends Component
{
    use WithPagination;

    // Properti untuk filter dan pencarian
    public string $search = '';
    public int $perPage = 15;
    public ?int $filterCauserId = null;
    public string $filterLogName = '';
    public ?string $filterDateStart = null;
    public ?string $filterDateEnd = null;

    // Properti untuk menampung opsi dropdown
    public $users = [];
    public $logNames = [];

    /**
     * Inisialisasi komponen, memuat data untuk filter.
     */
    public function mount()
    {
        // Ambil semua user untuk filter "Pelaku"
        $this->users = User::orderBy('name')->pluck('name', 'id');
        
        // Ambil semua nama log unik (modul) dari tabel log
        $this->logNames = Activity::distinct()->pluck('log_name');
    }
    
    /**
     * Reset halaman paginasi setiap kali ada perubahan pada filter atau pencarian.
     */
    public function updated($propertyName)
    {
        if (in_array($propertyName, ['search', 'perPage', 'filterCauserId', 'filterLogName', 'filterDateStart', 'filterDateEnd'])) {
            $this->resetPage();
        }
    }

    /**
     * Mereset semua nilai filter ke kondisi awal.
     */
    public function resetFilters()
    {
        $this->reset(['search', 'filterCauserId', 'filterLogName', 'filterDateStart', 'filterDateEnd']);
        $this->resetPage();
    }

    public function render()
    {
        $logsQuery = Activity::with(['causer', 'subject'])
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('description', 'like', '%' . $this->search . '%')
                        ->orWhereHas('causer', function ($causerQuery) {
                            $causerQuery->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->filterCauserId, fn($q) => $q->where('causer_id', $this->filterCauserId))
            ->when($this->filterLogName, fn($q) => $q->where('log_name', $this->filterLogName))
            ->when($this->filterDateStart, fn($q) => $q->whereDate('created_at', '>=', $this->filterDateStart))
            ->when($this->filterDateEnd, fn($q) => $q->whereDate('created_at', '<=', $this->filterDateEnd));

        return view('livewire.activity-log.index', [
            'logs' => $logsQuery->latest()->paginate($this->perPage),
        ]);
    }
}
