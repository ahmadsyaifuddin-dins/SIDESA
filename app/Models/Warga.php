<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Warga extends Model
{
    use HasFactory;
    // 2. GUNAKAN TRAIT UNTUK MENGAKTIFKAN LOGGING
    use LogsActivity;

    protected $table = 'warga';
    
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

    protected $casts = [
        'aktif' => 'boolean',
    ];
    
    /**
     * PENAMBAHAN BARU: Accessor untuk atribut 'name'.
     * Ini memungkinkan kita untuk memanggil $warga->name, yang akan mengembalikan
     * nilai dari atribut 'nama_lengkap'. Sangat berguna untuk kompatibilitas
     * dengan view atau package lain yang mengharapkan atribut 'name'.
     *
     * @return string
     */
    public function getNameAttribute(): string
    {
        return $this->attributes['nama_lengkap'];
    }
    
    // 3. KONFIGURASI ACTIVITY LOG (CARA MODERN & FLEKSIBEL)
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            // Tentukan nama log untuk model ini
            ->useLogName('Warga')
            
            // Catat hanya atribut yang ada di $fillable dan 'aktif'
            ->logOnly(array_merge($this->fillable, ['aktif']))
            
            // Saat update, catat hanya atribut yang benar-benar berubah
            ->logOnlyDirty()
            
            // Jangan catat log jika tidak ada atribut yang berubah
            ->dontSubmitEmptyLogs()
            
            // Buat deskripsi log yang dinamis dan mudah dibaca
            ->setDescriptionForEvent(function(string $eventName) {
                // Menggunakan helper function agar lebih rapi
                $aksi = $this->getEventDescription($eventName);
                return "Data warga '{$this->nama_lengkap}' telah di-{$aksi}";
            });
    }

    /**
     * Helper function untuk menerjemahkan nama event menjadi teks Bahasa Indonesia.
     *
     * @param string $eventName
     * @return string
     */
    protected function getEventDescription(string $eventName): string
    {
        return match ($eventName) {
            'created' => 'tambahkan',
            'updated' => 'perbarui',
            'deleted' => 'hapus',
            default   => 'lakukan aksi',
        };
    }


    // --- RELASI (TIDAK ADA PERUBAHAN) ---
    public function kartuKeluarga(): BelongsTo
    {
        return $this->belongsTo(KartuKeluarga::class);
    }
    
    public function histori(): HasMany
    {
        return $this->hasMany(HistoryKependudukan::class);
    }
}