<?php

namespace App\Exports;

use App\Models\Warga;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class WargaExport implements FromCollection, WithHeadings, WithMapping
{
    protected $warga;

    /**
     * Menerima koleksi data warga yang sudah difilter dari controller.
     *
     * @param \Illuminate\Support\Collection $wargas
     */
    public function __construct($warga)
    {
        $this->warga = $warga;
    }

    /**
     * Mengembalikan koleksi data yang akan diekspor.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->warga;
    }

    /**
     * Menentukan judul (header) untuk setiap kolom di file Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'NIK',
            'Nama Lengkap',
            'Nomor KK',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Usia (Tahun)',
            'Agama',
            'Pendidikan Terakhir',
            'Pekerjaan',
            'Status Perkawinan',
            'Status Hubungan Keluarga',
            'Alamat',
            'RT',
            'RW',
            'Dusun',
        ];
    }

    /**
     * Memetakan data dari setiap model Warga ke baris Excel.
     *
     * @param mixed $warga
     * @return array
     */
    public function map($warga): array
    {
        return [
            "'" . $warga->nik, // Tambahkan petik tunggal agar NIK dibaca sebagai teks
            $warga->nama_lengkap,
            "'" . ($warga->kartuKeluarga->nomor_kk ?? '-'),
            $warga->jenis_kelamin,
            $warga->tempat_lahir,
            Carbon::parse($warga->tanggal_lahir)->format('d-m-Y'),
            Carbon::parse($warga->tanggal_lahir)->age,
            $warga->agama,
            $warga->pendidikan_terakhir,
            $warga->pekerjaan,
            $warga->status_perkawinan,
            $warga->status_hubungan_keluarga,
            $warga->kartuKeluarga->alamat ?? '-',
            $warga->kartuKeluarga->rt ?? '-',
            $warga->kartuKeluarga->rw ?? '-',
            $warga->kartuKeluarga->dusun ?? '-',
        ];
    }
}
