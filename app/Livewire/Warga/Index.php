<?php

namespace App\Livewire\Warga;

use App\Imports\WargaImport;
use App\Models\Warga;
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

    public bool $showImportModal = false;
    public $file;

    // Metode ini akan otomatis dijalankan setiap kali properti $search diubah.
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    // Metode ini akan otomatis dijalankan setiap kali properti $perPage diubah.
    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    public function import()
    {
        $this->validate([
            'file' => 'required|mimes:xlsx,xls|max:5240',
        ]);

        try {
            // Buat instance dari importer untuk bisa mengambil hasil hitungannya
            $importer = new WargaImport;

            // Jalankan impor secara langsung
            Excel::import($importer, $this->file);
            
            // Ambil jumlah data yang berhasil diimpor
            $count = $importer->wargaBerhasilDiimpor;

            if ($count > 0) {
                $this->dispatch('flash-message-display', [
                    'message' => "Impor Selesai! Sebanyak {$count} data warga berhasil diproses.",
                    'type' => 'success'
                ]);
            } else {
                 $this->dispatch('flash-message-display', [
                    'message' => 'Impor selesai, namun tidak ada data warga baru yang dapat diproses. Pastikan format file benar.',
                    'type' => 'error'
                ]);
            }

            $this->closeImportModal();
            $this->dispatch('refresh-data');

        } catch (\Throwable $e) {
            Log::error('EXCEPTION SAAT IMPOR: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            $this->dispatch('flash-message-display', [
                'message' => 'Terjadi kesalahan fatal saat mengimpor. Silakan cek log untuk detail.',
                'type' => 'error'
            ]);
            $this->closeImportModal();
        }
    }

    public function closeImportModal()
    {
        $this->showImportModal = false;
        $this->file = null;
    }

    public function render()
    {
        $warga = Warga::with('kartuKeluarga')
            ->when($this->search, function ($query) {
                $query->where('nama_lengkap', 'like', "%{$this->search}%")
                      ->orWhere('nik', 'like', "%{$this->search}%")
                      ->orWhereHas('kartuKeluarga', function ($subQuery) {
                          $subQuery->where('nomor_kk', 'like', "%{$this->search}%");
                      });
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.warga.index', [
            'warga' => $warga,
        ]);
    }
}

