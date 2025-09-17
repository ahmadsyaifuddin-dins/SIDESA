<?php

namespace App\Imports;

use App\Models\HistoryKependudukan;
use App\Models\KartuKeluarga;
use App\Models\Warga;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;

class WargaImport implements ToCollection, WithStartRow, WithBatchInserts, WithChunkReading
{
    private $currentKk = null;
    public int $wargaBerhasilDiimpor = 0;

    public function startRow(): int
    {
        return 1;
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {
            foreach ($rows as $row) {
                try {
                    // --- LOGIKA BARU YANG LEBIH KETAT ---

                    // 1. Cek apakah ini baris DATA WARGA yang valid (punya NIK numerik)
                    if (isset($row[1]) && is_numeric($row[1]) && strlen(trim($row[1])) > 5) {
                        
                        // Pastikan KK sudah terdeteksi sebelum memproses warga
                        if (!$this->currentKk) {
                            Log::warning('Melewati baris warga karena header KK belum ditemukan.', ['row' => $row->toArray()]);
                            continue;
                        }

                        $warga = Warga::updateOrCreate(
                            ['nik' => trim($row[1])],
                            [
                                'kartu_keluarga_id' => $this->currentKk->id,
                                'nama_lengkap' => trim($row[2]),
                                'jenis_kelamin' => $this->formatJenisKelamin(trim($row[3])),
                                'tempat_lahir' => trim($row[4]),
                                'tanggal_lahir' => $this->formatTanggal($row[5]),
                                'golongan_darah' => trim($row[6]) === '-' ? null : trim($row[6]),
                                'agama' => trim($row[7]),
                                'status_perkawinan' => $this->formatStatusKawin(trim($row[8])),
                                'status_hubungan_keluarga' => trim($row[9]),
                                'pendidikan_terakhir' => trim($row[10]),
                                'pekerjaan' => trim($row[11]),
                                'nama_ibu' => trim($row[12]),
                                'nama_ayah' => trim($row[13]),
                            ]
                        );
                        
                        $this->wargaBerhasilDiimpor++;

                        if (strtolower(trim($row[9])) === 'kepala keluarga') {
                            $this->currentKk->update(['kepala_keluarga_id' => $warga->id]);
                        }

                        HistoryKependudukan::firstOrCreate(
                            ['warga_id' => $warga->id, 'peristiwa' => 'LAHIR'],
                            [
                                'tanggal_peristiwa' => $warga->tanggal_lahir,
                                'detail_peristiwa' => 'Data awal diimpor dari Excel.',
                                'created_by' => Auth::id(),
                            ]
                        );

                    } 
                    // 2. Jika bukan baris data, cek apakah ini baris HEADER yang kita butuhkan
                    elseif (isset($row[8])) {
                        $headerKey = trim($row[8]);

                        if (str_contains($headerKey, 'NO. KK') && isset($row[9])) {
                            $nomorKk = trim($row[9]);
                            if ($nomorKk) {
                                $this->currentKk = KartuKeluarga::firstOrCreate(
                                    ['nomor_kk' => $nomorKk],
                                    [
                                        'alamat' => 'ANJIR MUARA KOTA TENGAH',
                                        'desa_kelurahan' => 'ANJIR MUARA KOTA TENGAH',
                                        'kecamatan' => 'ANJIR MUARA',
                                        'kabupaten_kota' => 'KAB. BARITO KUALA',
                                        'provinsi' => 'KALIMANTAN SELATAN',
                                        'kode_pos' => '70564',
                                        'rt' => '001',
                                        'rw' => '001',
                                    ]
                                );
                            }
                        }

                        if ($this->currentKk && str_contains($headerKey, 'ALAMAT') && isset($row[9])) {
                            $fullAlamatString = $row[9];
                            $alamatParts = explode(',', $fullAlamatString);
                            $specificAlamat = isset($alamatParts[0]) ? trim($alamatParts[0]) : $this->currentKk->alamat;
                            $this->currentKk->update(['alamat' => $specificAlamat]);
                        }

                        if ($this->currentKk && str_contains($headerKey, 'NO.RT') && isset($row[9])) {
                            $this->currentKk->update(['rt' => trim($row[9])]);
                        }
                    }
                    // 3. Jika bukan keduanya (misal baris 'KABUPATEN:', 'NAMA. KK:', dll), maka akan otomatis diabaikan.

                } catch (\Throwable $e) {
                    Log::error('Gagal impor baris: ' . json_encode($row) . ' Error: ' . $e->getMessage());
                    continue;
                }
            }
        });
    }

    private function formatJenisKelamin($value)
    {
        $v = strtoupper($value);
        if ($v === 'L') return 'LAKI-LAKI';
        if ($v === 'P') return 'PEREMPUAN';
        return null;
    }

    private function formatStatusKawin($value)
    {
        $v = strtolower($value);
        if ($v === 'kawin') return 'KAWIN';
        if ($v === 'belum kawin') return 'BELUM KAWIN';
        if ($v === 'cerai hidup') return 'CERAI HIDUP';
        if ($v === 'cerai mati') return 'CERAI MATI';
        return 'BELUM KAWIN';
    }

    private function formatTanggal($excelDate)
    {
        if (preg_match("/^\d{4}-\d{2}-\d{2}$/", (string) $excelDate)) {
            return $excelDate;
        }
        if (is_numeric($excelDate)) {
            try {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($excelDate)->format('Y-m-d');
            } catch (\Exception $e) {
                return now()->subYears(30)->format('Y-m-d');
            }
        }
        return now()->subYears(30)->format('Y-m-d');
    }
}

