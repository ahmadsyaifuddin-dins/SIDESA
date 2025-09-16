<?php

namespace App\Livewire\Ui;

use Livewire\Component;
use Livewire\Attributes\On; 

class Navbar extends Component
{
    // 2. Buat method kosong yang "mendengarkan" event 'profile-updated'
    //    Saat event ini diterima, Livewire akan otomatis me-render ulang komponen ini.
    #[On('profile-updated')]
    public function refresh()
    {
        // Method ini bisa dibiarkan kosong.
    }

    public function render()
    {
        return view('livewire.ui.navbar');
    }
}
