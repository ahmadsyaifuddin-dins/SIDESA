<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoryKependudukan extends Model
{
    use HasFactory;

    protected $table = 'history_kependudukan';

    protected $fillable = [
        'warga_id',
        'peristiwa',
        'tanggal_peristiwa',
        'detail_peristiwa',
        'catatan',
        'created_by',
    ];

    protected $casts = [
        'tanggal_peristiwa' => 'date', 
    ];

    /**
     * Relasi: Satu catatan Histori dimiliki oleh satu Warga.
     */
    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class);
    }

    /**
     * PERBAIKAN: Mengubah nama relasi dari 'pencatat' menjadi 'creator'
     * agar konsisten dengan pemanggilan di komponen Livewire dan view.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

