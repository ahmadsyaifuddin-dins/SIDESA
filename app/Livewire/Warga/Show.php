<?php

namespace App\Livewire\Warga;

use App\Models\Warga;
use Livewire\Component;
use App\Helpers\BreadcrumbHelper;

class Show extends Component
{
    public Warga $warga;
    public $breadcrumbs = [];

    public function mount(Warga $warga)
    {
        
        // Dispatch breadcrumb ke navbar
        $this->dispatch('update-breadcrumbs', breadcrumbs: $this->breadcrumbs);
        $this->breadcrumbs = BreadcrumbHelper::warga('show', $warga);
        
        // Muat relasi yang dibutuhkan agar tidak terjadi N+1 problem
        $this->warga = $warga->load(['kartuKeluarga.kepalaKeluarga', 'histori']);

        $this->dispatch('update-breadcrumbs', breadcrumbs: $this->breadcrumbs);

    }

    public function render()
    {
        return view('livewire.warga.show');
    }
}
