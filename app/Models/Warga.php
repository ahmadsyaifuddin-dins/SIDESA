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
    use HasFactory, LogsActivity;

    protected $table = 'warga';
    
    protected $fillable = [
        'kartu_keluarga_id', 'nik', 'nama_lengkap', 'jenis_kelamin', 'tempat_lahir', 
        'tanggal_lahir', 'agama', 'status_perkawinan', 'status_hubungan_keluarga', 
        'pendidikan_terakhir', 'pekerjaan', 'golongan_darah', 'nama_ayah', 
        'nama_ibu', 'aktif', 'keterangan',
    ];

    protected $casts = ['aktif' => 'boolean'];
    
    public function getNameAttribute(): string
    {
        return $this->attributes['nama_lengkap'];
    }
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Warga')
            ->logOnly(array_merge($this->fillable, ['aktif']))
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Data warga '{$this->nama_lengkap}' telah di-{$this->getEventDescription($eventName)}");
    }

    protected function getEventDescription(string $eventName): string
    {
        return match ($eventName) {
            'created' => 'tambahkan',
            'updated' => 'perbarui',
            'deleted' => 'hapus',
            default   => 'lakukan aksi',
        };
    }

    public function kartuKeluarga(): BelongsTo
    {
        return $this->belongsTo(KartuKeluarga::class);
    }
    
    public function histori(): HasMany
    {
        return $this->hasMany(HistoryKependudukan::class);
    }
}

