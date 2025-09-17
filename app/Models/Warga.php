<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Warga extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     *
     * @var string
     */
    protected $table = 'warga';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'kartu_keluarga_id',
        'nik',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'status_perkawinan',
        'status_hubungan_keluarga',
        'pendidikan_terakhir',
        'pekerjaan',
        'golongan_darah',
        'nama_ayah',
        'nama_ibu',
        'aktif',
        'keterangan',
    ];

    /**
     * Tipe data atribut yang perlu di-casting.
     *
     * @var array
     */
    protected $casts = [
        'aktif' => 'boolean',
    ];

    /**
     * Relasi: Satu Warga adalah bagian dari satu Kartu Keluarga.
     */
    public function kartuKeluarga(): BelongsTo
    {
        return $this->belongsTo(KartuKeluarga::class);
    }

    /**
     * Relasi: Satu Warga memiliki banyak catatan Histori Kependudukan.
     */
    public function histori(): HasMany
    {
        return $this->hasMany(HistoryKependudukan::class);
    }
}

