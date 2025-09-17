<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoryKependudukan extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     *
     * @var string
     */
    protected $table = 'history_kependudukan';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'warga_id',
        'peristiwa',
        'tanggal_peristiwa',
        'detail_peristiwa',
        'catatan',
        'created_by',
    ];

    /**
     * Tipe data atribut yang perlu di-casting.
     *
     * @var array
     */
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
     * Relasi: Satu catatan Histori dibuat oleh satu User (operator).
     */
    public function pencatat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
