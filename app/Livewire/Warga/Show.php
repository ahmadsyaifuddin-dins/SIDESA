<?php

namespace App\Livewire\Warga;

use App\Models\Warga;
use Livewire\Component;

class Show extends Component
{
    public Warga $warga;

    public function mount(Warga $warga)
    {
        // Muat relasi yang dibutuhkan agar tidak terjadi N+1 problem
        $this->warga = $warga->load(['kartuKeluarga.kepalaKeluarga', 'histori']);
    }

    public function render()
    {
        return view('livewire.warga.show');
    }
}
