<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use HasFactory, Notifiable, LogsActivity;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nik',
        'name',
        'email',
        'password',
        'jabatan',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'profile_photo_path',
        'role',
        'status',
        'last_login_at',
        'no_hp',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Metode ini akan membuat deskripsi log secara dinamis.
     * Ini dipanggil secara otomatis oleh package activitylog.
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        // Hanya buat deskripsi kustom untuk event 'updated'
        if ($eventName === 'updated') {
            // getChanges() adalah helper dari trait LogsActivity untuk mendapatkan
            // data 'attributes' (nilai baru) dan 'old' (nilai lama).
            $properties = $this->getChanges();
            $attributes = $properties['attributes'] ?? [];

            // Jika tidak ada atribut yang berubah, kembalikan deskripsi umum.
            if (empty($attributes)) {
                return "Memperbarui data pengguna \"{$this->name}\"";
            }

            // Ambil nama field yang berubah
            $changedFields = array_keys($attributes);

            // Fungsi untuk menerjemahkan nama field
            $translate = function (string $field) {
                return match ($field) {
                    'nik' => 'NIK',
                    'name' => 'Nama',
                    'email' => 'Email',
                    'jabatan' => 'Jabatan',
                    'jenis_kelamin' => 'Jenis Kelamin',
                    'tanggal_lahir' => 'Tanggal Lahir',
                    'alamat' => 'Alamat',
                    'no_hp' => 'Nomor HP',
                    'profile_photo_path' => 'Foto Profil',
                    'role' => 'Role',
                    'status' => 'Status',
                    'password' => 'Password',
                    'last_login_at' => 'Waktu Login Terakhir',
                    default => ucwords(str_replace('_', ' ', $field)),
                };
            };

            // Terjemahkan nama field dan gabungkan dengan koma
            $translatedChanges = collect($changedFields)->map($translate)->implode(', ');

            return "Memperbarui data pengguna \"{$this->name}\" (mengubah: {$translatedChanges})";
        }

        // Deskripsi fallback untuk event lain seperti 'created' atau 'deleted'
        $eventMap = [
            'created' => 'dibuat',
            'deleted' => 'dihapus',
        ];
        $eventAction = $eventMap[$eventName] ?? $eventName;

        return "Data pengguna \"{$this->name}\" telah di-{$eventAction}";
    }

    /**
     * Konfigurasi log aktivitas untuk model User.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'nik',
                'name',
                'email',
                'jabatan',
                'jenis_kelamin',
                'tanggal_lahir',
                'alamat',
                'no_hp',
                'profile_photo_path',
                'role',
                'status',
                'password',
                'last_login_at',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->dontLogIfAttributesChangedOnly(['remember_token'])
            ->useLogName('user');
    }
}
