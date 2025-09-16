<?php

namespace App\Livewire\ActivityLog;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class Index extends Component
{
    use WithPagination;

    // Opsi ini akan menggunakan view paginasi default dari Livewire yang kompatibel dengan Tailwind.
    // Pastikan Anda telah mem-publish view paginasi Livewire jika ingin mengkustomisasinya.
    // php artisan vendor:publish --tag=livewire:pagination
    protected $paginationTheme = 'tailwind';

    public function render()
    {
        // 1. Ambil data log dari database, urutkan dari yang terbaru.
        $activityLogs = Activity::latest()->paginate(15);

        // 2. Kirim data tersebut ke view dengan nama variabel 'logs'.
        //    Kunci array ('logs') akan menjadi nama variabel ($logs) di file Blade.
        return view('livewire.activity-log.index', [
            'logs' => $activityLogs,
        ]);
    }
}

