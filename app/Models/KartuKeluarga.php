<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KartuKeluarga extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     *
     * @var string
     */
    protected $table = 'kartu_keluarga';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'nomor_kk',
        'kepala_keluarga_id',
        'alamat',
        'rt',
        'rw',
        'kode_pos',
        'desa_kelurahan',
        'kecamatan',
        'kabupaten_kota',
        'provinsi',
        'latitude',
        'longitude',
    ];

    /**
     * Relasi: Satu Kartu Keluarga memiliki banyak Warga (anggota).
     */
    public function anggota(): HasMany
    {
        return $this->hasMany(Warga::class);
    }

    /**
     * Relasi: Satu Kartu Keluarga dimiliki oleh satu Warga sebagai Kepala Keluarga.
     */
    public function kepalaKeluarga(): BelongsTo
    {
        return $this->belongsTo(Warga::class, 'kepala_keluarga_id');
    }
}

